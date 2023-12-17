<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        if (auth()->user()->user_type == 'employer') {
            $layout = 'layouts.admin.main';
        } elseif (auth()->user()->user_type == 'seeker') {
            $layout = 'layouts.app';
        }
        $sentMessages = Message::where('sender_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $receivedMessages = Message::where('recipient_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('messages.index', compact(['sentMessages', 'receivedMessages', 'layout']));
    }
    public function send(Request $request) {

        $request->validate([
            'recipient_id' => 'required',
            'applicant_id' => 'required',
            'message' => 'required',
        ]);

        Message::create([
            'sender_id' => auth()->user()->id, // Assuming the sender is the logged-in employer
            'recipient_id' => $request->recipient_id,
            'applicant_id' => $request->applicant_id,
            'message_content' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully');
    }
}
