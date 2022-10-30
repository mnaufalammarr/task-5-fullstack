<?php

namespace App\Models;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;

class Article extends Model
{
    use HasFactory,Authenticatable;
    //protected $guarded = kolom tidak boleh diisi
    protected $guarded = ['id'];
    //protected $with = ['category','user'];
    //Eloquent: Relationships
    //one to one
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
    // //one to one
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
