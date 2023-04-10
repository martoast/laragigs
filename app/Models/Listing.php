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
        'email',
        'tags'
    ];

    protected $casts = [
        'tags' => 'array',
    ];
    
    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'image' => 'nullable|string',
        'tags' => 'nullable|array',
        'tags.*' => 'nullable|string|max:255'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
