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
		
		@include('meetings.partials.head')
		@includeWhen(count($suggestions), 'meetings.partials.suggestions')

		<div class="d-flex justify-content-between mt-5 mb-3">
			<h4>Agenda</h4>
			<div class="btn-group d-print-none">
				<a class="btn btn-outline-secondary" href="{{ route('schoolyears.weeks.meetings.topics.create', [$schoolyear, $week, $meeting]) }}"><i class="fas fa-plus"></i> Nieuw</a>
				<a class="btn btn-outline-secondary" href="{{ route('schoolyears.weeks.meetings.topics.add', [$schoolyear, $week, $meeting]) }}"><i class="fas fa-plus"></i> Bestaand</a>
				<a class="btn btn-outline-secondary" href="{{ route('schoolyears.weeks.meetings.agenda.edit', [$schoolyear, $week, $meeting]) }}"><i class="fas fa-edit"></i> Agenda aanpassen</a>
				<a class="btn btn-outline-secondary" href="{{ route('meeting.minute', $meeting) }}"><i class="fas fa-gavel"></i> Start notuleren</a>
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
						<td>
							{{ ($agenda_item instanceof \App\Task) ? $agenda_item->slug : '' }}
						</td>
						<td>{{ $agenda_item->listing->added_by }}</td>
						<td class="d-print-none">
							<a href="{{ route('meeting.minute.item', [$meeting, $agenda_item->listing->id]) }}" target="_blank"><i class="fas fa-gavel"></i> Notuleren</a>
						</td>
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