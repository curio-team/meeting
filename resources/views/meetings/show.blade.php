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
					<td>2 min</td>
					<td>Welkom, vaststellen agenda en notulist</td>
					<td></td>
					<td></td>
					<td class="d-print-none"></td>
				</tr>

				<?php $end = 0; ?>
				@foreach($meeting->agendables as $agendable)
					<tr>
						<td>{{ $end = $loop->iteration+1 }}.</td>
						<td>{{ $agendable->agenda_item->duration ? $agendable->agenda_item->duration.' min' : '' }}</td>
						<td>{{ $agendable->title }}</td>
						<td></td>
						<td>{{ $agendable->agenda_item->added_by }}</td>
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