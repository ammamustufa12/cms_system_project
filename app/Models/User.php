<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TwillUser extends Authenticatable
{
    use Notifiable, HasFactory, SoftDeletes;

    protected $table = 'twill_users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
  'name',
    'email',
    'password',
    'role_id',
    'phone',
    'joining_date',
    'skills',
    'designation',
    'website',
    'city',
    'country',
    'zipcode',
    'github_username',
    'dribbble_username',
    'pinterest_username',
    'portfolio_website',
    'photo',
    'cover_image',
    'title',
    'description',


    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'skills' => 'array',
        'joining_date' => 'date',
    ];

    /**
     * The attributes that should be hidden.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Automatically hash password if set.
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * Relation to Role model.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Accessor for full name.
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Accessor for profile image URL.
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-avatar.png');
    }
}
