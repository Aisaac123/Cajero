<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicPassword extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'user_id'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }

}
