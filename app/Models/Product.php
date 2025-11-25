<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
 protected $fillable = [
    'category_id',
    'name',
    'description',
    'image',
    'status'
 ];

 public function cate()
 {
    return $this->hasOne(Category::class,'id','category_id');
 }


}
