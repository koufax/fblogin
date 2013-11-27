<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>Login Page</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<h1>Login</h1>
			<!-- Display any form errors if any. -->
			{{ HTML::ul($errors->all()) }}
			
			{{ Form::open(array('url' => 'user')) }}
				<div class="form-group">
					{{ Form::label('email', 'Email') }}
					{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
				</div>
				{{ Form::submit('Login', array('class' => 'btn btn-primary')) }}
			{{ Form::close() }}
			
			<br />
			- OR -
			<br /><br />
			
			<div class="form-group">
				<label>Log in with one of the social network buttons below:</label>
			</div>
			<a class="btn btn-lg btn-primary" href="{{url('user/social')}}">
				<i class="icon-facebook"></i>
				Login with Facebook
			</a>
		</div>
	</body>
</html>