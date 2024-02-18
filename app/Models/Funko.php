<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Funko extends Model
{
    use HasFactory;

    const DEFAULT_IMAGE = 'https://placehold.co/150x150';

    protected $fillable = ['name', 'price', 'stock', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%$search%");
        }

        return $query;
    }

    public function getImageUrl()
    {
        if ($this->image !== Funko::DEFAULT_IMAGE) {
            $filesystem = Storage::disk('public');
            $imagePath = $filesystem->url($this->image);
            return str_replace('storage', 'storage/funkos', $imagePath);
        }
        return $this->image;
    }
}
