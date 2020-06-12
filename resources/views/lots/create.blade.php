@extends('layouts.layout')

@section('content')

	<form action="{{ route('lots.store') }}" method="post" enctype="multipart/form-data">
		@csrf
		<h4>Создать лот</h4><br>
		<div class="form-group">
			<h7>Введите название лота:</h7>
			<input type="text" class="form-control" name="title" required placeholder="Введите название лота" value="{{old('title')}}">
		</div>

		<div class="form-group">
			<h7>Введите описание лота:</h7>
			<input type="text" class="form-control" name="description" required placeholder="Введите описание лота"  value="{{old('description')}}">
		</div>

		<div class="form-group">
			<h7>Введите начальную ставку лота:</h7>
			<input type="text" class="form-control" name="starting_rate" required placeholder="Введите начальную ставку"  value="{{old('starting_rate')}}">
		</div>

		<div class="form-group">
			<input type="file" name="img[]" multiple>
		</div>

		<input type="submit" value="Загрузить свой лот" class="btn btn-outline-success">

	</form>

@endsection