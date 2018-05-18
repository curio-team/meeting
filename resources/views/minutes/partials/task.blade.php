<div class="list-group-item">
	<div class="d-flex justify-content-between align-items-center">
		<a href="{{ route('tasks.show', $task) }}" target="_blank">{{ $task->title }}</a>
		<span class="badge badge-info">{{ $task->slug }}</span>
	</div>
	<small class="text-muted">
		{{ $task->owner }},
		gemaakt op {{ $task->created_at->format('d-m-Y') }}
	</small>
</div>
