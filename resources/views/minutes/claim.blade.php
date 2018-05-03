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
        1. Vaststellen agenda en notulist
    </li>
@endsection

@section('content')
		
    <div class="meeting">		
        @include('meetings.partials.head')
		<form action="{{ route('meetings.minutes.claim', $meeting) }}" method="POST">
			{{ csrf_field() }}
			<button type="submit" class="btn btn-lg btn-success">
                <i class="fas fa-fw fa-play"></i>
                Start notuleren als {{ Auth::id() }}
            </button>
		</form>
    </div>

@endsection
