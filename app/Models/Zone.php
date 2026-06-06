<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Zone
 *
 * @property $id
 * @property $name
 * @property $district_id
 * @property $note
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Zone extends Model
{
    
    static $rules = [
      'name' => 'required',
      'district_id' => 'required',
      'status' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','district_id','note','status'];

    /**
     * Get the user that owns the Zone
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(District::class);
    }

}
