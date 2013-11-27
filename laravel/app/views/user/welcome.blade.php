<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>Welcome Page</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-inverse">
				<ul class="nav navbar-nav">
					<li><a href="{{ URL::to('user/logout')}}">Logout</a></li>
				</ul>
			</nav>
		</div>
		<h2>Welcome {{ $user->first_name }}!</h2>
	</body>
</html>