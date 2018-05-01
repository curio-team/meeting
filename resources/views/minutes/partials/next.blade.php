<div class="next d-flex justify-content-center align-items-center">
	<p>
		@if($next != null)
			<a href="{{ route('meeting.minute.item', [$meeting, $next->listing->id]) }}" class="btn btn-light">Volgende: {{ $next->title }} <i class="fas fa-chevron-right"></i></a>
		@else
			<a href="{{ route('meeting.minute.end', $meeting) }}" class="btn btn-light">Volgende: Rondvraag <i class="fas fa-chevron-right"></i></a>
		@endif
	</p>
</div>
