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
        {{ $listing->order+1 }}. {{ $topic->title }}   
    </li>
@endsection

@section('content')
	
	@include('layouts.partials.status')

	<div class="meeting topic">
		<div class="info">
			<h2 class="page-title">{{ $listing->order+1 }}. {{ $topic->title }}</h2>
			<p class="lead">Notulen voor onderwerp</p>

			<table class="table table-borderless table-sm">
				<tr>
					<th>Besproken in</th>
					<td>
						@foreach($topic->meetings as $m)
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
			</table>
		</div>
		
		@include('minutes.partials.next')

		<div class="comments">
			<h5>Notulen</h5>
			@each('minutes.partials.comment', $topic->comments, 'comment')

			@if($topic->open)
				<form action="{{ route('topics.comments.store', $topic) }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="comment" id="comment">
					@include('layouts.partials.trix', ['field' => 'comment'])
					<button type="submit" class="mt-2 btn btn-success"><i class="fas fa-save"></i> Toevoegen</button>
				</form>
			@endif
			@if($topic->tasks->count())
				<hr class="my-3">
				<h5>Acties</h5>
				<div class="list-group">
					@each('minutes.partials.task', $topic->tasks, 'task')
				</div>
			@endif
		</div>
		<div>
			<h5>Status</h5>
			<form action="{{ route('topics.close', $topic) }}" method="POST">
				{{ csrf_field() }}
				<div class="list-group">
					<span class="list-group-item list-group-item-light">
						<i class="fas fa-fw fa-dot-circle"></i> Gemaakt op {{ $topic->created_at }}
					</span>

					@if($topic->closed_at == null)
						<button type="submit" name="field" value="closed_at" class="list-group-item list-group-item-action">
							<i class="fas fa-fw fa-check"></i> Onderwerp sluiten
						</button>
					@else
						<span class="list-group-item list-group-item-light">
							<i class="fas fa-fw fa-check"></i> Gesloten op {{ $topic->closed_at }}
						</span>
					@endif
				</div>
			</form>
			
			@includeWhen($topic->open, 'minutes.partials.postpone')
			@includeWhen($topic->open, 'minutes.partials.new_task')

		</div>
	</div>

@endsection
