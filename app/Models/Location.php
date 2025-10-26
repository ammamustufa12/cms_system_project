<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
    ];

    public function company()
    {
        return $this->belongsTo(companies::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}


