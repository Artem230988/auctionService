@extends('layouts.layout')

@section('content')

	<div class="row">
@php
$today = \Carbon\Carbon::now();
$completion_time = \Carbon\Carbon::parse($lot->completion_time);
$diffSec = $today->diffInSeconds($completion_time, false);
$days = floor($diffSec / 86400);
$hours = floor(($diffSec - $days*86400) / 3600);
$minutes = floor(($diffSec - $days*86400 - $hours*3600) / 60);
$seconds = $diffSec - $days*86400 - $minutes*60 - $hours*3600;
@endphp
		<div class="col-10">
			<div class="card">
				<div class="card-header"><h5>{{ $lot->title }}</h5></div>
				<div class="card-body">

					@if($lot->completion_time > now())
						<div class="card-count mycard1"><b>Текущая ставка: {{ $lot->current_rate }}</b></div>
						@if(Auth::user()->id != $lot->owner_id)
							<a href="{{route('lots.editRate', $lot->id)}}" class="btn btn-primary myBtn1">Повысить</a>
						@endif
						@if(Auth::user()->id == $lot->owner_id)
							<form method="post" action="{{ route('lots.stopLot', $lot->id) }}" class="myform5">
			                    @csrf
			                    @method('PATCH')
			                    <button type="submit" class="btn btn-danger mybtn5">Завершить досрочно</button>
			                </form>
							<a href="{{route('lots.edit', $lot->id)}}" class="btn btn-primary myBtn2">Редактировать лот</a>
						@endif
						<div class="card-buyer"><b>Текущий владелец: {{ $name }}</b></div>
						<div class="card-time"><b>Лот закроется: {{$lot->completion_time}}</b><br>
						До окончания лота осталось: <b>{{ $time_left }}</b></div>
						<div class="card-count">Начальая ставка: {{ $lot->starting_rate }}</div>
						<div class="card-description">Описание: {{ $lot->description }}</div>
						@foreach($lot->images as $image)
							@if(Auth::user()->id == $lot->owner_id)
								<form method="post" action="{{ route('images.destroy', $image->id) }}">
			                        @csrf
			                        @method('DELETE')
			                        <button type="submit" class="btn btn-danger mybtn3">Удалить</button>
			                    </form>
		                    @endif
		                    <div class="card-img card-img_max" style="background-image: url({{ $image->img }})"></div>
						@endforeach
					@endif

					@if($lot->completion_time < now())
						<div class="card-buyer"><b>Лот приобрел: {{ $name }}</b></div>
						<div class="card-time"><b>Лот закрылся: {{$lot->completion_time}}</b></div>
						<div class="card-count mycard1"><b>Ставка закрытия лота: {{ $lot->current_rate }}</b></div>
						<div class="card-count">Начальая ставка: {{ $lot->starting_rate }}</div>
						<div class="card-description">Описание: {{ $lot->description }}</div>
						@foreach($lot->images as $image)
		                    <div class="card-img card-img_max" style="background-image: url({{ $image->img }})"></div>
						@endforeach
					@endif


				</div>
			</div>
		</div>

	</div>



@endsection