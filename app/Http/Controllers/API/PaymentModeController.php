<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMode;
use Illuminate\Http\Request;

class PaymentModeController extends Controller
{
    // Get all payment modes
    public function index()
    {
        $paymentModes = PaymentMode::all();

        return response()->json([
            'success' => true,
            'data' => $paymentModes,
            'message' => 'Payment modes retrieved successfully',
            'status' => 200,
        ], 200);
    }

    // Create a new payment mode
    public function store(Request $request)
    {
        $request->validate([
            'mode' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $paymentMode = PaymentMode::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $paymentMode,
            'message' => 'Payment mode created successfully',
            'status' => 201,
        ], 201);
    }

    // Get a specific payment mode
    public function show($id)
    {
        $paymentMode = PaymentMode::find($id);

        if (!$paymentMode) {
            return response()->json([
                'success' => false,
                'message' => 'Payment mode not found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $paymentMode,
            'message' => 'Payment mode retrieved successfully',
            'status' => 200,
        ], 200);
    }

    // Update a payment mode
    public function update(Request $request, $id)
    {

        $request->validate([
            'mode' => 'string|max:255',
            'status' => 'boolean',
        ]);

        $paymentMode = PaymentMode::find($id);

        if (!$paymentMode) {
            return response()->json([
                'success' => false,
                'message' => 'Payment mode not found',
                'status' => 404,
            ], 404);
        }

        $paymentMode->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $paymentMode,
            'message' => 'Payment mode updated successfully',
            'status' => 200,
        ], 200);
    }

    // Delete a payment mode
    public function destroy($id)
    {
        $paymentMode = PaymentMode::find($id);

        if (!$paymentMode) {
            return response()->json([
                'success' => false,
                'message' => 'Payment mode not found',
                'status' => 404,
            ], 404);
        }

        $paymentMode->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment mode deleted successfully',
            'status' => 200,
        ], 200);
    }
}

