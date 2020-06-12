@extends('layouts.layout')

@section('content')

	<form action="{{ route('lots.update', $lot->id) }}" method="post" enctype="multipart/form-data">
		@csrf
		@method('PATCH')
		<h4>Изменить лот</h4><br>
		<div class="form-group">
			<h7>Изменить название лота:</h7>
			<input type="text" class="form-control" name="title" required placeholder="Введите название лота" value="{{ old('title') ?? $lot->title }}">
		</div>

		<div class="form-group">
			<h7>Изменить описание лота:</h7>
			<input type="text" class="form-control" name="description" required placeholder="Введите описание лота" value="{{ old('description') ?? $lot->description }}">
		</div>

		<h7>Если вы ошиблись при вводе начальной ставки - обратитесь в тех.поддержку</h7><br><br>

		<div class="form-group">
			<input type="file" name="img[]" multiple placeholder="Добавить картинки">
		</div>

		<input type="submit" value="Изменить" class="btn btn-outline-success">

	</form>

@endsection