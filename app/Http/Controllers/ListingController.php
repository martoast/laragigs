<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::all();
        return response()->json($listings);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'salary' => 'required',
            'image' => 'nullable|image|max:2048'
        ];
    
        $messages = [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'salary.required' => 'The salary field is required.',
            'image.max' => 'The image may not be greater than 2 MB.',
            'image.image' => 'The file must be an image.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        $listing = new Listing();
    
        $listing->title = $request->title;
        $listing->description = $request->description;
        $listing->salary = $request->salary;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $listing->setImageAttribute($image);
        }
    
        $listing->save();
    
        return response()->json([
            'message' => 'Listing created successfully',
            'listing' => $listing
        ], 201);
    }
    

    public function show(string $id)
    {
        $listing = Listing::findOrFail($id);
        return response()->json($listing);
    }

    public function update(Request $request, string $id)
    {
        $listing = Listing::findOrFail($id);

        $rules = [
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'salary' => 'sometimes|required',
            'image' => 'sometimes|image|max:2048',
        ];

        $messages = [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'salary.required' => 'The salary field is required.',
            'image.max' => 'The image may not be greater than 2 MB.',
            'image.image' => 'The file must be an image.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $listing->title = $request->title;
        $listing->description = $request->description;
        $listing->salary = $request->salary;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $listing->setImageAttribute($image);
        }

        $listing->save();

        return response()->json([
            'message' => 'Listing updated successfully',
            'listing' => $listing
        ], 201);
    }

    public function destroy(string $id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();
        return response()->json(null, 204);
    }
}

