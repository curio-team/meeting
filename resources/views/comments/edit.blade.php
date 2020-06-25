@extends('layouts.app')

@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
	<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script>
@endpush

@section('content')
	
	@include('layouts.partials.status')

	<div class="meeting topic">
		<form action="{{ route('comments.update', $comment) }}" method="POST">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<input type="hidden" name="comment" id="comment" value="{{ $comment->text }}">
			@include('layouts.partials.trix', ['field' => 'comment'])
			<button type="submit" class="mt-2 btn btn-success"><i class="fas fa-save"></i> Opslaan en terug</button>
		</form>
	</div>

@endsection
