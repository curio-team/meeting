@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
    	Nieuw schooljaar
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<form action="{{ route('schoolyears.store') }}" method="POST">
		{{ csrf_field() }}

		<h3>Nieuw schooljaar maken</h3>
	
		@include ('layouts.errors')

		<div class="form-group row">
			<label for="start" class="col-sm-2 col-form-label">Eerste dag</label>
			<div class="col-sm-10">
				<input type="date" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="form-control" id="start" name="start" placeholder="dd-mm-jjjj">
			</div>
		</div>
		<div class="form-group row">
			<label for="end" class="col-sm-2 col-form-label">Laatste dag</label>
			<div class="col-sm-10">
				<input type="date" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="form-control" id="end" name="end" placeholder="dd-mm-jjjj">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success">Volgende <i class="fas fa-chevron-right"></i></button>
			</div>
		</div>
	</form>

@endsection