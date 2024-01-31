<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Network extends Model
{
    use HasAuthor;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function getNetworkIdByName(string $name): int
    {
        $name = strtolower(trim(preg_replace('/\s+/', ' ', $name)));

        return optional(self::query()->whereRaw('LOWER(name) = ?', [$name])->first())->id;
    }
}
