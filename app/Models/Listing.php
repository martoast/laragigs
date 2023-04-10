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
        'email'
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'image' => 'nullable|string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setImageAttribute($image)
{
    if (is_string($image)) {
        // image is already a string (probably from factory)
        $this->attributes['image'] = $image;
    } else if ($image instanceof UploadedFile) {
        // image is an instance of UploadedFile (probably from store method)
        $filename = time() . '_' . $image->getClientOriginalName();
        $path = 'public/storage/images/' . $filename;
        Storage::putFileAs('public/storage/images', $image, $filename);
        $this->attributes['image'] = $path;
    }
}

}
