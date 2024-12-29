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

    // Relasi hasMany untuk Contact
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // Relasi hasMany untuk SearchHistory
    public function searchHistories()
    {
        return $this->hasMany(SearchHistory::class);
    }

    // Relasi hasMany untuk SpamReport
    public function spamReports()
    {
        return $this->hasMany(SpamReport::class);
    }

    // Relasi hasOne untuk Setting
    public function setting(): HasOne
    {
        return $this->hasOne(Setting::class);
    }
}
