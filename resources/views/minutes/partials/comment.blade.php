<div class="card my-4">
	<div class="card-body trix-content">
		<?php
			$linkify = new \Misd\Linkify\Linkify(["attr" => ["target" => "_blank"]]);
			echo $linkify->process($comment->text);
		?>
	</div>
	<div class="card-footer text-muted">
		{{ $comment->created_at->format('d-m-Y') }} door {{ $comment->author }}
	</div>
</div>
