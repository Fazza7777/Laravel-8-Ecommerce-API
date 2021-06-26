<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public function cat(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcat(){
        return $this->belongsTo(SubCategory::class,'subcat_id');
    }
    public function tag(){
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
