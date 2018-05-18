@extends('layouts.app')

@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
	<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script>
@endpush

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
        {{ $listing->order+1 }}. {{ $task->title }}   
    </li>
@endsection

@section('content')
	
	@include('layouts.partials.status')

	<div class="meeting task">
		<div class="info">
			<h2 class="page-title d-flex justify-content-between align-items-center">
				{{ $listing->order+1 }}. {{ $task->title }}
				<span class="badge badge-info">{{ $task->slug }}</span>
			</h2>
			<p class="lead">Notulen voor actie</p>

			<table class="table table-borderless table-sm">
				<tr>
					<th>Besproken in</th>
					<td>
						@foreach($task->meetings as $m)
							@if($m->week->number)
								Week {{ $m->week->number }} - 
							@elseif($m->week->description)
								{{ $m->week->description }} - 
							@endif
							{{ $m->title }}
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
						<td>
							<a href="{{ route('topics.show', $task->topic) }}" target="_blank">{{ $task->topic->title }}</a>
						</td>
					</tr>
				@endif
			</table>
		</div>
		
		@include('minutes.partials.next')

		<div class="comments">
			<h5>Notulen</h5>
			@each('minutes.partials.comment', $task->comments, 'comment')

			@if($task->open)
				<form action="{{ route('tasks.comments.store', $task) }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="comment" id="comment">
					@include('layouts.partials.trix', ['field' => 'comment'])
					<button type="submit" class="mt-2 btn btn-success"><i class="fas fa-save"></i> Toevoegen</button>
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

@endsection
