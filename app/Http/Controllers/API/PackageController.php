<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::all();

        return response()->json([
            'success' => true,
            'data' => $packages,
            'message' => 'Packages retrieved successfully',
            'status' => 200,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_cost' => 'required|numeric',
            'min_cost' => 'required|numeric',
            'duration_days' => 'required|integer',
            'plan' => 'required|in:monthly,quarterly,half_year,year',
        ]);

        $package = Package::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $package,
            'message' => 'Package created successfully',
            'status' => 201,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $package,
            'message' => 'Package retrieved successfully',
            'status' => 200,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'max_cost' => 'numeric',
            'min_cost' => 'numeric',
            'duration_days' => 'integer',
            'plan' => 'in:monthly,quarterly,half_year,year',
        ]);

        $package = Package::find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found',
                'status' => 404,
            ], 404);
        }

        $package->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $package,
            'message' => 'Package updated successfully',
            'status' => 200,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found',
                'status' => 404,
            ], 404);
        }

        $package->delete();

        return response()->json([
            'success' => true,
            'message' => 'Package deleted successfully',
            'status' => 200,
        ], 200);
    }
}
