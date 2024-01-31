<?php

namespace App\Services;

class DetermineCriticalityService
{
    public function handle(string $criticality): string
    {
        $criticality = strtolower(trim(preg_replace('/\s+/', ' ', $criticality)));

        return match ($criticality) {
            'bajo', 'baja' => 'Low',
            'medio bajo', 'media bajo', 'medio baja', 'media baja' => 'MediumLow',
            'medio', 'media' => 'Medium',
            'medio alto', 'media alto', 'medio alta', 'media alta' => 'MediumHigh',
            'alto', 'alta' => 'High',
            default => 'Medium'
        };
    }
}
