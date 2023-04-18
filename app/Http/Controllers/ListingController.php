<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $listings = Listing::query()
            ->when($request->search, function (Builder $query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->simplePaginate(10);

        return response()->json($listings);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'salary' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255'
        ];
    
        $messages = [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'salary.required' => 'The salary field is required.',
            'email.required' => 'The contact email field is required.',
            'email.email' => 'The contact email field must be a valid email.',
            'image.max' => 'The image may not be greater than 2 MB.',
            'image.image' => 'The file must be an image.',
            'tags.*.string' => 'The tag must be a string.',
            'tags.*.max' => 'The tag may not be greater than :max characters.'
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
        $listing->email = $request->email;
        
        if ($request->has('tags')) {
            $listing->tags = $request->tags;
        }    
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('images', $filename, 's3');
            $listing->image = $listing->image = 'https://laragigs.s3.us-west-1.amazonaws.com/' . $path;
        } else {
            $listing->image = "https://laragigs.s3.us-west-1.amazonaws.com/default.png";
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
            'email' => 'sometimes|required|email',
            'image' => 'sometimes|image|max:2048',
            'tags' => 'sometimes|array',
            'tags.*' => 'string|max:255'
        ];

        $messages = [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'salary.required' => 'The salary field is required.',
            'email.required' => 'The contact email field is required.',
            'email.email' => 'The contact email field must be a valid email.',
            'image.max' => 'The image may not be greater than 2 MB.',
            'image.image' => 'The file must be an image.',
            'tags.*.string' => 'The tag must be a string.',
            'tags.*.max' => 'The tag may not be greater than :max characters.'
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
        $listing->email = $request->email;
        
        if ($request->has('tags')) {
            $listing->tags = $request->tags;
        }    
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('images', $filename, 's3');
            $listing->image = $listing->image = 'https://laragigs.s3.us-west-1.amazonaws.com/' . $path;
        } else {
            $listing->image = "https://laragigs.s3.us-west-1.amazonaws.com/default.png";
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

