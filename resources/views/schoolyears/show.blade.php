@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
    	{{ $schoolyear->title }}
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ route('schoolyears.index') }}">
        <i class="fas fa-folder"></i> Alle jaren
    </a>
    <a class="btn btn-outline-light" href="{{ route('schoolyears.weeks.show', $schoolyear) }}">
        <i class="fas fa-edit"></i> Weken aanpassen
    </a>
@endsection

@section('content')

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th style="width: 130px;">Week</th>
				<th style="width: 70px;">&nbsp;</th>
				<th>Vergadering</th>
				<th>Acties</th>
			</tr>
		</thead>
		<tbody>
			@forelse($schoolyear->weeks as $week)
				<tr>
					<td>{{ $week->start->format('d-m') }} - {{ $week->end->format('d-m') }}</td>
					<td>{{ $week->title }}</td>
					<td>
						@foreach($week->meetings as $meeting)
							<a href="{{ route('schoolyears.weeks.meetings.show', [$schoolyear, $week, $meeting]) }}">{{ $meeting->title }}</a>{{ $loop->last ? '' : ',' }}
						@endforeach
					</td>
					<td><a href="{{ route('schoolyears.weeks.meetings.create', [$schoolyear, $week]) }}"><i class="fas fa-plus"></i> Nieuw</a></td>
				</tr>
			@empty
				<tr>
					<td colspan="4">De weken voor dit schooljaar zijn nog niet benoemd! <a href="{{ route('schoolyears.weeks.create', $schoolyear) }}">Nu regelen &gt;</a></td>
				</tr>
			@endforelse
		</tbody>
	</table>

@endsection