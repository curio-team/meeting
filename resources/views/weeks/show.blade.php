@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('schoolyears.show', $schoolyear) }}">{{ $schoolyear->title }}</a>
    </li>
    <li class="breadcrumb-item">
    	Weken benoemen
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ route('schoolyears.show', $schoolyear) }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<h3 class="page-title">Weken benoemen voor schooljaar <em>{{ $schoolyear->title }}</em></h3>

	@include('layouts.errors')

	<p class="mb-0">Instructie:</p>
	<ul>
		<li>Voer alle weeknummers en periodes in, sla daarbij de vakanties en studieweken over.</li>
		<li>Bij weken die niet genummerd zijn, laat je het vakje leeg</li>
		<li>Je kunt een opmerking invoeren, maar dat hoeft niet (studieweek, startweek, etc.).</li>
		<li>Het vinkje <em>vergadering maken</em> genereert een nieuwe teamvergadering voor die week.</li>
	</ul>

	<form action="{{ route('schoolyears.weeks.store', $schoolyear) }}" method="POST">
		{{ csrf_field() }}
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Week-nr.</th>
					<th>Datum</th>
					<th>Periode</th>
					<th>Week</th>
					<th>Vergadering maken</th>
					<th>Opmerkingen</th>
				</tr>
			</thead>
			<tbody>
				@foreach($weeks as $week)
					<tr>
						<td>
							<input type="hidden" name="weeks[{{ $week->iso_week }}][id]" value="{{ $week->id }}">
							<input type="hidden" name="weeks[{{ $week->iso_week }}][iso_week]" value="{{ $week->iso_week }}">
							<input type="hidden" name="weeks[{{ $week->iso_week }}][year]" value="{{ $week->year }}">
							{{ $week->iso_week }}
						</td>
						<td>{{ $week->start->format('d-m') }} - {{ $week->end->format('d-m') }}</td>
						<td>
							<input type="text" tabindex="1" name="weeks[{{ $week->iso_week }}][term]" class="form-control num-box" value="{{ old('weeks.'.$week->iso_week.'.term', $week->term) }}">
						</td>
						<td>
							<input type="text" tabindex="1" name="weeks[{{ $week->iso_week }}][week]" class="form-control num-box" value="{{ old('weeks.'.$week->iso_week.'.week', $week->week) }}">
						</td>
						<td>
							<input type="checkbox" tabindex="1" name="weeks[{{ $week->iso_week }}][meeting]" value="1">
						</td>
						<td>
							<input type="text" tabindex="0" name="weeks[{{ $week->iso_week }}][description]" class="form-control" value="{{ old('weeks.'.$week->iso_week.'.description', $week->description) }}">
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div>
			<label for="day">Plaats gegenereerde vergaderingen op:</label>
			<select name="day" id="day">
				<option value="0" selected>maandag</option>
				<option value="1">dinsdag</option>
				<option value="2">woensdag</option>
				<option value="3">donderdag</option>
				<option value="4">vrijdag</option>
			</select>.
		</div>
		
		<button class="btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
	</form>

@endsection