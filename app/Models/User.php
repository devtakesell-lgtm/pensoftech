<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['role_id', 'name', 'email', 'phone', 'password', 'avatar', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    protected static function booted(): void
    {
        static::saved(function (User $user) {
            if ($user->role_id && ! $user->hasRole($user->role_id)) {
                $user->assignRole($user->role_id);
            }
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Backward-compatible accessor for primary role.
     */
    public function getRoleAttribute(): ?Role
    {
        return $this->getRelationValue('role') ?? $this->roles->first();
    }

    /**
     * Determine whether user can access agency admin panel.
     */
    public function isStaff(): bool
    {
        return $this->can('access-admin');
    }

    /**
     * Determine whether user is a client account.
     */
    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function assignedLeads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    public function createdQuotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'created_by');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
