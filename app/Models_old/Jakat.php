<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jakat extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'data', 'generate_id'];

    protected $casts = [
        'data' => 'array'
    ];

    /**
     * Get the client that owns the Jakat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
