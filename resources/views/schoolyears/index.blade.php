@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
    	Alle jaren
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ route('schoolyears.create') }}">
        <i class="fas fa-plus"></i> Schooljaar
    </a>
@endsection

@section('content')
	
	<div class="card-deck">
		@foreach($schoolyears as $schoolyear)
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">{{ $schoolyear->title }}</h5>
					<a href="{{ route('schoolyears.show', $schoolyear) }}">Bekijk schooljaar</a>
				</div>
			</div>
		@endforeach
	</div>

@endsection