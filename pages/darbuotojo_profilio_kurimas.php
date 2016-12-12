	<?php
		// Jei bando pasiekti ne vadybininkas ismesti
		if(!empty($_SESSION['user'])) {
			if($_SESSION['user']['fk_role_id']!=3) {
				header("Location: index.php");
				die();
			}
		}
	?>
	
	<?php
		function random_str($length = 30, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
			$charactersLength = strlen($keyspace);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $keyspace[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		$db = new mysql();
		
		
		$error = [];
		
		if(isset($_POST['submitreg'])) {
			if(isset($_POST['slaptazodis']) && isset($_POST['slaptazodis2']) && 
				$_POST['slaptazodis2'] != $_POST['slaptazodis']) {
				$error['slaptazodis'] = true;
			}
			if((isset($_POST['slaptazodis']) && strlen($_POST['slaptazodis'])<6) || (isset($_POST['slaptazodis2']) && strlen($_POST['slaptazodis2'])<6)) {
				$error['slaptazodioIlgis'] = true;
			}			
		}
		if(isset($_POST['epastas'])) {
			$yraEmail = $db -> checkForSameEmailDarbuotojas($_POST['epastas']);
			if(count($yraEmail)!=0) {
				$error['emailasRegistruotas'] = true;
			}
		}
		// Kodas turi buti unikalus ir tik is skaiciu/raidziu
		if(isset($_POST['kodas'])) {
			$yraKodas = $db -> checkForSameKodas($_POST['kodas']);
			if(!isset($yraKodas)) {
				$error['kodas'] = true;
			}
			if(!ctype_alnum($_POST['kodas'])) {
				$error['kodasSudarymas'] = true;
			}
			if(strlen($_POST['kodas'])>30) {
				$error['kodasSimboliai'] = true;
			}
		}
		if(isset($_POST['submitreg']) && !empty($error)) {
			echo '
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Neteisingi laukai</h3>
					</div>
					<div class="panel-body">
						';
			if(isset($error['emailasRegistruotas'])) {
				echo '<p>Elektroninis paštas jau yra registruotas</p>';
			}
			if(isset($error['slaptazodis'])) {
				echo '<p>Slaptažodžiai turi sutapti</p>';
			}
			if(isset($error['slaptazodioIlgis'])) {
				echo '<p>Slaptažodis turi būti sudarytas iš bent 6 simbolių</p>';
			}
			if(isset($error['kodas'])) {
				echo '<p>Kodas turi būti unikalus</p>';
			}
			if(isset($error['kodasSudarymas'])) {
				echo '<p>Kodas turi būti sudarytas tik iš raidžių is skaitmenų</p>';
			}
			if(isset($error['kodasSimboliai'])) {
				echo '<p>Kodas turi būti iki 30 simbolių ilgio</p>';
			}
			echo			'
					</div>
				</div>
			';
		} else if(isset($_POST['submitreg'])){
			$pastas = $_POST["epastas"];
			$slaptazodis = $_POST['slaptazodis'];
			$vardas = $_POST["vardas"];
			$pavarde = $_POST["pavarde"];
			$kodas = $_POST['kodas'];
			// 2 gale tai darbuotojo tipas
			$result = $db -> insertNewDarbuotojas($pastas, md5($slaptazodis), $vardas, $pavarde, $kodas, $_SERVER['REMOTE_ADDR'], 2);
			echo '
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Registracija sėkminga</h3>
					</div>
					<div class="panel-body">
						<p>Registracija sėkminga.</p>
					</div>
				</div>
				<div id="footer" class="col-md-12">
					<hr>
					<p>2016 Stalo žaidimų nuomos informacinė sistema. </p>
				</div>
				';
			die();	
		}
		
	?>
	
	<div class="col-md-12">
		<legend style="padding-top:20px">Registracija</legend>
		<form class="form-horizontal col-md-8" method="post" action="">
			<div class="form-group">
				<label for="epastas" class="col-lg-4 control-label">Elektroninis paštas</label>
				<div class="col-lg-8">
					<?php
						if (isset($_POST["epastas"])) {
							echo '<input type="email" class="form-control" name="epastas" placeholder="pastas@pastas.lt" required value='.$_POST["epastas"].'>';
						} else {
							echo '<input type="email" class="form-control" name="epastas" placeholder="pastas@pastas.lt" required>';
						}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="vardas" class="col-lg-4 control-label">Vardas</label>
				<div class="col-lg-8">
					<?php
						if (isset($_POST["vardas"])) {
							echo '<input type="text" class="form-control" name="vardas" placeholder="Vardas" value='.$_POST["vardas"].'>';
						} else {
							echo '<input type="text" class="form-control" name="vardas" placeholder="Vardas" required>';
						}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="pavarde" class="col-lg-4 control-label">Pavardė</label>
				<div class="col-lg-8">
					<?php
						if (isset($_POST["pavarde"])) {
							echo '<input type="text" class="form-control" name="pavarde" placeholder="Pavarde" value='.$_POST["pavarde"].'>';
						} else {
							echo '<input type="text" class="form-control" name="pavarde" placeholder="Pavarde" required>';
						}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="slapyvardis" class="col-lg-4 control-label">Darbuotojo kodas(tik raidės ir skaitmenys, iki 30 simbolių)</label>
				<div class="col-lg-8">
					<?php
						// cia reikia generuoti koda
						if (isset($_POST["kodas"])) {
							echo '<input type="text" class="form-control" name="kodas" placeholder="Kodas" value='.$_POST["kodas"].'>';
						} else {
							$randomKodas = random_str();
							// Del visa ko
							$failsafe = 0;
							while (!$db -> checkForSameKodas($randomKodas)){
								$randomKodas = random_str();
								$failsafe = $failsafe + 1;
								if ($failsafe>100000) {
									die();
								}
							}
							echo '<input type="text" class="form-control" name="kodas" placeholder="Kodas" value='.$randomKodas.' required>';
						}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="slaptazodis" class="col-lg-4 control-label">Slaptažodis(bent 6 simboliai)</label>
				<div class="col-lg-8">
					<input type="password" class="form-control" name="slaptazodis" placeholder="Slaptažodis" required>
				</div>
			</div>
			<div class="form-group">
				<label for="slaptazodis2" class="col-lg-4 control-label">Pakartokite slaptažodį</label>
				<div class="col-lg-8">
					<input type="password" class="form-control" name="slaptazodis2" placeholder="Slaptažodis" required>
				</div>
			</div>	
			<div class="form-group">
				<input type="submit" name="submitreg" value="Registruotis" class="btn btn-primary" />
			</div>
		</form>
	</div>