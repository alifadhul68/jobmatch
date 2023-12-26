<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'interviewer_id',
        'interviewee_id',
        'interview_date',
        'location',
        'notes',
    ];

    public function interviewer(){
        return $this->belongsTo(User::class, 'interviewer_id', 'id');
    }

    public function interviewee(){
        return $this->belongsTo(User::class, 'interviewee_id', 'id');
    }

    public function listing(){
        return $this->hasOneThrough(Listing::class, ListingUser::class, 'id', 'id', 'applicant_id', 'listing_id');
    }


}
