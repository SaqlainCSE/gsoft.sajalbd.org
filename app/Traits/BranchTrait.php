<?php

namespace App\Traits;

use App\Models\Branch;
use App\Scopes\BranchScope;

trait BranchTrait
{
    /**
     * Get the branch that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public static function bootBranchTrait()
    {
        static::creating(function ($model) {
            if (\Auth::check()) {
                $model->branch_id = auth()->user()->branch_id;
            }
        });

        static::updated(function ($model) {
            self::flushCache($model);
        });

        static::created(function ($model) {
            self::flushCache($model);
        });

        static::deleted(function ($model) {
            self::flushCache($model);
        });

        static::addGlobalScope(new BranchScope);
    }

    /**
     * Flush the cache
     */
    public static function flushCache($model)
    {
        //
    }
}
