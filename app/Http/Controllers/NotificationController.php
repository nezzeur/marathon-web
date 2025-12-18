<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($notificationId);
        
        $notification->markAsRead();
        
        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Afficher toutes les notifications
     */
    public function all()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(15);
        
        return view('notifications.all', compact('notifications'));
    }

    /**
     * Supprimer une notification
     */
    public function destroy($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($notificationId);
        
        $notification->delete();
        
        return back()->with('success', 'Notification supprimée.');
    }

    /**
     * Supprimer toutes les notifications
     */
    public function destroyAll()
    {
        $user = Auth::user();
        $user->notifications()->delete();
        
        return back()->with('success', 'Toutes les notifications ont été supprimées.');
    }
}