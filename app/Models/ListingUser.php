<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingUser extends Model
{
    use HasFactory;
    protected $table = 'listing_user';
    protected $fillable = [
        'listing_id',
        'user_id',
        'is_shortlisted',
        'cover_letter',
    ];
}
