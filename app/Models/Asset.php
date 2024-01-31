<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasAuthor;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function network(): BelongsTo
    {
        return $this->belongsTo(Network::class);
    }

    public function getAssetIdByName(string $name): int
    {
        $name = strtolower(trim(preg_replace('/\s+/', ' ', $name)));

        return optional(self::query()->whereRaw('LOWER(name) = ?', [$name])->first())->id;
    }
}
