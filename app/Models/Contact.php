<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Relationship with Client model.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with SpamReport model.
     *
     * @return HasMany
     */
    public function spamReports(): HasMany
    {
        return $this->hasMany(SpamReport::class);
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
     * @param int $userId
     * @return bool
     */
    public static function isDuplicate($phone, $userId): bool
    {
        $normalizedPhone = self::normalizePhoneNumber($phone);
        return self::where('contact_phone', $normalizedPhone)
            ->where('user_id', $userId)
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
