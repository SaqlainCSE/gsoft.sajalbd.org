<?php

namespace App\Traits;

use App\Models\User;
use App\Scopes\MacResellerScope;

trait MacResellerTrait
{
    public static function bootMacResellerTrait()
    {
        static::creating(function ($model) {
            if (\Auth::user()->user_type === User::TYPE_RESELLER) {
                $model->macr_id = \Auth::user()->macReseller->id;
            }
        });

        static::addGlobalScope(new MacResellerScope);
    }
}
