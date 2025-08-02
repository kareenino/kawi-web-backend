<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    // get all operators
    public function index(){
        $operators = Operator::all();
        return response()->json($operators, 200);
    }

    //get Operator
    public function getOperator($id){
        $operator = Operator::findOrFail($id);
        return response()->json($operator);
    }

    //create operator
    public function store(Request $request){
        $validated = $request->validate([
            'user_id'=> 'required|integer',
            'company_name'=> 'required|string',
            'phone_number'=> 'required|string',
            'region'=> 'required|string',
        ]);

        $operator = Operator::create($validated);

        return response()->json(
            [
                'message' => 'Operator created successfully',
                'data' => $operator
            ], 500);
    }

    //update operator
    public function updateOperator($id, Request $request){

        $operator = Operator::findOrFail($id);

        $validated = $request->validate([
            'user_id'=> 'required|integer',
            'company_name'=> 'required|string',
            'phone_number'=> 'required|string',
            'region'=> 'required|string',
        ]);

        $operator->update($validated);

        return response()->json(
            [
                'message' => 'Operator updated successfully',
                'data' => $operator
            ], 500);
    }

    //delete operator
    public function deleteOperator($id){
        {
            $operator = Operator::findOrFail($id);
            $operator->delete();
        }

        return response()->json(
            [
                'message' => 'Operator deleted successfully'
            ], 500);
    }
}