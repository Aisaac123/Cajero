<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'card_number',
        'amount',
        'pin',
        'description',
        'is_blocked',
        'user_id',
        'deleted_at',
    ];

    protected $hidden = [
        'pin',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
