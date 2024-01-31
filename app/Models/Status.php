<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    use HasAuthor;

    protected $guarded = ['id'];

    const NO_IMPACT = [
        'code' => 'no-impact',
        'name' => 'Sin impacto',
    ];
    const PENDING = [
        'code' => 'pending',
        'name' => 'Pendiente',
    ];
    const ON_SCHEDULE = [
        'code' => 'on-schedule',
        'name' => 'En Plazo',
    ];
    const ASSUMED = [
        'code' => 'assumed',
        'name' => 'Asumido',
    ];
    const MITIGATED = [
        'code' => 'mitigated',
        'name' => 'Mitigado',
    ];

    const ALL = [
        self::NO_IMPACT,
        self::PENDING,
        self::ON_SCHEDULE,
        self::ASSUMED,
        self::MITIGATED,
    ];

    const STATICS = [
        self::NO_IMPACT,
        self::ASSUMED,
        self::MITIGATED,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getNoImpactStatusId(): int
    {
        return self::getStatusIdByCode(self::NO_IMPACT['code']);
    }

    public static function getPendingStatusId(): int
    {
        return self::getStatusIdByCode(self::PENDING['code']);
    }

    public static function getOnScheduleStatusId(): int
    {
        return self::getStatusIdByCode(self::ON_SCHEDULE['code']);
    }

    private static function getStatusIdByCode(string $code): int
    {
        return optional(
            self::query()
                ->where('code', $code)
                ->select('id', 'code')
                ->first()
        )->id;
    }

}
