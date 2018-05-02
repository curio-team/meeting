<div class="next d-flex justify-content-center align-items-center">
	<p>
		@if($next != null)
			<a href="{{ route('meetings.minutes.listing', [$meeting, $next->listing->id]) }}" class="btn btn-light">Volgende: {{ $next->title }} <i class="fas fa-chevron-right"></i></a>
		@else
			<a href="{{ route('meetings.minutes.end', $meeting) }}" class="btn btn-light">Volgende: Rondvraag <i class="fas fa-chevron-right"></i></a>
		@endif
	</p>
</div>
