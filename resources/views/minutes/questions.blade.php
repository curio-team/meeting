@extends('layouts.app')

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
        Rondvraag   
    </li>
@endsection

@section('content')
 
	<h2 class="page-title">Rondvraag</h2>

	<div class="list-group my-4">
     	<form action="{{ route('meetings.topics.store', $meeting) }}" method="POST" class="list-group-item d-flex justify-content-between align-items-center m-0">
            {{ csrf_field() }}
            <input type="hidden" name="go" value="1">
            <input type="text" name="title" class="form-control" placeholder="Titel">
            <input type="text" name="added_by" class="form-control ml-3" placeholder="Punt van...">
			<button type="submit" class="btn btn-outline-secondary ml-3" href="#">Opslaan en notuleren <i class="fas fa-chevron-right"></i></button>
        </form>
	</div>

    <form action="{{ route('meetings.minutes.close', $meeting) }}" method="POST" class="mt-0 mb-4">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-lg btn-success">
            <i class="fas fa-gavel"></i> Vergadering sluiten
        </button>
    </form>

@endsection
