@extends('layouts.master')

@section('title')
	Welcome
@endsection

@section('content')
	@include('includes.message-block')
	<div class="row">
		<div class="col-md-6">
			<h3>Sign Up</h3>
			<form id="signupForm" action="{{ route('user.signup') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="email">Your E-mail</label>
					<input class="form-control" type="email" name="email" id="email" value="{{ Request::old('email') }}">
				</div>
				<div class="form-group">
					<label for="first_name">Your First Name</label>
					<input class="form-control" type="text" name="first_name" id="first_name" value="{{ Request::old('first_name') }}">
				</div>
				<div class="form-group">
					<label for="password">Your Password</label>
					<input class="form-control" type="password" name="password" id="password">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<div class="col-md-6">
			<h3>Sign In</h3>
			<form id="signinForm" action="{{ route('login') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="email">Your E-mail</label>
					<input class="form-control" type="email" name="email" id="email" value="{{ Request::old('email') }}">
				</div>
				<div class="form-group">
					<label for="password">Your Password</label>
					<input class="form-control" type="password" name="password" id="password">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
@endsection