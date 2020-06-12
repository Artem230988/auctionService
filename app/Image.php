<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lot;



class Image extends Model
{
    public function lot()
    {
    	return $this->belongsTo(Lot::class);
    }
}
