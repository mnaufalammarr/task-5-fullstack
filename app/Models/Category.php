<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;


class Category extends Model
{
    use HasFactory, Authenticatable;
    protected $guarded = ['id'];
    //Eloquent: Relationships
    //one to many
    public function Article()
    {
        return $this->hasMany(Article::class);
    }
    //one to one
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
