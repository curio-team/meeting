<div class="card my-4">
	<div class="card-body trix-content">
		{!! $comment->text !!}
	</div>
	<div class="card-footer text-muted">
		{{ $comment->created_at->format('d-m-Y') }} door {{ $comment->author }}
	</div>
</div>
