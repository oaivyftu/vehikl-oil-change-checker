<?php

namespace Tests\Unit;

use App\Models\OilChangeCheck;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class OilChangeCheckTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_it_calculates_kilometers_since_the_previous_oil_change(): void
    {
        $check = $this->oilChangeCheck(currentOdometer: 15_500);

        $this->assertSame(5_500, $check->kilometersSincePreviousOilChange());
    }

    public function test_it_is_over_the_kilometer_limit_only_after_5000_kilometers(): void
    {
        $this->assertFalse(
            $this->oilChangeCheck(currentOdometer: 15_000)->isOverKilometerLimit()
        );
        $this->assertTrue(
            $this->oilChangeCheck(currentOdometer: 15_001)->isOverKilometerLimit()
        );
    }

    public function test_it_is_over_the_time_limit_only_after_six_months(): void
    {
        Carbon::setTestNow('2026-06-19');

        $this->assertFalse(
            $this->oilChangeCheck(previousOilChangeDate: '2025-12-19')->isOverTimeLimit()
        );
        $this->assertTrue(
            $this->oilChangeCheck(previousOilChangeDate: '2025-12-18')->isOverTimeLimit()
        );
    }

    public function test_it_is_due_when_either_limit_is_exceeded(): void
    {
        Carbon::setTestNow('2026-06-19');

        $this->assertFalse($this->oilChangeCheck()->isDueForOilChange());
        $this->assertTrue(
            $this->oilChangeCheck(currentOdometer: 15_001)->isDueForOilChange()
        );
        $this->assertTrue(
            $this->oilChangeCheck(previousOilChangeDate: '2025-12-18')->isDueForOilChange()
        );
    }

    public function test_it_returns_all_due_reasons(): void
    {
        Carbon::setTestNow('2026-06-19');

        $check = $this->oilChangeCheck(
            currentOdometer: 15_001,
            previousOilChangeDate: '2025-12-18',
        );

        $this->assertSame(
            ['kilometer_limit', 'time_limit'],
            $check->dueReasons()
        );
    }

    private function oilChangeCheck(
        int $currentOdometer = 15_000,
        string $previousOilChangeDate = '2026-01-01',
    ): OilChangeCheck {
        return new OilChangeCheck([
            'current_odometer' => $currentOdometer,
            'previous_oil_change_date' => $previousOilChangeDate,
            'previous_oil_change_odometer' => 10_000,
        ]);
    }
}
