<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasApiTokens, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasVerifiedEmail();
    }

    /**
     * Relasi hasMany untuk Contact.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Relasi hasMany untuk Tag.
     */
    public function tags()
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
        static::saved(function ($user) {
            // Cek jika setting untuk client belum ada
            if (!$user->setting) {
                Setting::create([
                    'user_id' => $user->id,
                    'spam_protection_enabled' => false,
                    'tag_visibility' => 'public',
                ]);
            }
        });
    }
}
