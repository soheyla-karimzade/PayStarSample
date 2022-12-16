<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class,'users_products');
    }

    /**
     * Get the comments for the blog post.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
