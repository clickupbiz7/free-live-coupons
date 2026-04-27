<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('admin.contact-messages.show', compact('message'));
    }

    public function destroy($id)
    {
        ContactMessage::findOrFail($id)->delete();

        return back()->with('success','Deleted');
    }

    public function reply(Request $request, $id)
{
    $request->validate([
        'subject' => 'required|max:255',
        'message' => 'required'
    ]);

    $contact = ContactMessage::findOrFail($id);

    try {

        \Mail::raw($request->message, function ($mail) use ($contact, $request) {

            $mail->to($contact->email)
                 ->subject($request->subject);

        });

        $contact->update([
            'is_replied'   => 1,
            'replied_at'   => now(),
            'reply_message'=> $request->message
        ]);

        return back()->with(
            'success',
            'Reply Sent Successfully'
        );

    } catch (\Exception $e) {

        return back()->with(
            'error',
            $e->getMessage()
        );
    }
}
    
}