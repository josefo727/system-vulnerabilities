<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasAuthor
{
    /**
     * @return void
     */
    protected static function bootHasAuthor(): void
    {
        static::creating(function ($model) {
            $model->user_id = Auth::check() ? Auth::id() : User::query()->first()->id;
        });
    }
}

