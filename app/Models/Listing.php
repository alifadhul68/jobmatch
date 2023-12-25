<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'roles',
        'job_type',
        'address',
        'salary',
        'application_close_date',
        'feature_image',
        'slug',
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'listing_user', 'listing_id', 'user_id')
            ->withpivot('id', 'is_shortlisted', 'cover_letter')
            ->withTimestamps();
    }

    public function profile(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shortlisted()
    {
        return $this->belongsToMany(User::class, 'listing_user', 'listing_id', 'user_id')
            ->withPivot('is_shortlisted') // Specify the pivot column
            ->wherePivot('is_shortlisted', 1); // Filter to get only shortlisted users
    }
}
