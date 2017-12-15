<!DOCTYPE html>
<html>
<head>
	<?php include '../shared/meta.php'; ?>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-offset-3 text-center" style="margin-top: 100px">
				<div class="jumbotron">
					<img src="images/photo-machine.png" class="img-thumbnail" width="100"><br><br>
					<form action="registration.php" method="post">
						<div class="form-group">
							<label for="inputUsername">Username</label>
							<input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username" />
						</div>
						<div class="form-group">
							<label for="inputPassword">Password</label>
							<input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" />
						</div>
						<div class="form-group">
							<label for="inputEmail">Email</label>
							<input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" />
						</div>
						<input type="submit" value="Sign up" />
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
