<?php

namespace App\Enums;

enum Criticality: int {
    case Low = 1;
    case MediumLow = 2;
    case Medium = 3;
    case MediumHigh = 4;
    case High = 5;

    public function label(): string
    {
        return match($this) {
            self::Low => 'Bajo',
            self::MediumLow => 'Medio Bajo',
            self::Medium => 'Medio',
            self::MediumHigh => 'Medio Alto',
            self::High => 'Alto',
        };
    }

    /**
     * @return array<<missing>,string>
     */
    public static function allForSelect(): array
    {
        $criticalities = self::cases();

        $data = [];

        foreach ($criticalities as $criticality) {
            $data[$criticality->name] = $criticality->label();

        }
        return $data;
    }

    public static function nameFromLabel(string $label): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->label() === $label) {
                return $case->name;
            }
        }

        return null;
    }
}
