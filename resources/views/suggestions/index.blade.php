@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
    	Suggesties
    </li>
@endsection

@section('buttons-right')
	<a class="btn btn-outline-light" href="{{ route('suggestions.create') }}">
        <i class="fas fa-plus"></i> Nieuwe suggestie
    </a>
@endsection

@section('content')
	
	<h2>Suggesties</h2>
	<p>Deze items komen ieder jaar als herinnering terug op de agenda's van de betreffende week.</p>
	<table class="table">
		<tbody>
			<?php $terms = ["Sep", "Feb"]; ?>
			@foreach ($terms as $term)
				<tr><td colspan="3"><strong>Blok {{ $term }}</strong></td></tr>
				@for($week = 1; $week <= 16; $week++)
					
					@forelse($suggestions->where('term', $term)->where('week', $week) as $suggestion)
						<tr>
							<td>@if($loop->first) {{ $term }}.{{ $week }} @endif</td>
							<td>{{ $suggestion->title }}</td>
							<td>
								<a href="{{ route('suggestions.edit', $suggestion) }}"><i class="fas fa-edit"></i> Aanpassen</a>,
								<a href="{{ route('suggestions.delete', $suggestion) }}"><i class="fas fa-trash"></i> Verwijderen</a>
							</td>
						</tr>
					@empty
						<tr>
							<td style="width: 50px;">{{ $term }}.{{ $week }}</td>
							<td></td>
							<td></td>
						</tr>
					@endforelse
					
				@endfor
			@endforeach
		</tbody>
	</table>

@endsection
