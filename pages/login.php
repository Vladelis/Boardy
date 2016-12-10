	<?php
	/*
		$db = new mysql();
		$result = $db -> checkUserLogin("klientas2@klientai.lt", md5('123456'));
		if(isset($result)) {
			echo "HI MOM";
			echo var_dump($result);
		} else {
			echo "OOPS";
		}
		*/
	?>
	
	<div class="col-md-12">
		<legend style="padding-top:20px">Prisijunkite</legend>
		<form class="form-horizontal col-md-8" method="post" action="">
			<div class="form-group">
			  <label>Elektroninis paštas</label>
			  <input type="email" class="form-control" name="epastas" placeholder="pastas@pastas.lt" required>
			</div>
			<div class="form-group">
			  <label>Slaptažodis</label>
			  <input type="password" class="form-control" name="slaptazodis" placeholder="Slaptažodis" required>
			</div>
			<?php
				if(isset($_POST['submitlogin'])) {
					$email=$_POST['epastas'];
					$password=$_POST['slaptazodis'];
					$db = new mysql();
					$result = $db -> checkUserLogin($email, md5($password));
					if(isset($result)) {
						$_SESSION['user'] = $result;
						header("Location: index.php");
						die();
					}
					else {
						echo "<div class='alert alert-dismissible alert-danger form-group'>
							<p>Neteisingas elektroninis paštas arba slaptažodis</p>
						</div>";
					}
				}
			?>
			<div class="form-group">				
				<input type="submit" name="submitlogin" value="Prisijungti" class="btn btn-primary" />
			</div>
		</form>
		
	</div>
	
	