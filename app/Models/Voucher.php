<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    use CrudTrait;
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'code',
        'image_path',
        'value',
        'expiration_date'
    ];

    /**
     * Get the order associated with the voucher.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
