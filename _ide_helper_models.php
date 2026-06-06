<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int|null $customer_category_id
 * @property int|null $district_id
 * @property int|null $zone_id
 * @property-read \App\Models\CustomerCategory|null $category
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\District|null $district
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Zone|null $zone
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Query\Builder|Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereClientNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCustomerCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereZoneId($value)
 * @method static \Illuminate\Database\Query\Builder|Client withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Client withoutTrashed()
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * Class CustomerCategory
 *
 * @property $id
 * @property $name
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory whereUpdatedAt($value)
 */
	class CustomerCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Module
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Module active()
 * @method static \Illuminate\Database\Eloquent\Builder|Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereUpdatedBy($value)
 */
	class Module extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $client_id
 * @property string $cash_memo_no
 * @property string $date
 * @property float $vat
 * @property float $discount
 * @property float $paid
 * @property float|null $due
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int|null $sale_type_id
 * @property float|null $total
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderMeta[] $meta
 * @property-read int|null $meta_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderPaymentInfo[] $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\SaleType|null $saleType
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCashMemoNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSaleTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereVat($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderMeta
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property float $weight
 * @property float $unit_price
 * @property float $wage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $vat_amount
 * @property float|null $total
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereWeight($value)
 */
	class OrderMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderPaymentInfo
 *
 * @property int $id
 * @property int $order_id
 * @property string $payment
 * @property string|null $payment_info
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo wherePaymentInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInfo whereUpdatedAt($value)
 */
	class OrderPaymentInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * Class PaymentMethod
 *
 * @property $id
 * @property $name
 * @property $created_at
 * @property $updated_at
 * @property $status
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property int $module_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Module|null $module
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Product
 *
 * @property $id
 * @property $product_nr
 * @property $product_details
 * @property $weight
 * @property $price
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property float|null $wage
 * @property string $wage_type
 * @property string|null $status
 * @property string|null $booking_number
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBookingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property mixed|null $uuid
 * @property int|null $branch_id
 * @property string $name
 * @property string $guard_name
 * @property int $is_delete_able
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIsDeleteAble($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SaleType
 *
 * @property $id
 * @property $name
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static \Illuminate\Database\Eloquent\Builder|SaleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleType whereUpdatedAt($value)
 */
	class SaleType extends \Eloquent {}
}

namespace App\Models{
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
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int|null $branch_id
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TermsCondition
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TermsCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermsCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermsCondition query()
 */
	class TermsCondition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $username
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property-read User|null $creator
 * @property-read User|null $destroyer
 * @property-read User|null $editor
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
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
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property-read \App\Models\District|null $district
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone query()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereUpdatedAt($value)
 */
	class Zone extends \Eloquent {}
}

