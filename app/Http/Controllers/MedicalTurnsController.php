<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Institution;
use App\Models\MedicalTurns;

class MedicalTurnsController extends Controller
{
    /**
     * Validate the request.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get all medical turns.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getAll()
    {
        // Get all medical turns.
        $medicalTurns = MedicalTurns::all();

        // Return a response with a JSON.
        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved all medical turns',
            'medicalTurns' => $medicalTurns
        ], 200);
    }


    /**
     * Get a medical turn by id.
     *
     * @param int $id - The medical turn id.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getById($id)
    {
        // Get the medical turn.
        $medicalTurn = MedicalTurns::find($id);

        // Validate the medical turn.
        if (!$medicalTurn) {
            return response()->json([
                'success' => false,
                'message' => 'The medical turn does not exist'
            ], 404);
        }

        // Return a response with a JSON.
        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved the medical turn',
            'medicalTurn' => $medicalTurn
        ], 200);
    }


    /**
     * Add a new medical turn.
     *
     * @param \Illuminate\Http\Request $request - The request.
     *
     * @return \Illuminate\Http\Response
     */
    public static function add(Request $request)
    {
        try {
            // Validate the request.
            $request->validate([
                'institution_id' => 'required|integer',
                'doctor_id' => 'required|integer',
                'day' => 'required|date',
                'time' => 'required|date_format:H:i',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->validator->errors()->getMessages(),
            ], 400);
        }

        // Validate the turn.
        $isTurnValid = self::validateTurn($request);

        if ($isTurnValid) {
            return $isTurnValid;
        }

        // Create a new medical turn.
        $medicalTurn = new MedicalTurns();
        $medicalTurn->institution_id = $request->institution_id;
        $medicalTurn->doctor_id = $request->doctor_id;
        $medicalTurn->day = $request->day;
        $medicalTurn->time = $request->time;
        $medicalTurn->save();

        // Return a response with a JSON.
        return response()->json([
            'success' => true,
            'message' => 'Successfully added a new medical turn',
            'medicalTurn' => $medicalTurn
        ], 201);
    }


    /**
     * Update a medical turn.
     *
     * @param \Illuminate\Http\Request $request - The request.
     * @param int $id - The medical turn id.
     *
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, $id)
    {
        try {
            // Validate the request.
            $request->validate([
                'institution_id' => 'required|integer',
                'doctor_id' => 'required|integer',
                'day' => 'required|date',
                'time' => 'required|date_format:H:i',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->validator->errors()->getMessages(),
            ], 400);
        }

        // Validate the medical turn.
        $medicalTurn = MedicalTurns::find($id);
        if (!$medicalTurn) {
            return response()->json([
                'success' => false,
                'message' => 'The medical turn does not exist'
            ], 404);
        }

        // Validate the turn.
        $isTurnValid = self::validateTurn($request);

        if ($isTurnValid) {
            return $isTurnValid;
        }

        // Update the medical turn.
        $medicalTurn->institution_id = $request->institution_id;
        $medicalTurn->doctor_id = $request->doctor_id;
        $medicalTurn->day = $request->day;
        $medicalTurn->time = $request->time;
        $medicalTurn->save();

        // Return a response with a JSON.
        return response()->json([
            'success' => true,
            'message' => 'Successfully updated the medical turn',
            'medicalTurn' => $medicalTurn
        ], 200);
    }


    /**
     * Delete a medical turn.
     *
     * @param int $id - The medical turn id.
     *
     * @return \Illuminate\Http\Response
     */
    public static function delete($id)
    {
        // Get the medical turn.
        $medicalTurn = MedicalTurns::find($id);

        // Validate the medical turn.
        if (!$medicalTurn) {
            return response()->json([
                'success' => false,
                'message' => 'The medical turn does not exist'
            ], 404);
        }

        // Delete the medical turn.
        $medicalTurn->delete();

        // Return a response with a JSON.
        return response()->json([
            'success' => true,
            'message' => 'Successfully deleted the medical turn',
            'medicalTurn' => $medicalTurn
        ], 200);
    }


    /**
     * Validate the turn.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    private static function validateTurn(Request $request)
    {
        // Validate the institution.
        $institution = Institution::find($request->institution_id);
        if (!$institution) {
            return response()->json([
                'success' => false,
                'message' => 'The institution does not exist'
            ], 404);
        }

        // Validate the doctor.
        $doctor = Doctor::find($request->doctor_id);
        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'The doctor does not exist'
            ], 404);
        }

        // Calidate that the doctor has that day and time available.
        $doctorTurns = MedicalTurns::where('doctor_id', $request->doctor_id)
            ->where('day', $request->day)
            ->where('time', $request->time)
            ->first();

        if ($doctorTurns) {
            return response()->json([
                'success' => false,
                'message' => 'The doctor does not have that day and time available'
            ], 400);
        }

        // Validate that the doctor does not have more than 1 turn per hour.
        $medicalTurns = MedicalTurns::where('doctor_id', $request->doctor_id)
            ->where('day', $request->day)
            ->whereBetween('time', [date('H:i', strtotime($request->time . ' -1 hour')), date('H:i', strtotime($request->time . ' +1 hour'))])
            ->get();

        if (count($medicalTurns) >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'The doctor already has a turn for this hour'
            ], 400);
        }

        // Validate that the day is not from the past.
        $today = date('Y-m-d');
        if ($request->day < $today) {
            return response()->json([
                'success' => false,
                'message' => 'The day is from the past'
            ], 400);
        }

        // Validate that the hour is not from the past.
        $now = date('H:i');
        if ($request->day == $today && $request->time < $now) {
            return response()->json([
                'success' => false,
                'message' => 'The hour is from the past',
                'difference' => $now
            ], 400);
        }

        // Validate the turn.
        $medicalTurn = MedicalTurns::where('institution_id', $request->institution_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('day', $request->day)
            ->where('time', $request->time)
            ->first();
        if ($medicalTurn) {
            return response()->json([
                'success' => false,
                'message' => 'The turn already exists'
            ], 400);
        }
    }
}
