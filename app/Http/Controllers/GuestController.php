<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guest;
use Illuminate\Support\Str;
use App\Mail\GuestAccountCreated;
use Illuminate\Support\Facades\Mail;

class GuestController extends Controller
{
    public function processGuestInfo(Request $request)
{
    $user = User::firstOrCreate(
        ['email' => $request->email],
        [
            'name' => $request->name,
            'password' => Str::random(12),
            'role' => 'guest'
        ]
    );

    // Kirim email credentials
    Mail::to($user)->queue(new GuestAccountCreated($user));
}
}
