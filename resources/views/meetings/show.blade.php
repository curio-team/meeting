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
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ route('schoolyears.show', $schoolyear) }}">
        <i class="fas fa-chevron-left"></i> Terug
    </a>
@endsection

@section('content')
	<div class="meeting">
		<h2 class="page-title">{{ $meeting->title }}</h2>
		<p class="lead">{{ ucfirst($meeting->date->formatLocalized('%A %e %B %Y')) }}</p>

		<table class="table table-borderless table-sm">
			<tr>
				<th>Schooljaar</th>
				<td>{{ $schoolyear->title }}</td>
			</tr>
			<tr>
				<th>Week</th>
				<td>{{ $week->title ?? 'Onbekend' }}</td>
			</tr>
		</table>
		
		@if(count($suggestions))
			<div class="d-print-none">
				<h4 class="mt-5">Suggesties</h4>
				<p>Er zijn suggesties aanwezig voor week {{ $week->title }}:</p>
				<table class="table table-borderless table-sm">
					@foreach($suggestions as $suggestion)
						<tr>
							<td>{{ $loop->iteration }}.</td>
							<td>{{ $suggestion->title }}</td>
							<td>
								<a href="{{ route('suggestions.add', [$suggestion, $meeting]) }}"><i class="fas fa-plus"></i> Toevoegen</a>,
								<a href="{{ route('suggestions.ignore', [$suggestion, $schoolyear]) }}"><i class="fas fa-ban"></i> Negeren</a>,
								<a href="{{ route('suggestions.edit', $suggestion) }}" target="_blank"><i class="fas fa-edit"></i> Aanpassen</a>
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		@endif

		<div class="d-flex justify-content-between mt-5 mb-3">
			<h4>Agenda</h4>
			<div class="btn-group d-print-none">
				<a class="btn btn-outline-secondary" href="{{ route('schoolyears.weeks.meetings.topics.create', [$schoolyear, $week, $meeting]) }}"><i class="fas fa-plus"></i> Nieuw</a>
				<a class="btn btn-outline-secondary" href="{{ route('schoolyears.weeks.meetings.topics.add', [$schoolyear, $week, $meeting]) }}"><i class="fas fa-plus"></i> Bestaand</a>
				<a class="btn btn-outline-secondary" href="{{ route('schoolyears.weeks.meetings.order', [$schoolyear, $week, $meeting]) }}"><i class="fas fa-sort"></i> Volgorde</a>
				<a class="btn btn-outline-secondary" href="#"><i class="fas fa-edit"></i> Notuleren</a>
			</div>
		</div>

		<table class="table table-hover">
			<thead>
				<tr>
					<th style="width: 50px;">&nbsp;</th>
					<th style="width: 75px;">Tijd</th>
					<th>Onderwerp</th>
					<th>Ref.</th>
					<th>Toegevoegd door</th>
					<th class="d-print-none">Acties</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1.</td>
					<td></td>
					<td>Welkom, vaststellen agenda en notulist</td>
					<td></td>
					<td></td>
					<td class="d-print-none"></td>
				</tr>

				<?php $end = 1; ?>
				@foreach($meeting->agenda_items as $agenda_item)
					<tr>
						<td>{{ $end = $loop->iteration+1 }}.</td>
						<td>{{ $agenda_item->listing->duration ? $agenda_item->listing->duration.' min' : '' }}</td>
						<td>{{ $agenda_item->title }}</td>
						<td></td>
						<td>{{ $agenda_item->listing->added_by }}</td>
						<td class="d-print-none"></td>
					</tr>
				@endforeach

				<tr>
					<td>{{ $end+1 }}.</td>
					<td></td>
					<td>Rondvraag</td>
					<td></td>
					<td></td>
					<td class="d-print-none"></td>
				</tr>
			</tbody>
		</table>
	</div>
@endsection