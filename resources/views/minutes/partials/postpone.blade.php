<h5 class="mt-3">Vooruitschuiven</h5>
<form action="{{ route('listings.attach', $listing) }}" method="POST" class="m-0">
	{{ csrf_field() }}
	<div class="input-group">
		<select name="meeting" class="form-control">
			<option value="0">Zet op agenda voor komende meeting</option>
			@foreach($meetings as $m)
				<option value="{{ $m->id }}">{{ $m->title }} {{ $m->week->title }}</option>
			@endforeach
		</select>
		<div class="input-group-append">
			<button type="submit" class="btn"><i class="fas fa-plus"></i></button>
		</div>
	</div>
</form>
