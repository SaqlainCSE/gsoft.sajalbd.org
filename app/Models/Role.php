<?php

namespace App\Models;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;
use Wildside\Userstamps\Userstamps;

class Role extends SpatieRole
{
    use Userstamps;
    use GeneratesUuid;
    use BindsOnUuid;
    use SoftDeletes;

    const SUPPER_ADMIN = 'Super Admin';
    const BRANCH_SUPER_ADMIN = 'Admin';
    const BRANCH_AGENT = 'Employee';

    protected $fillable = ['name', 'guard_name', 'uuid', 'is_delete_able'];

    protected $casts = [
        'name' => 'string',
        'uuid' => EfficientUuid::class
    ];
}
