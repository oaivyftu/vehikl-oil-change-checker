<?php

namespace Tests\Feature;

use App\Models\OilChangeCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class OilChangeCheckResultTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_a_valid_submission_creates_a_database_record(): void
    {
        $this->post('/check', $this->validInput());

        $this->assertDatabaseHas('oil_change_checks', [
            'current_odometer' => 15_000,
            'previous_oil_change_date' => '2026-05-01 00:00:00',
            'previous_oil_change_odometer' => 10_000,
        ]);
    }

    public function test_valid_submissions_redirect_to_unique_result_pages(): void
    {
        $firstResponse = $this->post('/check', $this->validInput());
        $firstCheck = OilChangeCheck::sole();

        $secondResponse = $this->post('/check', [
            ...$this->validInput(),
            'current_odometer' => 20_000,
        ]);
        $secondCheck = OilChangeCheck::latest('id')->firstOrFail();

        $firstResponse->assertRedirect(route('oil-change-checks.show', $firstCheck));
        $secondResponse->assertRedirect(route('oil-change-checks.show', $secondCheck));
        $this->assertNotSame($firstCheck->id, $secondCheck->id);
    }

    public function test_the_result_page_displays_the_original_input(): void
    {
        $check = OilChangeCheck::create($this->validInput());

        $this->get(route('oil-change-checks.show', $check))
            ->assertOk()
            ->assertSee('15000 km')
            ->assertSee('2026-05-01')
            ->assertSee('10000 km')
            ->assertSee('5000 km')
            ->assertSee('Check another vehicle');

        $this->get(route('oil-change-checks.show', $check))
            ->assertOk()
            ->assertSee('2026-05-01');
    }

    public function test_the_result_is_due_when_over_5000_kilometers(): void
    {
        $check = OilChangeCheck::create([
            ...$this->validInput(),
            'current_odometer' => 15_001,
        ]);

        $this->get(route('oil-change-checks.show', $check))
            ->assertOk()
            ->assertSee('Oil change due')
            ->assertSee('More than 5,000 km have passed');
    }

    public function test_the_result_is_due_when_over_six_months(): void
    {
        Carbon::setTestNow('2026-06-19');

        $check = OilChangeCheck::create([
            ...$this->validInput(),
            'previous_oil_change_date' => '2025-12-18',
        ]);

        $this->get(route('oil-change-checks.show', $check))
            ->assertOk()
            ->assertSee('Oil change due')
            ->assertSee('More than 6 months have passed');
    }

    public function test_the_result_is_not_due_when_neither_limit_is_exceeded(): void
    {
        Carbon::setTestNow('2026-06-19');

        $check = OilChangeCheck::create($this->validInput());

        $this->get(route('oil-change-checks.show', $check))
            ->assertOk()
            ->assertSee('Oil change not due')
            ->assertSee('Neither the kilometer limit nor the time limit has been exceeded.');
    }

    /**
     * @return array<string, int|string>
     */
    private function validInput(): array
    {
        return [
            'current_odometer' => 15_000,
            'previous_oil_change_date' => '2026-05-01',
            'previous_oil_change_odometer' => 10_000,
        ];
    }
}
