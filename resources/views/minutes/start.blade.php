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
	<a class="btn btn-outline-light" href="{{ route('schoolyears.weeks.meetings.show', [$schoolyear, $week, $meeting]) }}">
        <i class="fas fa-chevron-left"></i> Terug
    </a>
@endsection

@section('content')
	<div class="meeting">
		
		<h2 class="page-title">1. Agenda vaststellen</h2>
		@includeWhen(count($suggestions), 'meetings.partials.suggestions')

		<h4 class="mt-5">Toevoegen</h4>
		<p>Voeg nog een extra punt toe:</p>

		<div class="list-group">
         	<form action="{{ route('meeting.minute.add', $meeting) }}" method="POST" class="list-group-item d-flex justify-content-between align-items-center m-0">
                {{ csrf_field() }}
                <input type="text" name="title" class="form-control" placeholder="Titel">
                <div class="input-group ml-3">
                	<input type="text" name="duration" class="form-control" placeholder="Duur">
                	<div class="input-group-append">
                		<span class="input-group-text">min</span>
                	</div>
                </div>
				<button type="submit" class="btn btn-outline-secondary ml-3" href="#"><i class="fas fa-plus"></i> Toevoegen</button>
            </form>
		</div>
		
		<h4 class="mt-5 mb-3">Agenda</h4>
		<form action="{{ route('meeting.minute.save', $meeting) }}" method="POST">
			{{ csrf_field() }}

			@include('meetings.partials.edit')
			<button type="submit" class="btn btn-success">Opslaan en verder <i class="fas fa-chevron-right"></i></button>
		</form>
		
	</div>
@endsection
