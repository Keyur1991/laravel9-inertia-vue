<?php

namespace App\Traits;

use App\Models\Vote;

trait Votable
{
    /**
     * Laravel Polymorphic relation
     * @return Collection $collection
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    /**
     * Relationship for upvotes
     */
    public function upvotes()
    {
        return $this->votes()->where('value', 1);
    }

    /**
     * Relationship for downvotes
     */
    public function downvotes()
    {
        return $this->votes()->where('value', 0);
    }

    /**
     * Score of votes
     *
     * @TODO: Get total sum of votes values
     * @return void
     */
    public function getScoreAttribute()
    {
        return;
    }
}
