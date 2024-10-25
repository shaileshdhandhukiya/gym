<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipments = Equipment::all();

        return response()->json([
            'success' => true,
            'data' => $equipments,
            'message' => 'Equipments retrieved successfully',
            'status' => 200,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'video_link' => 'nullable|url',
            'image' => 'nullable|image|max:2048555555555', // Image file validation
        ]);

        // Handle image upload if present
        $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;

        $equipment = Equipment::create([
            'title' => $request->title,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'description' => $request->description,
            'video_link' => $request->video_link,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'data' => $equipment,
            'message' => 'Equipment created successfully',
            'status' => 201,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'Equipment not found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $equipment,
            'message' => 'Equipment retrieved successfully',
            'status' => 200,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'Equipment not found',
                'status' => 404,
            ], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'video_link' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle image update if present
        if ($request->file('image')) {
            // Delete the old image
            if ($equipment->image) {
                Storage::disk('public')->delete($equipment->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $equipment->image = $imagePath;
        }

        $equipment->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $equipment,
            'message' => 'Equipment updated successfully',
            'status' => 200,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'Equipment not found',
                'status' => 404,
            ], 404);
        }

        // Delete the image
        if ($equipment->image) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Equipment deleted successfully',
            'status' => 200,
        ], 200);
    }
}
