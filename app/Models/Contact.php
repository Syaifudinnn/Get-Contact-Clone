<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_name',
        'contact_phone',
        'tag',
        'client_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
    ];

    /**
     * Relationship with Client model.
     *
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Normalize phone number before saving to database.
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
     * Set the contact phone attribute.
     *
     * @param string $value
     * @return void
     */
    public function setContactPhoneAttribute($value)
    {
        $this->attributes['contact_phone'] = self::normalizePhoneNumber($value);
    }

    /**
     * Validate if the phone number already exists for the same client.
     *
     * @param string $phone
     * @param int $clientId
     * @return bool
     */
    public static function isDuplicate($phone, $clientId): bool
    {
        $normalizedPhone = self::normalizePhoneNumber($phone);
        return self::where('contact_phone', $normalizedPhone)
            ->where('client_id', $clientId)
            ->exists();
    }

    /**
     * Scope to find contact by phone number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $phone
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByPhoneNumber($query, $phone)
    {
        $normalizedPhone = self::normalizePhoneNumber($phone);
        return $query->where('contact_phone', $normalizedPhone);
    }
}
