<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Follower extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['following_user_id', 'follower_user_id'];

    public function following_user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function follower_user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
