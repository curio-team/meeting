<div class="d-print-none">
	<h4 class="mt-5">Suggesties</h4>
	<p>Er zijn suggesties aanwezig voor week {{ $week->title }}:</p>
	
	<div class="list-group">
        @foreach($suggestions as $suggestion)  
			<div class="list-group-item d-flex justify-content-between align-items-center">
				<div>{{ $suggestion->title }}</div>
                <form action="{{ route('suggestions.add', $suggestion) }}" method="POST" class="m-0">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <select name="agendate" class="form-control">
                            <option value="{{ $meeting->id }}">Zet op agenda</option>
                            <option value="{{ $meeting->id }}">{{ $meeting->title }} {{ $meeting->week->title }}</option>
                            <option value="0">----------------</option>
                            @foreach($meetings as $m)
                                <option value="{{ $m->id }}">{{ $m->title }} {{ $m->week->title }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary" href="{{ route('suggestions.add', [$suggestion, $meeting]) }}"><i class="fas fa-plus"></i></button>
                            <a class="btn btn-outline-secondary" href="{{ route('suggestions.ignore', [$suggestion, $schoolyear]) }}"><i class="fas fa-ban"></i> Negeren</a>
                            <a class="btn btn-outline-secondary" href="{{ route('suggestions.edit', $suggestion) }}" target="_blank"><i class="fas fa-edit"></i> Aanpassen</a>
                        </div>
                    </div>
                </form>
			</div>
        @endforeach
	</div>
</div>