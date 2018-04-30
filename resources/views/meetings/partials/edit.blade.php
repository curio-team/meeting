<table class="table table-hover">
	<thead>
		<tr>
			<th style="width: 50px;">&nbsp;</th>
			<th style="width: 110px;">Tijd</th>
			<th>Onderwerp</th>
			<th>Volgorde</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>1.</td>
			<td></td>
			<td>Welkom, vaststellen agenda en notulist</td>
			<td></td>
		</tr>

		<?php $end = 0; ?>
		@foreach($meeting->agenda_items as $agenda_item)
			<tr>
				<td>{{ $end = $loop->iteration+1 }}.</td>
				<td>
					<input type="number" name="items[{{ $agenda_item->listing->id }}][duration]" value="{{ $agenda_item->listing->duration ?? '' }}" min="0" style="width: 50px; text-align: right;"> min
				</td>
				<td>{{ $agenda_item->title }}</td>
				<td>
					<input type="number" name="items[{{ $agenda_item->listing->id }}][order]" value="{{ $agenda_item->listing->order ?? '' }}">
				</td>
			</tr>
		@endforeach

		<tr>
			<td>{{ $end+1 }}.</td>
			<td></td>
			<td>Rondvraag</td>
			<td></td>
		</tr>
	</tbody>
</table>
