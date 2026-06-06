<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BranchOrNullTrait
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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->branch_id = optional(auth()->user())->branch_id;
        });
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('branch', function (Builder $builder) {
            if (Auth::check() && Auth::user()->user_type != User::TYPE_SUPER_ADMIN) {
                $builder->where('branch_id', Auth::user()->branch_id)
                    ->orWhereNull('branch_id');
            }
        });
    }
}
