<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userProfile(Request $request)
    {
        $user = $request->user();
        $settings = $user->setting;

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'phone_number' => $user->phone_number,
            'email' => $user->email,
            'settings' => [
                'spam_protection_enabled' => $settings->spam_protection_enabled ?? false,
                'tag_visibility' => $settings->tag_visibility ?? false,
            ],
        ]);
    }

    public function updateUserVisibility(Request $request)
    {
        $request->validate([
            'tag_visibility' => 'required|in:public,private',
        ]);

        $user = $request->user();
        $user->setting->update([
            'tag_visibility' => $request->tag_visibility,
        ]);

        return response()->json([
            'message' => 'User visibility updated successfully.',
            'settings' => [
                'tag_visibility' => $user->setting->tag_visibility,
            ],
        ]);
    }

    public function updateSpamProtection(Request $request)
    {
        $request->validate([
            'spam_protection_enabled' => 'required|boolean',
        ]);

        $user = $request->user();
        $user->setting->update([
            'spam_protection_enabled' => $request->spam_protection_enabled,
        ]);

        return response()->json([
            'message' => 'Spam protection updated successfully.',
            'settings' => [
                'spam_protection_enabled' => $user->setting->spam_protection_enabled,
            ],
        ]);
    }
}
