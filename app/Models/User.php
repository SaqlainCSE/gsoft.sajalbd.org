<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Wildside\Userstamps\Userstamps;

class User extends Authenticatable implements HasMedia
{
  use HasApiTokens,
    HasFactory,
    Notifiable,
    HasRoles,
    Userstamps,
    SoftDeletes,
    InteractsWithMedia;

  const STATUS_BLOCK = 0;
  const STATUS_ACTIVE = 1;

  public $excludeLogging = true;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'is_active',
    'username',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'last_login_at' => 'datetime',
    'user_type' => 'integer',
  ];

  public function registerMediaCollections(): void
  {
    $this
      ->addMediaCollection('avatars')
      ->useFallbackUrl('/images/anonymous-user.jpg')
      ->useFallbackPath(public_path('/images/anonymous-user.jpg'));
  }
}
