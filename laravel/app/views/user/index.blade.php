<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>View Users</title>
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
			
			@if (isset($objUsers) && !empty($objUsers))
			<h1>Viewing all users</h1>
			
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<td>ID</td>
						<td>Name</td>
						<td>Email</td>
						<td>Facebook Name</td>
					</tr>
				</thead>
				
				<tbody>
				@foreach($objUsers as $intKey => $objUserData)
					<tr>
						<td>{{ $objUserData->id }}</td>
						<td>{{ $objUserData->name }}</td>
						<td>{{ $objUserData->email }}</td>
						<td>{{ $objUserData->facebook_name }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			@else
			<h1>No users exist at this time</h1>
			@endif
		</div>
	</body>
</html>