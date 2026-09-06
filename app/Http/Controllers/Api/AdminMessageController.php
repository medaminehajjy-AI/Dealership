<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->get();

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);

        $message->update([
            'is_read' => true,
        ]);

        return response()->json([
            'message' => 'Message marked as read successfully.',
            'contact_message' => $message,
        ]);
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);

        $message->delete();

        return response()->json([
            'message' => 'Message deleted successfully.'
        ]);
    }


}
