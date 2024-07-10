<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'delay_date', 'delay_time', 'reason', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
        
    }
}
