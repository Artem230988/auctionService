<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    public function images()
    {
    	return $this->hasMany(Image::class); 
    }
}
