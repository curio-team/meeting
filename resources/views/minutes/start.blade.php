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
        1. Vaststellen agenda
    </li>
@endsection

@section('content')
	<div class="meeting">
		
		<h2 class="page-title">1. Agenda vaststellen</h2>

        @include('layouts.partials.status')
		@includeWhen(count($suggestions), 'meetings.partials.suggestions')

		<h4 class="mt-5">Toevoegen</h4>
		<p>Voeg nog een extra punt toe:</p>

		<div class="list-group">
         	<form action="{{ route('meetings.topics.store', $meeting) }}" method="POST" class="list-group-item d-flex justify-content-between align-items-center m-0">
                {{ csrf_field() }}
                <input type="text" name="title" class="form-control" placeholder="Titel">
                <div class="input-group ml-3">
                	<input type="text" name="duration" class="form-control" placeholder="Duur">
                	<div class="input-group-append">
                		<span class="input-group-text">min</span>
                	</div>
                </div>
                <input type="text" name="added_by" class="form-control ml-3" placeholder="Toegevoegd door">
				<button type="submit" class="btn btn-outline-secondary ml-3" href="#"><i class="fas fa-plus"></i> Toevoegen</button>
            </form>
		</div>
		
		<h4 class="mt-5 mb-3">Agenda</h4>
		<form action="{{ route('meetings.listings.update', $meeting) }}" method="POST">
			{{ csrf_field() }}
            {{ method_field('PATCH') }}
            <input type="hidden" name="start_minutes" value="1">

			@include('meetings.partials.edit')
			<button type="submit" class="btn btn-success">Opslaan en verder <i class="fas fa-chevron-right"></i></button>
		</form>
		
	</div>
@endsection
