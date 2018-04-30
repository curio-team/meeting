@extends('layouts.app')

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
			<tr>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>

@endsection