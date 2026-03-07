<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Chauffeur;

class CourseController extends Controller
{
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

    public function listCourses()
    {
        $courses = Course::where('status', 'pending')->get();
        return response()->json($courses);
    }

    public function clientCourses()
    {
        $client = auth()->user();

        $courses = Course::where('client_id', $client->id)
            ->with('chauffeur:id,name,email')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($courses);
    }

    public function acceptCourse(Request $request, $id)
    {
        $chauffeur = auth()->user();

        if (!($chauffeur instanceof Chauffeur) || $chauffeur->statut !== 'approved') {
            return response()->json(['message' => 'Votre compte n\'est pas encore approuvé par l\'administrateur.'], 403);
        }

        $course = Course::findOrFail($id);

        if ($course->status !== 'pending') {
            return response()->json(['message' => 'La course n\'est plus disponible.'], 400);
        }

        $course->update([
            'chauffeur_id' => $chauffeur->id,
            'status'       => 'accepted',
        ]);

        return response()->json(['message' => 'Course acceptée', 'course' => $course]);
    }

    public function showCourse($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }
}
