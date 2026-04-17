<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Reservation;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::whereIn('destinataire', ['receptionniste', 'tous'])
            ->latest()
            ->get();

        $non_lues = $notifications->where('lu', false)->count();

        return view('reception.notifications.index', compact('notifications', 'non_lues'));
    }

    public function marquerLu(Notification $notification)
    {
        $notification->update(['lu' => true]);
        return back()->with('success', 'Notification marquee comme lue.');
    }

    public function marquerToutLu()
    {
        Notification::whereIn('destinataire', ['receptionniste', 'tous'])
            ->where('lu', false)
            ->update(['lu' => true]);
        return back()->with('success', 'Toutes les notifications marquees comme lues.');
    }

    public function validerReservation(Notification $notification)
    {
        $reservation = Reservation::find($notification->id_reservation);

        if ($reservation && $reservation->statut == 'en_attente') {
            $reservation->update(['statut' => 'confirmee']);
            $notification->update(['lu' => true]);
            return redirect()->route('reception.notifications.index')
                ->with('success', 'Reservation confirmee avec succes !');
        }

        return redirect()->route('reception.notifications.index')
            ->with('info', 'Cette reservation a deja ete traitee.');
    }

    public function getCount()
    {
        $count = Notification::whereIn('destinataire', ['receptionniste', 'tous'])
            ->where('lu', false)
            ->count();
        return response()->json(['count' => $count]);
    }
}