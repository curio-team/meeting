<div class="next d-flex justify-content-center align-items-center text-center">
	<form action="{{ route('meetings.minutes.listing.next', [$meeting, $listing]) }}" method="POST">
		{{ csrf_field() }}
		<div><button type="submit" name="action" value="none" class="btn btn-light">Volgende <i class="fas fa-chevron-right"></i></button></div>

		@if(isset($topic))
			<div class="my-3"><button type="submit" name="action" value="close" class="btn btn-light">Volgende &amp; sluiten <i class="fas fa-chevron-right"></i></button></div>
		@endif
	</form>
</div>
