<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>Login Page</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-inverse">
				<div class="navbar-header">
					<a class="navbar-brand" href="{{ URL::to('user')}}">User Alert</a>
				</div>
				
				<ul class="nav navbar-nav">
					<li><a href="{{ URL::to('user')}}">View All Users</a></li>
					<li><a href="{{ URL::to('user/login')}}">Login</a></li>
				</ul>
			</nav>
			
			<h1>Login</h1>
			<!-- Display any form errors if any. -->
			{{ HTML::ul($errors->all()) }}
			
			{{ Form::open(array('url' => 'user')) }}
				<div class="form-group">
					{{ Form::label('first_name', 'First Name') }}
					{{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control')) }}
				</div>
				
				<div class="form-group">
					{{ Form::label('last_name', 'Last Name') }}
					{{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control')) }}
				</div>
				
				<div class="form-group">
					{{ Form::label('email', 'Email') }}
					{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
				</div>
				{{ Form::submit('Login!', array('class' => 'btn btn-primary')) }}
			{{ Form::close() }}
		</div>
	</body>
</html>