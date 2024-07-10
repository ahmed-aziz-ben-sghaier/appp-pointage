<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeP extends Model
{
    use HasFactory;
    protected $table ='liste_p';
    protected $fillable = ['user_id', 'action', 'status', 'time'];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
