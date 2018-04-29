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
    	Volgorde aanpassen
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')
	<div class="meeting">
		<h2 class="page-title">{{ $meeting->title }}</h2>
		<p class="lead">{{ ucfirst($meeting->date->formatLocalized('%A %e %B %Y')) }}</p>

		<h4 class="mt-5 mb-3">Agenda</h4>

		<form action="{{ route('schoolyears.weeks.meetings.sort', [$schoolyear, $week, $meeting]) }}" method="POST">
			{{ csrf_field() }}

			<table class="table table-hover">
				<thead>
					<tr>
						<th style="width: 50px;">&nbsp;</th>
						<th style="width: 75px;">Tijd</th>
						<th>Onderwerp</th>
						<th>Volgorde</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1.</td>
						<td>2 min</td>
						<td>Welkom, vaststellen agenda en notulist</td>
						<td></td>
					</tr>

					<?php $end = 0; ?>
					@foreach($meeting->agendables as $agendable)
						<tr>
							<td>{{ $end = $loop->iteration+1 }}.</td>
							<td>{{ $agendable->agenda_item->duration ? $agendable->agenda_item->duration.' min' : '' }}</td>
							<td>{{ $agendable->title }}</td>
							<td>
								<input type="number" name="order[{{ $agendable->agenda_item->id }}]" value="{{ $agendable->agenda_item->order ?? '' }}">
							</td>
						</tr>
					@endforeach

					<tr>
						<td>{{ $end+1 }}.</td>
						<td></td>
						<td>Rondvraag</td>
						<td></td>
					</tr>
				</tbody>
			</table>
			
			<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Opslaan</button>

		</form>
	</div>
@endsection