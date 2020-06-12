<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class ImagesController extends Controller
{
    public function destroy(Image $image)
    {
    	$image->delete();
    	return back()->with('succes', 'Картика удалена');
    }
}
