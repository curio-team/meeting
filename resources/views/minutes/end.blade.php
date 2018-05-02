@extends('layouts.app')

@section('content')
 
	<h2 class="page-title">Rondvraag</h2>

	<div class="list-group mt-3">
         	<form action="{{ route('meetings.topics.store', $meeting) }}" method="POST" class="list-group-item d-flex justify-content-between align-items-center m-0">
                {{ csrf_field() }}
                <input type="hidden" name="go" value="1">
                <input type="text" name="title" class="form-control" placeholder="Titel">
                <input type="text" name="added_by" class="form-control ml-3" placeholder="Punt van...">
				<button type="submit" class="btn btn-outline-secondary ml-3" href="#">Opslaan en notuleren <i class="fas fa-chevron-right"></i></button>
            </form>
		</div>

@endsection
