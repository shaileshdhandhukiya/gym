<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\PaymentMode;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with('paymentMode')->get();

        if ($expenses->isEmpty()) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'No expenses found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $expenses,
            'message' => 'Expenses retrieved successfully',
            'status' => 200,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'payment_mode_id' => 'required|exists:payment_modes,id',
            'description' => 'nullable|string',
        ]);

        $expense = Expense::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $expense,
            'message' => 'Expense created successfully',
            'status' => 201,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expense = Expense::with('paymentMode')->find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $expense,
            'message' => 'Expense retrieved successfully',
            'status' => 200,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found',
                'status' => 404,
            ], 404);
        }

        $request->validate([
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'payment_mode_id' => 'required|exists:payment_modes,id',
            'description' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $expense,
            'message' => 'Expense updated successfully',
            'status' => 200,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found',
                'status' => 404,
            ], 404);
        }

        $expense->delete();

        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully',
            'status' => 200,
        ], 200);
    }
}
