@extends('layouts.app')

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
        Onderwerp toevoegen  
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<h2 class="page-title my-5">Bestaand onderwerp toevoegen</h2>
	@include ('layouts.partials.status')
	<div class="card-deck">
		<div class="card">
			<div class="card-body">
				<form action="{{ route('meetings.topics.attach', $meeting) }}" method="POST" class="m-0">
					<h5>Onderwerpen</h5>
					{{ csrf_field() }}{{ method_field('PATCH') }}
					@if(count($topics) < 1)
						<p>Alle onderwerpen met de status <em>open</em> zijn al verbonden aan deze meeting!</p>
					@else
						<select required class="form-control" name="topic">
							@foreach($topics as $topic)
								<option value="{{ $topic->id }}">{{ $topic->title }}</option>
							@endforeach
						</select>
						<div class="d-flex justify-content-between mt-2">
							<div class="input-group">
								<input type="number" required class="form-control" id="duration" name="duration" min="0" placeholder="Duur">
								<div class="input-group-append">
									<span class="input-group-text">minuten</span>
								</div>
							</div>
							<button type="submit" class="btn btn-light ml-2"><i class="far fa-save"></i> Opslaan</button>
						</div>
					@endif
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<form action="{{ route('meetings.tasks.attach', $meeting) }}" method="POST" class="m-0">
					<h5>Acties</h5>
					{{ csrf_field() }}{{ method_field('PATCH') }}
					@if(count($tasks) < 1)
						<p>Alle acties met de status <em>open</em> zijn al verbonden aan deze meeting!</p>
					@else
						<select required class="form-control" name="task">
							@foreach($tasks as $task)
								<option value="{{ $task->id }}">{{ $task->slug }} - {{ $task->title }}</option>
							@endforeach
						</select>
						<div class="d-flex justify-content-between mt-2">
							<div class="input-group">
								<input type="number" required class="form-control" id="duration" name="duration" min="0" placeholder="Duur">
								<div class="input-group-append">
									<span class="input-group-text">minuten</span>
								</div>
							</div>
							<button type="submit" class="btn btn-light ml-2"><i class="far fa-save"></i> Opslaan</button>
						</div>
					@endif
				</form>
			</div>
		</div>
	</div>

@endsection