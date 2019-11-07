@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
    	<a href="{{ route('schoolyears.show', $schoolyear) }}">{{ $schoolyear->title }}</a>
    </li>
    <li class="breadcrumb-item">
    	Nieuw event
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<form action="{{ route('schoolyears.weeks.events.store', [$schoolyear, $week]) }}" method="POST">
		{{ csrf_field() }}

		<h3>Nieuw event maken</h3>
	
		@include ('layouts.errors')

		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Scbooljaar</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control-plaintext" value="{{ $schoolyear->title }}">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Week</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control-plaintext" value="{{ $week->title }} ({{ $week->start->format('d-m') }} - {{ $week->end->format('d-m') }})">
			</div>
		</div>
		<div class="form-group row">
			<label for="date" class="col-sm-2 col-form-label">Dag</label>
			<div class="col-sm-10">
				<select class="form-control" name="date" id="date">
					<?php $date = clone $week->start; ?>
					@while($date <= $week->end)
						<option value="{{ $date->format('Y-m-d') }}" <?php if($date->format('N') == 4) echo 'selected="selected"'; ?>>{{ $date->format('D d-m') }}</option>
						<?php $date->modify('+1 day'); ?>
					@endwhile
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="title" class="col-sm-2 col-form-label">Titel</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="title" name="title">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
			</div>
		</div>
	</form>

@endsection