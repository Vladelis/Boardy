	<?php
		// Jei vartotojas prisijunges ismesti
		if(!empty($_SESSION['user'])) {
			header("Location: index.php");
			die();
		}
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
						if($result[0]['ar_patvirtintas']==0) {
							echo "<div class='alert alert-dismissible alert-danger form-group'>
							<p>Vartotojas nepatvirtintas, prašome pasitikrinti elektroninį paštą ir patvirtinti vartotoją</p>
							</div>";
						} else {
							$db -> updateUserLogin($_SERVER['REMOTE_ADDR'], $result[0]['email']);
							//die();
							$_SESSION['user'] = $result[0];
							header("Location: index.php");
							die();
						}
					}
					else {
						// Jei ne vartotojas, gal tai darbuotojas?
						$result = $db -> checkDarbuotojasLogin($email, md5($password));
						if(isset($result)) {
							$db -> updateDarbuotojasLogin($_SERVER['REMOTE_ADDR'], $result[0]['email']);
							$_SESSION['user'] = $result[0];
							header("Location: index.php");
							die();
						} else {
							echo "<div class='alert alert-dismissible alert-danger form-group'>
							<p>Neteisingas elektroninis paštas arba slaptažodis</p>
							</div>";
						}
					}
				}
			?>
			<div class="form-group">				
				<input type="submit" name="submitlogin" value="Prisijungti" class="btn btn-primary" />
			</div>
		</form>
		
	</div>
	
	