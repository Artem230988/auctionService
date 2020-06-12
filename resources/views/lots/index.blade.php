@extends('layouts.layout')

@section('content')
	<h2>{{ $page_name }}</h2>
	<div class="row">
		@foreach($lots as $lot)
		<div class="col-6">
			<div class="card">
				<div class="card-header"><h5>{{ $lot->title }}</h5></div>
				<div class="card-body">
					<div class="card-img" style="background-image: url({{ $lot->images->first()->img ?? asset('img/3.jpg')}})"></div><br>
					<div class="card-count">Текущая ставка: <b>{{ $lot->current_rate }}</b></div>
					<div class="card-count">Начальая ставка: {{ $lot->starting_rate }}</div>
					<div class="card-time">{{$lot->completion_time < now() ? 'Лот закрыт' : 'Лот закроется: '.$lot->completion_time}}</div>
					<a href="{{route('lots.show', $lot->id)}}" class="btn btn-primary">Посмотреть</a>
				</div>
			</div>
		</div>
		@endforeach
	</div>
 {{ $lots->links() }}

@endsection