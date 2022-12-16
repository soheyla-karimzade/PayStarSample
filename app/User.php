<?php

namespace App;

use App\Model\Payment;
use App\Model\Product;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Products()
    {
        return $this->belongsToMany(Product::class,'users_products');
    }


    /**
     * Get the comments for the blog post.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
