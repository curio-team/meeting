<div class="card">
	<div class="card-body">
		{!! $comment->text !!}
	</div>
	<div class="card-footer text-muted">
		{{ $comment->created_at->format('d-m-Y') }} door {{ $comment->author }}
	</div>
</div>
