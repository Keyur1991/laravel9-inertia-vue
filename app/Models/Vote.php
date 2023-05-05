<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'votable_type',
        'votable_id',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope of query to check vote against a votable type
     * and votable id
     */
    public function scopeVotable(Builder $query, string $votable_type , int $votable_id = null) : void
    {
        $query->where('votable_type', $votable_type)->where('votable_id', $votable_id);
    }

    /**
     * Scope of query to check vote against a user
     */
    public function scopeUser(Builder $query, int $user_id) : void
    {
        $query->where('user_id', $user_id);
    }
}
