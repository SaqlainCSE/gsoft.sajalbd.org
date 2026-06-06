<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Wildside\Userstamps\Userstamps;

/**
 * Class Client
 *
 * @property $id
 * @property $client_no
 * @property $name
 * @property $mobile_number
 * @property $address
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Client extends Model implements HasMedia
{
  use SoftDeletes;
  use Userstamps;
  use InteractsWithMedia;

  static $rules = [
    'name' => 'required',
    'mobile_number' => [
      'required',
      'unique:clients,mobile_number',
      //'phone:BD'
    ],
    'address' => ['nullable', 'string'],
    'customer_category_id' => ['nullable', 'integer'],
    'district_id' => ['required', 'integer'],
    'zone_id' => ['nullable', 'integer'],
    'fb_name' => ['nullable', 'string'],
    'due_amount' => ['nullable'],
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'mobile_number',
    'address',
    'customer_category_id',
    'district_id',
    'zone_id',
    'fb_name',
    'due_amount'
  ];

  /**
   * Get the category that owns the Client
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(CustomerCategory::class, 'customer_category_id');
  }

  /**
   * Get the district that owns the Client
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(District::class);
  }

  /**
   * Get the zone that owns the Client
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function zone(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Zone::class);
  }

  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('photo')
      ->singleFile()
      ->useFallbackUrl(asset('/mock-images/avatars/avatar_default.jpg'))
      ->useFallbackPath(public_path('/mock-images/c/avatar_default.jpg'))
      ->acceptsMimeTypes(['image/jpeg', 'image/png']);
  }

  public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
      return $this->hasMany(Transaction::class);
  }

}
