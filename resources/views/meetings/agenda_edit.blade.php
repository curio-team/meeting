@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
    	<a href="{{ route('schoolyears.show', $schoolyear) }}">{{ $schoolyear->title }}</a>
    </li>
    <li class="breadcrumb-item">
    	{{ $week->title ?? "{$week->start->format('d-m')} - {$week->end->format('d-m')}" }}
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('schoolyears.weeks.meetings.show', [$schoolyear, $week, $meeting]) }}">{{ $meeting->title }}</a>
    </li>
    <li class="breadcrumb-item">
    	Agenda aanpassen
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<div class="meeting">
		
		@include('meetings.partials.head')

		<h4 class="mt-5 mb-3">Agenda</h4>
		<form action="{{ route('meetings.listings.update', $meeting) }}" method="POST">
			{{ csrf_field() }}
            {{ method_field('PATCH') }}

			@include('meetings.partials.edit')
			<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
		</form>

	</div>

@endsection