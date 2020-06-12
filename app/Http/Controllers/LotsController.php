<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lot;
use App\Image;
use App\User;
use Illuminate\Support\Facades\Storage;

class LotsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index()
    {
    	$lots = Lot::orderBy('lots.created_at', 'desc')->paginate(8);
        $page_name = 'Все лоты';
    	return view('lots.index', compact('lots', 'page_name'));
    }

    public function indexOld()
    {
        $now = now();
        $lots = Lot::orderBy('lots.created_at', 'desc')->where('completion_time', '<', $now)->paginate(8);
        $page_name = 'Завершенные лоты';
        return view('lots.index', compact('lots', 'page_name'));
    }

    public function indexNew()
    {
        $now = now();
        $lots = Lot::orderBy('lots.created_at', 'desc')->where('completion_time', '>', $now)->paginate(8);
        $page_name = 'Активные лоты';
        return view('lots.index', compact('lots', 'page_name'));
    }

    public function indexMyLots()
    {
        $lots = Lot::orderBy('lots.created_at', 'desc')->where('owner_id', '=', \Auth::user()->id)->paginate(8);
        $page_name = 'Мои лоты';
        return view('lots.index', compact('lots', 'page_name'));
    }


    public function create()
    {
    	return view('lots.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'starting_rate' => 'required|integer',
            'img.*' => 'mimes:jpeg,png|max:3000',
        ]);

        $lot = new Lot;
    	$lot->title = $request->title;
    	$lot->description = $request->description;
    	$lot->starting_rate = $request->starting_rate;
    	$lot->current_rate =  $request->starting_rate;
    	$lot->owner_id = \Auth::user()->id;
    	$lot->completion_time = now()->addMinutes(10080);
    	$lot->lot_completed = 0;
        $lot->current_buyer = 0;
    	$lot->save();

        if(request()->file('img'))
        {
        	$pictures = $request->file('img');
            foreach ($pictures as $picture) 
            {
                $image = new Image;
                $image->lot_id = $lot->id;

                $path = Storage::putFile('public', $picture);
                $url = Storage::url($path);

                $image->img = '/storage'.substr($path,6);
                $image->save();
            }
        }
        return redirect()->route('lots.index')->with('success', 'Лот успешно загружен на сайт');
    }


    public function show(Lot $lot)
    {
    	$name = 'Ставок не было';
        if(User::find($lot->current_buyer))
        {
            $user = User::find($lot->current_buyer);
            $name = $user->name;
        }

        $today = \Carbon\Carbon::now();
        $completion_time = \Carbon\Carbon::parse($lot->completion_time);
        $diffSec = $today->diffInSeconds($completion_time, false);
        $days = floor($diffSec / 86400);
        $hours = floor(($diffSec - $days*86400) / 3600);
        $minutes = floor(($diffSec - $days*86400 - $hours*3600) / 60);
        $seconds = $diffSec - $days*86400 - $minutes*60 - $hours*3600;
        $time_left = $days. ' days ' . $hours . ' hours ' . $minutes . ' minutes ' . $seconds . ' seconds';

        return view('lots.show', compact('lot', 'name', 'time_left'));
    }


    public function editRate(Lot $lot)
    {
        if(\Auth::user()->id != $lot->owner_id)
        {
            return view('lots.editRate', compact('lot'));
        }
        return redirect()->route('lots.show', compact('lot'))->with('success', 'Вы не можете участвовать в торгах своего лота');

    }


    public function edit(Lot $lot)
    {
        if(\Auth::user()->id == $lot->owner_id)
        {
            return view('lots.edit', compact('lot'));
        }
        return redirect()->route('lots.show', compact('lot'))->with('success', 'Вы не можете редактировать чужой лот');
    }


    public function update(Lot $lot)
    {   
        if(\Auth::user()->id == $lot->owner_id)
        {
            if($lot->completion_time > now())
            {
                $this->validate(request(), [
                    'title' => 'required|min:3',
                    'description' => 'required|min:3',
                    'img.*' => 'mimes:jpeg,png|max:3000',
                ]);

                $lot->title = request()->title;
                $lot->description = request()->description;
                $lot->update();

                if(request()->file('img'))
                {
                    $pictures = request()->file('img');
                    foreach ($pictures as $picture) 
                    {
                        $image = new Image;
                        $image->lot_id = $lot->id;

                        $path = Storage::putFile('public', $picture);
                        $url = Storage::url($path);
                        $image->img = '/storage'.substr($path,6);
                        $image->save();
                    }
                }
                return redirect()->route('lots.show', compact('lot'))->with('success', 'Ваш лот отредактирован');
            }
            return redirect()->route('lots.show', compact('lot'))->with('success', 'Лот закрыт!!!');
            }
        return redirect()->route('lots.show', compact('lot'))->with('success', 'Вы не можете редактировать чужой лот');
    }


    public function updateRate(Lot $lot)
    {
        if(\Auth::user()->id != $lot->owner_id)
        {
            if($lot->completion_time > now())
            {
                if(request()->current_rate <= $lot->current_rate)
                {
                    return back()->with('success', 'Ставка не может быть меньше или равна '.$lot->current_rate);
                }
                $this->validate(request(), [
                    'current_rate' => 'required|integer',
                ]);

                $lot->current_rate = request()->current_rate;
                $lot->current_buyer = \Auth::user()->id;
                $lot->update();
                return redirect()->route('lots.show', compact('lot'))->with('success', 'Ваша ставка принята');
            }
            return redirect()->route('lots.show', compact('lot'))->with('success', 'Лот закрыт!!!');
        }
        return redirect()->route('lots.show', compact('lot'))->with('success', 'Вы не можете участвовать в торгах своего лота');
    }


    public function stopLot(Lot $lot)
    {
        if(\Auth::user()->id == $lot->owner_id)
        {
            $lot->completion_time = now();
            $lot->update();
            return redirect()->route('lots.show', compact('lot'))->with('success', 'Лот закрыт досрочно');
        }
        return redirect()->route('lots.show', compact('lot'))->with('success', 'Вы не можете редактировать чужой лот');
    }
}