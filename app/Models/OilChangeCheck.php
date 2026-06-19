<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OilChangeCheck extends Model
{
    public const KILOMETER_LIMIT = 5000;

    public const MONTH_LIMIT = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'current_odometer',
        'previous_oil_change_date',
        'previous_oil_change_odometer',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'previous_oil_change_date' => 'date',
        ];
    }

    public function kilometersSincePreviousOilChange(): int
    {
        return $this->current_odometer - $this->previous_oil_change_odometer;
    }

    public function isOverKilometerLimit(): bool
    {
        return $this->kilometersSincePreviousOilChange() > self::KILOMETER_LIMIT;
    }

    public function isOverTimeLimit(): bool
    {
        return $this->previous_oil_change_date->isBefore(
            today()->subMonthsNoOverflow(self::MONTH_LIMIT)
        );
    }

    public function isDueForOilChange(): bool
    {
        return $this->isOverKilometerLimit() || $this->isOverTimeLimit();
    }

    /**
     * @return list<string>
     */
    public function dueReasons(): array
    {
        $reasons = [];

        if ($this->isOverKilometerLimit()) {
            $reasons[] = 'kilometer_limit';
        }

        if ($this->isOverTimeLimit()) {
            $reasons[] = 'time_limit';
        }

        return $reasons;
    }
}
