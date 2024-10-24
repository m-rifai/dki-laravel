<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'job_id',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'street_name',
        'deposit_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
