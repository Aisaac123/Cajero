<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicPassword extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'user_id',
        'expiration_time',
    ];
    protected function casts(): array
    {
        return [
            'expiration_time' => 'datetime',
        ];
    }
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
