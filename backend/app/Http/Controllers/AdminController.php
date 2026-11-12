<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // View all registered users
    public function users()
    {
        return response()->json(User::all());
    }

    // View active users (users who created a token/logged in recently)
    public function activeUsers()
    {
        $activeUsers = User::whereHas('tokens', function ($query) {
            $query->where('last_used_at', '>=', now()->subDays(7));
        })->get();

        return response()->json($activeUsers);
    }

    // View activity logs (if using a package like spatie/laravel-activitylog)
    public function logs()
    {
        // Example response for logs
        return response()->json([
            'message' => 'Admin system logs endpoint'
        ]);
    }
}