@extends('layouts.app')

@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
	<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script>
@endpush

@section('content')
	
	<div class="meeting topic">
		<div class="info">
			<h2 class="page-title">{{ $topic->title }}</h2>
			<p class="lead">Notulen voor onderwerp</p>

			<table class="table table-borderless table-sm">
				<tr>
					<th>Besproken in</th>
					<td>
						@foreach($topic->meetings as $meeting)
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
			</table>
		</div>
		
		<div class="comments">
			<h5>Notulen</h5>
			@each('minutes.comment', $topic->comments, 'comment')
			<form action="{{ route('meeting.minute.comment', [$meeting, $topic]) }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="comment" id="comment">
				@include('layouts.trix', ['field' => 'comment'])
				<button type="submit" class="mt-2 btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
			</form>
		</div>
		
		<div class="tasks">
			<h5>Acties</h5>
			@if(count($topic->tasks))
				<div class="list-group">
					@foreach($topic->tasks as $task)
						<a href="#" class="list-group-item">
							<div class="d-flex justify-content-between align-items-center">
								{{ $task->title }}
								<span class="badge badge-info">{{ $task->slug }}</span>
							</div>
							<small class="text-muted">
								{{ $task->owner }},
								gemaakt op {{ $task->created_at->format('d-m-Y') }}
							</small>
						</a>
					@endforeach

					<div href="#" class="list-group-item">
						<div>Nieuwe actie</div>
						<form action="{{ route('meeting.minute.task', [$meeting, $topic]) }}" method="POST">
							{{ csrf_field() }}
							<input type="text" name="title" class="form-control" placeholder="Actie...">
							<div class="d-flex justify-content-between mt-2">
								<input type="text" name="owner" class="form-control" placeholder="Eigenaar">
								<select name="agendate" class="form-control ml-2">
									<option value="0">Zet op agenda</option>
									<option value="0">- geen -</option>
									@foreach($meetings as $m)
										<option value="{{ $m->id }}">{{ $m->title }} {{ $m->week->title }}</option>
									@endforeach
								</select>
								<button class="ml-2 btn btn-light"><i class="fas fa-save"></i></button>
							</div>
						</form>
					</div>
				</div>
			@endif
		</div>

	</div>

@endsection