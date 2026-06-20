<?php

namespace Tests\Feature;

use Tests\TestCase;

class OilChangeCheckFormTest extends TestCase
{
    public function test_the_home_page_loads_the_oil_change_check_form(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertViewIs('oil-change-checks.create')
            ->assertSee('action="'.route('oil-change-checks.store').'"', false)
            ->assertSee('name="current_odometer"', false)
            ->assertSee('name="previous_oil_change_date"', false)
            ->assertSee('name="previous_oil_change_odometer"', false);
    }

    public function test_missing_fields_show_validation_errors(): void
    {
        $response = $this->from('/')->post('/check');

        $response
            ->assertRedirect('/')
            ->assertSessionHasErrors([
                'current_odometer',
                'previous_oil_change_date',
                'previous_oil_change_odometer',
            ]);
    }

    public function test_current_odometer_cannot_be_lower_than_the_previous_odometer(): void
    {
        $response = $this->from('/')->post('/check', [
            'current_odometer' => 49_999,
            'previous_oil_change_date' => today()->subMonth()->toDateString(),
            'previous_oil_change_odometer' => 50_000,
        ]);

        $response
            ->assertRedirect('/')
            ->assertSessionHasErrors('current_odometer')
            ->assertSessionHasInput('current_odometer', 49_999)
            ->assertSessionHasInput('previous_oil_change_odometer', 50_000);
    }

    public function test_today_and_future_oil_change_dates_fail_validation(): void
    {
        $validOdometers = [
            'current_odometer' => 50_000,
            'previous_oil_change_odometer' => 45_000,
        ];

        $this->from('/')->post('/check', [
            ...$validOdometers,
            'previous_oil_change_date' => today()->toDateString(),
        ])->assertSessionHasErrors('previous_oil_change_date');

        $this->from('/')->post('/check', [
            ...$validOdometers,
            'previous_oil_change_date' => today()->addDay()->toDateString(),
        ])->assertSessionHasErrors('previous_oil_change_date');
    }
}
