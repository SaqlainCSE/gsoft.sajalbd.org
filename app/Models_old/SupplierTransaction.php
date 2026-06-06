<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class SupplierTransaction extends Model
{
    use Userstamps;

    static $rules = [
        'reference_no' => 'required',
        'supplier_id' => 'required',
        'advanced' => ['nullable', 'numeric'],
        'bill_amount' => ['nullable', 'required_if:advanced,null', 'numeric'],
        'payment_amount' => ['nullable', 'required_if:advanced,null', 'numeric'],
        'description' => ['nullable', 'string'],
      ];
    
      protected $perPage = 20;
    
      /**
       * Attributes that should be mass-assignable.
       *
       * @var array
       */
      protected $fillable = [
        'reference_no',
        'supplier_id',
        'description',
        'bill_amount',
        'payment_amount',
        'advanced'
      ];
    
  
      public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
      {
        return $this->belongsTo(Supplier::class);
      }
}
