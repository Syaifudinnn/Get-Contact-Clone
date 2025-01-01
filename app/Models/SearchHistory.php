<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'searched_at',
        'client_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'searched_at' => 'timestamp',
        'client_id' => 'integer',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Normalize phone number before saving.
     *
     * @param string $phone
     * @return string
     */
    public static function normalizePhoneNumber($phone): string
    {
        if (str_starts_with($phone, '08')) {
            $phone = '+62' . substr($phone, 1);
        }
        return $phone;
    }

    /**
     * Set the phone_number attribute with normalization.
     *
     * @param string $value
     */
    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = self::normalizePhoneNumber($value);
    }

    /**
     * Scope to find search history by phone number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $phone
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByPhoneNumber($query, $phone)
    {
        $normalizedPhone = self::normalizePhoneNumber($phone);
        return $query->where('phone_number', $normalizedPhone);
    }
}
