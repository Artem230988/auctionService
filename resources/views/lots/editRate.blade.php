@extends('layouts.layout')

@section('content')

	<form action="{{ route('lots.updateRate', $lot->id) }}" method="post">
		@csrf
		@method('PATCH')
		<h4>Повысить ставку</h4><br>
		<div class="form-group">
			<h7>Введите новую ставку больше чем {{$lot->current_rate}}</h7>
			<input type="text" class="form-control" name="current_rate" required placeholder="Введите новую ставку">
		</div>

		<input type="submit" value="Изменить ставку" class="btn btn-outline-success">

	</form>

@endsection