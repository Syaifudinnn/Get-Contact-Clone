<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag',
        'user_id',
        'contact_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'contact_id' => 'integer',
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
     * Relationship with Contact model.
     *
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
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
    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = self::normalizePhoneNumber($value);
    }

    /**
     * Validate if the tag already exists for the same client and phone number.
     *
     * @param string $phoneNumber
     * @param string $tag
     * @param int $user_id
     * @return bool
     */
    public static function isDuplicate($phoneNumber, $tag, $userId): bool
    {
        return self::where('phone_number', $phoneNumber)
            ->where('tag', $tag)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Scope to find tags by phone number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $phoneNumber
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByPhoneNumber($query, $phoneNumber)
    {
        return $query->where('phone_number', $phoneNumber);
    }
}
