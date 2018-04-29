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

		<h5>Agenda</h5>
		<p>
			<a href="{{ route('schoolyears.weeks.meetings.topics.create', [$schoolyear, $week, $meeting]) }}"><i class="fas fa-plus"></i> Nieuw onderwerp</a>,
		</p>
		<ol>
			@foreach($meeting->topics as $topic)
				<li>{{ $topic->title }} ({{ $topic->agenda_item->added_by }}, {{ $topic->agenda_item->duration }}min)</li>
			@endforeach
		</ol>
	</div>
@endsection