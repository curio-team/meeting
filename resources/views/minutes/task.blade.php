@extends('layouts.app')

@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
	<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script>
@endpush

@section('content')
	
	@include('layouts.partials.status')

	<div class="meeting task">
		<div class="info">
			<h2 class="page-title d-flex justify-content-between align-items-center">
				{{ $task->title }}
				<span class="badge badge-info">{{ $task->slug }}</span>
			</h2>
			<p class="lead">Notulen voor actie</p>

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

				@if($task->topic != null)
					<tr>
						<th>Bij onderwerp</th>
						<td>{{ $task->topic->title }}</td>
					</tr>
				@endif
			</table>
		</div>
		
		@include('minutes.partials.next')

		<div class="comments">
			<h5>Notulen</h5>
			@each('minutes.partials.comment', $task->comments, 'comment')

			@if($task->open)
				<form action="{{ route('meeting.minute.comment', [$meeting, 'task', $task->id]) }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="comment" id="comment">
					@include('layouts.partials.trix', ['field' => 'comment'])
					<button type="submit" class="mt-2 btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
				</form>
			@endif
		</div>
		
		<div>
			<h5>Status</h5>
			<form action="{{ route('tasks.state', $task) }}" method="POST">
				{{ csrf_field() }}
				<div class="list-group">
					<span class="list-group-item list-group-item-light">
						<i class="fas fa-fw fa-dot-circle"></i> Gemaakt op {{ $task->created_at }}
					</span>

					@if($task->resonated_at == null)
						<button type="submit" name="field" value="resonated_at" class="list-group-item list-group-item-action">
							<i class="fas fa-fw fa-eye"></i> Nu resoneren
						</button>
					@else
						<span class="list-group-item list-group-item-light">
							<i class="fas fa-fw fa-eye"></i> Geresoneerd op {{ $task->resonated_at }}
						</span>
					@endif

					@if($task->secured_at == null)
						<button type="submit" name="field" value="secured_at" class="list-group-item list-group-item-action">
							<i class="fas fa-fw fa-anchor"></i> Nu borgen
						</button>
					@else
						<span class="list-group-item list-group-item-light">
							<i class="fas fa-fw fa-anchor"></i> Geborgd op {{ $task->secured_at }}
						</span>
					@endif

					@if($task->filed_at == null)
						<button type="submit" name="field" value="filed_at" class="list-group-item list-group-item-action">
							<i class="fas fa-fw fa-check"></i> Afronden: in envelop
						</button>
					@else
						<span class="list-group-item list-group-item-light">
							<i class="fas fa-fw fa-check"></i> Afgerond op {{ $task->filed_at }}
						</span>
					@endif
				</div>
			</form>

			@includeWhen($task->open, 'minutes.partials.postpone')
			
		</div>
	</div>

	@if($task->topic != null)
		<hr class="my-5">
		<h2>{{ $task->topic->title }}</h2>
	@endif


@endsection
