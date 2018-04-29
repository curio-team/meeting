@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
    	{{ $schoolyear->title }}
    </li>
    <li class="breadcrumb-item">
    	{{ $week->title ?? "{$week->start->format('d-m')} - {$week->end->format('d-m')}" }}
    </li>
    <li class="breadcrumb-item">
    	{{ $meeting->title }}
    </li>
    <li class="breadcrumb-item">
    	Bestaand onderwerp
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<form action="{{ route('schoolyears.weeks.meetings.topics.associate', [$schoolyear, $week, $meeting]) }}" method="POST">
		{{ csrf_field() }}

		<h3>Bestaand onderwerp toevoegen</h3>

		@if(count($topics) < 1)
			<div class="alert alert-primary">
				<p>Alle onderwerpen met de status <em>open</em> zijn al verbonden aan deze meeting!</p>
			</div>
		@else
	
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
			<label for="topic" class="col-sm-3 col-form-label">Onderwerp</label>
			<div class="col-sm-6">
				<select required class="form-control" id="topic" name="topic">
					@foreach($topics as $topic)
						<option value="{{ $topic->id }}">{{ $topic->title }}</option>
					@endforeach
				</select>
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
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
			</div>
		</div>

		@endif
	</form>

@endsection