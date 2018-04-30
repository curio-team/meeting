<h2 class="page-title">{{ $meeting->title }}</h2>
<p class="lead">{{ ucfirst($meeting->date->formatLocalized('%A %e %B %Y')) }}</p>

<table class="table table-borderless table-sm">
	<tr>
		<th>Schooljaar</th>
		<td>{{ $schoolyear->title }}</td>
	</tr>
	<tr>
		<th>Week</th>
		<td>{{ $week->title ?? 'Onbekend' }}</td>
	</tr>
	<tr>
		<th>Duur</th>
		<td>&plusmn;{{ $meeting->agenda_items->sum('listing.duration') }} min</td>
	</tr>
</table>
