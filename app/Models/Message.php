<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'applicant_id',
        'message_content',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
    // Define a custom relationship to access listing_id based on applicant_id
    public function listing(){
        return $this->hasOneThrough(Listing::class, ListingUser::class, 'id', 'id', 'applicant_id', 'listing_id');
    }


}
