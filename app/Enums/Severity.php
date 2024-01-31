<?php

namespace App\Enums;

enum Severity {
    case Low;
    case Medium;
    case High;
    case Critical;

    public function value(): int
    {
        return match($this) {
            self::Low => 1,
            self::Medium => 2,
            self::High, self::Critical => 3,
        };
    }
    public function label(): string
    {
        return $this->name;
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
