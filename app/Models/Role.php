<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    /** @use HasFactory<RoleFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'guard_name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Role $role) {
            if (empty($role->guard_name)) {
                $role->guard_name = 'web';
            }
            if (empty($role->name) && ! empty($role->slug)) {
                $role->name = Str::slug($role->slug);
            } elseif (! empty($role->name)) {
                $role->name = Str::slug($role->name);
            }
            if (empty($role->slug) && ! empty($role->name)) {
                $role->slug = $role->name;
            }
        });
    }

    public function getSlugAttribute(): string
    {
        return $this->attributes['slug'] ?? $this->name;
    }
}
