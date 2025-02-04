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
        $query = $request->input('query'); // Ambil keyword dari request

        if (!$query) {
            return response()->json(['message' => 'Query is required'], 400);
        }

        $contacts = Contact::where('contact_name', 'like', "%{$query}%")
                           ->orWhere('contact_phone', 'like', "%{$query}%")
                           ->get();

        return response()->json($contacts);
    }
}
