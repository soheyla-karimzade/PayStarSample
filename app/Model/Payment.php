<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{


    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the post that owns the comment.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}







