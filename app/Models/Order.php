<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'payment_method',
        'payment_status',
        'address_id',
        'status_id',
        'total_price'
    ];

    /**
     * Get the user associated with the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the address associated with the order.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the stutus associated with the order.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the books associated with the order.
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->withPivot('quantity', 'price', 'discount');
    }

    /**
     * Check the status associated with the order.
     */
    public function hasStatus($status)
    {
        return $this->status->name == $status;
    }

    /**
     * Get the voucher associated with the order.
     */
    public function voucher(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
