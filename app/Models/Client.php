<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Relasi hasMany untuk Contact.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Relasi hasMany untuk SearchHistory.
     */
    public function searchHistories()
    {
        return $this->hasMany(SearchHistory::class);
    }

    /**
     * Relasi hasMany untuk SpamReport.
     */
    public function spamReports()
    {
        return $this->hasMany(SpamReport::class);
    }

    /**
     * Relasi hasOne untuk Setting.
     */
    public function setting(): HasOne
    {
        return $this->hasOne(Setting::class);
    }

    /**
     * Normalize phone number before searching or saving.
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
     * Scope to find client by phone number.
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

    /**
     * Mutator to normalize phone number before saving.
     *
     * @param string $value
     */
    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = self::normalizePhoneNumber($value);
    }

    protected static function booted()
    {
        static::saved(function ($client) {
            // Cek jika setting untuk client belum ada
            if (!$client->setting) {
                Setting::create([
                    'client_id' => $client->id,
                    'spam_protection_enabled' => false,  // Nilai default
                    'tag_visibility' => 'public',      // Nilai default
                ]);
            }
        });
    }
}
