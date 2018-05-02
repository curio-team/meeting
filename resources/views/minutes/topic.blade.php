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
		
		@include('minutes.partials.next')

		<div class="comments">
			<h5>Notulen</h5>
			@each('minutes.partials.comment', $topic->comments, 'comment')

			@if($topic->open)
				<form action="{{ route('meeting.minute.comment', [$meeting, 'topic', $topic->id]) }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="comment" id="comment">
					@include('layouts.partials.trix', ['field' => 'comment'])
					<button type="submit" class="mt-2 btn btn-success"><i class="fas fa-save"></i> Opslaan</button>
				</form>
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
			
			@if($topic->open)
				<h5 class="mt-3">Vooruitschuiven</h5>
				<form action="" class="m-0">
					<div class="input-group">
						<select name="agendate" class="form-control">
							<option value="0">Zet op agenda voor komende meeting</option>
							@foreach($meetings as $m)
								<option value="{{ $m->id }}">{{ $m->title }} {{ $m->week->title }}</option>
							@endforeach
						</select>
						<div class="input-group-append"><button class="btn"><i class="fas fa-plus"></i></button></div>
					</div>
				</form>
			@endif
		</div>
	</div>

	<hr class="my-5">

	<h5>Acties</h5>
	<div class="list-group">
		
		@each('minutes.partials.task', $topic->tasks, 'task')

		<div class="list-group-item">
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

@endsection
