<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'salary',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'required|string|max:255',
        'image' => 'nullable|string'
    ];

    public function setImageAttribute($image)
{
    if (is_string($image)) {
        // image is already a string (probably from factory)
        $this->attributes['image'] = $image;
    } else if ($image instanceof UploadedFile) {
        // image is an instance of UploadedFile (probably from store method)
        $filename = time() . '_' . $image->getClientOriginalName();
        $path = 'public/storage/listings/' . $filename;
        Storage::putFileAs('public/storage/listings', $image, $filename);
        $this->attributes['image'] = $path;
    }
}

}
