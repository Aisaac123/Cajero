<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
