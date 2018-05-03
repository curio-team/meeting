<div class="list-group-item">
	<div class="d-flex justify-content-between align-items-center">
		{{ $task->title }}
		<span class="badge badge-info">{{ $task->slug }}</span>
	</div>
	<small class="text-muted">
		{{ $task->owner }},
		gemaakt op {{ $task->created_at->format('d-m-Y') }}
	</small>
</div>
