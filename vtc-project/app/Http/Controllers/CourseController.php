<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    // Création d'une demande de course par un client
    public function createCourse(Request $request)
    {
        $request->validate([
            'departure'    => 'required|string',
            'destination'  => 'required|string',
            'scheduled_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $client = auth()->user();

        $course = Course::create([
            'client_id'    => $client->id,
            'departure'    => $request->departure,
            'destination'  => $request->destination,
            'scheduled_at' => $request->scheduled_at,
            'status'       => 'pending',
        ]);

        return response()->json($course, 201);
    }

    // Liste des courses en attente (pour les chauffeurs)
    public function listCourses()
    {
        $courses = Course::where('status', 'pending')->get();
        return response()->json($courses);
    }

    // Accepter une course (pour un chauffeur)
    public function acceptCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        if ($course->status !== 'pending') {
            return response()->json(['message' => 'La course n\'est plus disponible.'], 400);
        }

        $chauffeur = auth()->user();
        $course->update([
            'chauffeur_id' => $chauffeur->id,
            'status'       => 'accepted',
        ]);

        // Optionnel : déclencher une notification ici

        return response()->json(['message' => 'Course acceptée', 'course' => $course]);
    }

    // Afficher les détails d'une course
    public function showCourse($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }
}
