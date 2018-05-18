@extends('layouts.app')

@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
	<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script>
@endpush

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
        {{ $task->title }}   
    </li>
@endsection

@section('content')
	
	@include('layouts.partials.status')

	<div class="meeting task">
		<div class="info">
			<h2 class="page-title d-flex justify-content-between align-items-center">
				{{ $task->title }}
				<span class="badge badge-info">{{ $task->slug }}</span>
			</h2>

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
		
		<div></div>

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
					<span class="list-group-item list-group-item-light">
						<i class="fas fa-fw fa-eye"></i>
						{{ ($task->resonated_at ? 'Geresoneerd op ' . $task->resonated_at : 'Taak nog niet geresoneerd') }}
					</span>
					<span class="list-group-item list-group-item-light">
						<i class="fas fa-fw fa-anchor"></i>
						{{ ($task->secured_at ? 'Geborgd op ' . $task->secured_at : 'Taak nog niet geborgd') }}
					</span>
					<span class="list-group-item list-group-item-light">
						<i class="fas fa-fw fa-check"></i>
						{{ ($task->filed_at ? 'Afgerond op ' . $task->filed_at : 'Taak nog niet afgerond') }}
					</span>
				</div>
			</form>
			
		</div>
	</div>

@endsection
