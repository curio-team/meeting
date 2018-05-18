@extends('layouts.app')

@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
	<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script>
@endpush

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('schoolyears.show', $meeting->week->schoolyear) }}">{{ $meeting->week->schoolyear->title }}</a>
    </li>
    <li class="breadcrumb-item">
        {{ $meeting->week->title ?? "{$meeting->week->start->format('d-m')} - {$meeting->week->end->format('d-m')}" }}
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('schoolyears.weeks.meetings.show', [$meeting->week->schoolyear, $meeting->week, $meeting]) }}">{{ $meeting->title }}</a>
    </li>
    <li class="breadcrumb-item">
        Nieuw onderwerp  
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<form action="{{ route('schoolyears.weeks.meetings.topics.store', [$schoolyear, $week, $meeting]) }}" method="POST">
		{{ csrf_field() }}

		<h3>Nieuw onderwerp</h3>
	
		@include ('layouts.errors')

		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Schooljaar</label>
			<div class="col-sm-6">
				<input type="text" readonly class="form-control-plaintext" value="{{ $schoolyear->title }}">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Week</label>
			<div class="col-sm-6">
				<input type="text" readonly class="form-control-plaintext" value="{{ $week->title }} ({{ $week->start->format('d-m') }} - {{ $week->end->format('d-m') }})">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label">Meeting</label>
			<div class="col-sm-6">
				<input type="text" readonly class="form-control-plaintext" value="{{ $meeting->title }}">
			</div>
		</div>
		<div class="form-group row">
			<label for="title" class="col-sm-3 col-form-label">Titel</label>
			<div class="col-sm-6">
				<input type="text" required class="form-control" id="title" name="title">
			</div>
		</div>
		<div class="form-group row">
			<label for="duration" class="col-sm-3 col-form-label">Duur (schatting)</label>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="number" required class="form-control" id="duration" name="duration" min="0">
					<div class="input-group-append">
						<span class="input-group-text">minuten</span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="duration" class="col-sm-3 col-form-label">Opmerking (optioneel, bijvoorbeeld voor een mededeling)</label>
			<div class="col-sm-6">
				<input type="hidden" name="comment" id="comment">
				@include('layouts.partials.trix', ['field' => 'comment'])
			</div>
		</div>


		<div class="form-group row">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
			</div>
		</div>
	</form>

@endsection