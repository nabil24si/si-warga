<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function unread()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['count' => 0, 'notifications' => []]);
        }

        $notifications = $user->unreadNotifications()->latest()->take(5)->get()->map(function ($notif) {
            return [
                'id' => $notif->id,
                'judul' => $notif->data['judul'] ?? 'Notifikasi',
                'pesan' => $notif->data['pesan'] ?? '',
                'url' => $notif->data['url'] ?? '#',
                'created_at' => $notif->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'count' => $user->unreadNotifications()->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return response()->json(['success' => true]);
    }
}
