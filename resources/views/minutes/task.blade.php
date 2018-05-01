@extends('layouts.app')

@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
	<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script>
@endpush

@section('content')
	
	<div class="meeting task">
		<div class="info">
			<h2 class="page-title d-flex justify-content-between align-items-center">
				{{ $task->title }}
				<span class="badge badge-info">{{ $task->slug }}</span>
			</h2>
			<p class="lead">Notulen voor taak</p>

			<table class="table table-borderless table-sm">
				<tr>
					<th>Besproken in</th>
					<td>
						@foreach($task->meetings as $meeting)
							<a href="{{ route('schoolyears.weeks.meetings.show', [$meeting->week->schoolyear, $meeting->week, $meeting]) }}">
								@if($meeting->week->number)
									Week {{ $meeting->week->number }} - 
								@elseif($meeting->week->description)
									{{ $meeting->week->description }} - 
								@endif
								{{ $meeting->title }}
							</a>
							@unless($loop->last)<br />@endunless
						@endforeach
					</td>
				</tr>
				<tr>
					<th>Eigenaar</th>
					<td>{{ $task->owner }}</td>
				</tr>
			</table>
			
			<div class="btn-group mt-3">
				<a href="" class="btn btn-outline-secondary"><i class="fas fa-eye"></i> Geresoneerd</a>
				<a href="" class="btn btn-outline-secondary"><i class="fas fa-anchor"></i> Geborgd</a>
				<a href="" class="btn btn-outline-secondary"><i class="fas fa-check"></i> In envelop</a>
			</div>
		</div>
		
		@include('minutes.partials.next')
	</div>

@endsection
