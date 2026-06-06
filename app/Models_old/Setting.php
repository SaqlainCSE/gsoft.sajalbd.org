<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Class Setting
 *
 * @property $id
 * @property $key
 * @property $value
 * @property $created_at
 * @property $updated_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Setting extends Model
{

  use Userstamps;

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['key', 'value'];

  protected $casts = [
    'value' => 'json',
  ];

  /**
   * Determine if the given option value exists.
   *
   * @param  string  $key
   * @return bool
   */
  public function exists($key)
  {
    return self::where('key', $key)->exists();
  }

  /**
   * Get the specified option value.
   *
   * @param  string  $key
   * @param  mixed  $default
   * @return mixed
   */
  public function get($key, $default = null, $branch_id = null)
  {
    $option = self::where('key', $key)
      ->when($branch_id, fn ($q) => $q->where('branch_id', $branch_id))
      ->first();

    if ($option) {
      return $option->value;
    }

    return $default;
  }

  /**
   * Set a given option value.
   *
   * @param  array|string  $key
   * @param  mixed  $value
   * @return void
   */
  public function set($key, $value = null)
  {
    $keys = is_array($key) ? $key : [$key => $value];

    foreach ($keys as $key => $value) {
      self::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    // @todo: return the option
  }

  /**
   * Remove/delete the specified option value.
   *
   * @param  string  $key
   * @return bool
   */
  public function remove($key)
  {
    return (bool) self::where('key', $key)->delete();
  }
}
