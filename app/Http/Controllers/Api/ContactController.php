<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['data' => Contact::all()]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['message' => 'Query is required'], 400);
        }

        // Normalisasi query
        if (str_starts_with($query, '08')) {
            $query = '+62' . substr($query, 1);
        }

        $contacts = Contact::where('contact_phone', $query)->get();

        if ($contacts->isEmpty()) {
            return response()->json(['message' => 'No contacts found'], 404);
        }

        return response()->json($contacts);
    }
}
