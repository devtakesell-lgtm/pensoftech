<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'designation',
        'short_bio',
        'social_links',
        'show_on_team_page',
        'sort_order',
    ];

    protected $casts = [
        'social_links' => 'array',
        'show_on_team_page' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
