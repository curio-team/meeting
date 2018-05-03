@extends('layouts.app')

@section('more-breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('schoolyears.show', $meeting->week->schoolyear) }}">{{ $meeting->week->schoolyear->title }}</a>
    </li>
    <li class="breadcrumb-item">
        {{ $meeting->week->title ?? "{$meeting->week->start->format('d-m')} - {$meeting->week->end->format('d-m')}" }}
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('schoolyears.weeks.meetings.show', [$meeting->week->schoolyear, $meeting->week, $meeting]) }}">{{ $meeting->title }}</a>
    </li>
    <li class="breadcrumb-item">
        Notulen   
    </li>
@endsection

@section('content')

	<div class="meeting">
		
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
				<th>Duur geschat</th>
				<td>
					{{ \Carbon\Carbon::now()->subMinutes($meeting->agenda_items->sum('listing.duration'))->diffForHumans(null, true, false, 2) }}
				</td>
			</tr>
			<tr>
				<th>Duur werkelijk</th>
				<td>
					{{ $meeting->started_at->diffForHumans($meeting->closed_at, true, false, 2) }}
				</td>
			</tr>
			<tr>
				<th>Notulist</th>
				<td>
					{{ \App\User::find($meeting->minuted_by) }}
				</td>
			</tr>
		</table>


		<div class="alert alert-info d-print-none">
			<i class="fas fa-print"></i> Deze pagina is geschikt voor <em>afdrukken als pdf</em>.
		</div>

		<h4 class="my-4">Notulen</h4>
		
		<h5>1. Welkom, vaststellen agenda en notulist</h5>
		<hr class="my-5">

		@foreach($meeting->agenda_items as $item)

			<div class="minute">
				@unless($loop->first)<hr class="my-5">@endunless

				<div class="mb-3">
					<h5 class="m-0 d-flex justify-content-between align-items-center">
						{{ $loop->iteration+1 }}. {{ $item->title }}
						@if($item instanceof \App\Task)
							<div>
								<span class="badge badge-info">{{ $item->owner }}</span>
								<span class="badge badge-info">{{ $item->slug }}</span>
							</div>
						@endif
					</h5>
					
					<p>
						Status: {{ $item->open ? 'nog open' : 'gesloten' }}.
					</p>
				</div>

				<div class="list-group">
					@foreach($my_items[$item->listing->id] as $event)
						<div class="list-group-item">
							<div class="minutes-state-block">
								@if($event['type'] == 'comment')
									<div>
										<div class="trix-content">{!! $event['text'] !!}</div>
										<small>
											{{ $event['date']->format('d-m-Y H:i') }}
											door {{ $event['user'] }}
										</small>
									</div>
									<i class="far fa-comment"></i>
								@else
									<div>
										<p><em>{{ $event['text'] }}</em>{{ isset($event['payload']) ? ':' : '' }}</p>
										@if(isset($event['payload']))
											<p>{{ $event['payload'] }}</p>
										@endif
										@if(isset($event['date']))
										<p><small>
											{{ $event['date']->format('d-m-Y H:i') }}
											@if(isset($event['user']))
												door {{ $event['user'] }}
											@endif
										</small></p>
										@endif
									</div>
									<i class="fas fa-fw fa-info"></i>
								@endif
							</div>	
						</div>
					@endforeach
				</div>		
			</div>
		@endforeach
	</div>

@endsection