<div class="card my-4">
	<div class="card-body trix-content">
		<?php
			$linkify = new \Misd\Linkify\Linkify(["attr" => ["target" => "_blank"]]);
			echo $linkify->process($comment->text);
		?>
	</div>
	<div class="card-footer text-muted d-flex justify-content-between">
		<span>{{ $comment->created_at->format('d-m-Y') }} door {{ $comment->author }}</span>
		@if($comment->canEdit())
			<span>
				<a style="color: inherit;" href="{{ route('comments.edit', $comment) }}" onclick="return confirm('Niet-opgeslagen comments gaan verloren!');">
					<i class="fas fa-fw fa-edit"></i>
				</a>
			</span>
		@endif
	</div>
</div>
