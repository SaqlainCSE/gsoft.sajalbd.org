<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 *
 * @property $id
 * @property $date
 * @property $memo
 * @property $token
 * @property $client_id
 * @property $unit_18k
 * @property $unit_21k
 * @property $unit_22k
 * @property $st
 * @property $d18k
 * @property $dia
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Stock extends Model
{
  const TYPE_NEW = 1;
  const TYPE_SALE = 2;
  const TYPE_EXCHANGE = 3;
  const TYPE_RETURN = 4;
  const TYPE_OLD = 5;

  static $rules = [
    'date' => 'required',
    'memo' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = [
    'date', 
    'memo', 
    'token', 
    'client_id', 
    'unit_18k', 
    'unit_21k', 
    'unit_22k', 
    'st', 
    'd18k', 
    'dia',
    'type',
    'trx_type'
  ];
}
