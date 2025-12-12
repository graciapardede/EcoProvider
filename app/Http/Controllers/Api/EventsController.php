<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    /**
     * Get all events
     */
    public function index()
    {
        // Placeholder data untuk events
        $events = [
            [
                'id' => 1,
                'title' => 'Webinar Keberlanjutan Lingkungan',
                'description' => 'Pelajari cara menjaga lingkungan bersama para ahli',
                'date' => '2025-12-20',
                'time' => '10:00:00',
                'location' => 'Online',
                'category' => 'webinar',
            ],
            [
                'id' => 2,
                'title' => 'Workshop Daur Ulang Plastik',
                'description' => 'Workshop praktis tentang daur ulang plastik',
                'date' => '2025-12-25',
                'time' => '14:00:00',
                'location' => 'Jakarta',
                'category' => 'workshop',
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $events,
            'total' => count($events),
        ]);
    }

    /**
     * Get single event
     */
    public function show($id)
    {
        $events = [
            1 => [
                'id' => 1,
                'title' => 'Webinar Keberlanjutan Lingkungan',
                'description' => 'Pelajari cara menjaga lingkungan bersama para ahli',
                'date' => '2025-12-20',
                'time' => '10:00:00',
                'location' => 'Online',
                'category' => 'webinar',
                'speaker' => 'Dr. Eco Expert',
                'attendees' => 150,
            ],
            2 => [
                'id' => 2,
                'title' => 'Workshop Daur Ulang Plastik',
                'description' => 'Workshop praktis tentang daur ulang plastik',
                'date' => '2025-12-25',
                'time' => '14:00:00',
                'location' => 'Jakarta',
                'category' => 'workshop',
                'speaker' => 'Tim Sustainability',
                'attendees' => 75,
            ],
        ];

        if (!isset($events[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $events[$id],
        ]);
    }
}
