@extends('layouts.app')

@section('more-breadcrumbs')
	<li class="breadcrumb-item">
    	Suggesties
    </li>
    <li class="breadcrumb-item">
    	Suggestie aanpassen
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<form action="{{ route('suggestions.update', $suggestion) }}" method="POST">
		{{ method_field('PATCH') }}
		{{ csrf_field() }}

		<h3>Suggestie aanpassen</h3>
	
		@include ('layouts.errors')

		<div class="form-group row">
			<label for="term" class="col-sm-3 col-form-label">Periode</label>
			<div class="col-sm-6">
				<input type="number" required min="1" max="4" class="form-control" id="term" name="term" value="{{ $suggestion->term }}">
			</div>
		</div>
		<div class="form-group row">
			<label for="week" class="col-sm-3 col-form-label">Week</label>
			<div class="col-sm-6">
				<input type="number" required min="1" max="9" class="form-control" id="week" name="week" value="{{ $suggestion->week }}">
			</div>
		</div>
		<div class="form-group row">
			<label for="title" class="col-sm-3 col-form-label">Titel</label>
			<div class="col-sm-6">
				<input type="text" required class="form-control" id="title" name="title" value="{{ $suggestion->title }}">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
			</div>
		</div>
	</form>

@endsection