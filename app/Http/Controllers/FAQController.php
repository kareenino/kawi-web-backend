<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    // get all faqs
    public function index(){
        $faqs = FAQ::all();
        return response()->json($faqs, 200);
    }

    //get FAQ
    public function getFAQ($id){
        $faq = FAQ::findOrFail($id);
        return response()->json($faq);
    }

    //create faq
    public function store(Request $request){
        $validated = $request->validate([
            'question'=> 'required|string',
            'answer'=> 'string',
        ]);

        $faq = FAQ::create($validated);

        return response()->json(
            [
                'message' => 'FAQ created successfully',
                'data' => $faq
            ], 500);
    }

    //update faq
    public function updateFAQ($id, Request $request){

        $faq = FAQ::findOrFail($id);

        $validated = $request->validate([
            'question'=> 'string',
            'answer'=> 'string',
        ]);

        $faq->update($validated);

        return response()->json(
            [
                'message' => 'FAQ updated successfully',
                'data' => $faq
            ], 500);
    }

    //delete faq
    public function deleteFAQ($id){
        {
            $faq = FAQ::findOrFail($id);
            $faq->delete();
        }

        return response()->json(
            [
                'message' => 'FAQ deleted successfully'
            ], 500);
    }
}