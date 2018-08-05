@extends('layouts.master')

@section('title')
	Dashboard
@endsection

@section('content')
	<div class="row title-container">
		<h3>Dashboard</h3>
		@if (Auth::check())
		<h4>Login as {{ Auth::user()->email }}</h4>
		@endif
	</div>
	<div class="row dashboard-container">
		@include('includes.message-block')
		<div class="col-md-6">
			<header>
				<h4>New Post</h4>
			</header>
			<form action="{{ route('posts.store') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<textarea class="form-control" name="body" id="body" rows="5" placeholder="Message here..."></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Create Post</button>
			</form>
		</div>
		<div class="col-md-6">
			<header>
				<h4>Other Posts</h4>
			</header>
			@foreach ($posts as $post)
			<article class="post" data-postid="{{ $post->id }}">
				<p>{{ $post->body }}</p>
				<div class="info">
					Posted by {{ $post->user->first_name }} on {{ date("F jS, Y", strtotime($post->created_at)) }}
				</div>
				<div class="interaction">
					<a href="#" class="btn {{ Auth::user()->likes()->where('post_id', $post->id)->first() ? 'like':'unlike' }}" id="like-btn">Like</a>
					@if(Auth::user()->id == $post->user_id)
					<a href="#" class="btn edit">Edit</a>
					<a href="{{ route('posts.delete', $post->id) }}" class="btn delete">Delete</a>
					@endif
				</div>
			</article>
			<hr>
			@endforeach
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Edit Post</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<textarea class="form-control" name="body" id="edit-body" rows="5" placeholder="Message here..."></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			var token = '{{ Session::token() }}';
			var urlEdit = '{{ route('posts.update') }}';
			var urlLike = '{{ route('posts.like') }}';
		</script>
	</div>
@endsection