@extends('layouts.app')

@section('more-breadcrumbs')
	<li class="breadcrumb-item">
    	Suggesties
    </li>
    <li class="breadcrumb-item">
    	Suggestie verwijderen
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<form action="{{ route('suggestions.destroy', $suggestion) }}" method="POST">
		{{ method_field('DELETE') }}
		{{ csrf_field() }}

		<h3>Weet je het zeker?</h3>
	
		@include ('layouts.errors')

		<p>Je gaat de suggestie <strong>{{ $suggestion->title }}</strong> verwijderen (uit week {{ $suggestion->term }}.{{ $suggestion->week }}).</p>
		<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Verwijderen</button>
	</form>

@endsection