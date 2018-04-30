@extends('layouts.app')

@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
	<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script>
@endpush

@section('content')
	
	<div class="meeting">
		<h2 class="page-title">{{ $topic->title }}</h2>
		<p class="lead">Notulen voor onderwerp</p>

		<table class="table table-borderless table-sm">
			<tr>
				<th>Besproken in</th>
				<td>
					@foreach($topic->meetings as $meeting)
						@if($meeting->week->number)
							Week {{ $meeting->week->number }} - 
						@elseif($meeting->week->description)
							{{ $meeting->week->description }} - 
						@endif
						{{ $meeting->title }}
						@unless($loop->last)<br />@endunless
					@endforeach
				</td>
			</tr>
		</table>
		
		<form action="{{ route('minute.comment', $topic) }}" method="POST">
			{{ csrf_field() }}
			<input type="hidden" name="comment" id="comment">
			@include('layouts.trix', ['field' => 'comment'])
			<button type="submit" class="mt-2 btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
		</form>

	</div>

@endsection