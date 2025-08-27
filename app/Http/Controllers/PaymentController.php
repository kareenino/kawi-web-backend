<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // get all payments
    public function index(){
        $payments = Payment::all();
        return response()->json($payments, 200);
    }

    //get Payment
    public function getPayment($id){
        $payment = Payment::findOrFail($id);
        return response()->json($payment);
    }

    //create payment
    public function store(Request $request){
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'swap_history_id' => 'nullable|exists:swap_histories,id',
            'method'          => 'required|in:mpesa,cash',
            'amount'          => 'required|numeric|min:1',
            'mpesa_phone'     => 'nullable|string|max:20',
            'reference'       => 'nullable|string|max:255',
            'status'          => 'nullable|in:pending,succeeded,failed,refunded',
        ]);

        $payment = Payment::create($validated);

        return response()->json(
            [
                'message' => 'Payment created successfully',
                'data' => $payment
            ], 500);
    }

    //update payment
    public function updatePayment($id, Request $request){

        $payment = Payment::findOrFail($id);
        $validated = $request->validate([
           'user_id'         => 'required|exists:users,id',
            'swap_history_id' => 'nullable|exists:swap_histories,id',
            'method'          => 'required|in:mpesa,cash',
            'amount'          => 'required|numeric|min:1',
            'mpesa_phone'     => 'nullable|string|max:20',
            'reference'       => 'nullable|string|max:255',
            'status'          => 'nullable|in:pending,succeeded,failed,refunded',
        ]);

        $payment->update($validated);
        return response()->json(
            [
                'message' => 'Payment updated successfully',
                'data' => $payment
            ], 500);
    }

    //delete payment
    public function deletePayment($id){
        {
            $payment = Payment::findOrFail($id);
            $payment->delete();
        }

        return response()->json(
            [
                'message' => 'Payment deleted successfully'
            ], 500);
    }
}