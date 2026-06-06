<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Module extends Model
{
    use Userstamps;

    protected $fillable = ['name', 'status'];

    protected $casts = [
        'name' => "string",
        'active' => "boolean",
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class)->select('module_id', 'name');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('active', 1);
    }
}
