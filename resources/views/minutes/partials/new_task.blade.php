<h5 class="mt-3">Nieuwe actie</h5>
<form action="{{ route('topics.tasks.store', $topic) }}" method="POST" class="m-0">
	{{ csrf_field() }}
	<input type="text" name="title" class="form-control" placeholder="Actie...">
	<div class="d-flex justify-content-between mt-2">
		<input type="text" name="owner" class="form-control" placeholder="Eigenaar">
		<select name="agendate" class="form-control ml-2">
			<option value="0">Zet op agenda</option>
			<option value="0">- geen -</option>
			@foreach($meetings as $m)
				<option value="{{ $m->id }}">{{ $m->title }} {{ $m->week->title }}</option>
			@endforeach
		</select>
		<button class="ml-2 btn btn"><i class="far fa-save"></i></button>
	</div>
</form>
