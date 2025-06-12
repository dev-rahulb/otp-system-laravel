<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OTP extends Model
{
    use HasFactory;
protected $table = 'otps'; // 👈 force correct table name
    protected $fillable = ['user_id', 'code', 'type', 'verified_at', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeValid($query)
    {
        return $query->whereNull('verified_at')
                     ->where('expires_at', '>', Carbon::now());
    }
}
