@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
    	Zoeken
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ url()->previous() }}">
        <i class="fas fa-times"></i> Annuleren
    </a>
@endsection

@section('content')

	<h2 class="page-title my-5">Zoeken</h2>
	@include ('layouts.partials.status')
	<div class="card-deck">
		<div class="card">
			<div class="card-body">
				<form action="{{ route('search.titles') }}" method="POST" class="m-0">
					<h5>Zoek op titel</h5>
					<p>Vind onderwerpen en taken op basis van titel.</p>
					{{ csrf_field() }}
					<div class="d-flex justify-content-between mt-2">
						<input type="text" required class="form-control" name="q" placeholder="Titel...">
						<button type="submit" class="btn btn-light ml-2">
							<i class="fas fa-search"></i> Zoeken
						</button>
					</div>
				</form>

				@if(isset($result))
					<ul class="mt-3">
					@foreach($results as $result)
						
						<li>
							<a target="_blank" href="{{ route(($result instanceof \App\Task) ? 'tasks.show' : 'topics.show', $result) }}">
								{{ $result->title }}
							</a>
						</li>

					@endforeach
					</ul>
				@endif

			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<form action="{{ route('search.slug') }}" method="POST" class="m-0">
					<h5>Zoek op kenmerk</h5>
					<p>Ga naar een taak op basis van het kenmerk van drie cijfers/letters.</p>
					{{ csrf_field() }}
					<div class="d-flex justify-content-between mt-2">
						<input type="text" required class="form-control" name="q" placeholder="ab0...">
						<button type="submit" class="btn btn-light ml-2">
							<i class="fas fa-search"></i> Zoeken
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection