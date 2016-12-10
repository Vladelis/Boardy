	<?php
		//include 'utils/mysql.class.php';
		//$db = new mysql();
		//$result = $db -> insertNewKlientas('pastas@pastas.lt', md5('123456'), NULL, NULL, NULL, 0, $_SERVER['REMOTE_ADDR']);
		//echo $result;
		//die();
	?>
	
	<?php
		$error = [];
		if(isset($_POST['submitreg'])) {
			if(isset($_POST['slaptazodis']) && isset($_POST['slaptazodis2']) && 
				$_POST['slaptazodis2'] != $_POST['slaptazodis']) {
				$error['slaptazodis'] = true;
			}
			if(!isset($_POST['taisykles']) || $_POST['taisykles'] != "on" ) {
				$error['taisykles'] = true;
			}
			if(isset($_POST['slaptazodis']) && strlen($_POST['slaptazodis'])<6) {
				$error['slaptazodioIlgis'] = true;
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
			if(isset($error['taisykles'])) {
				echo '<p>Privaloma sutikti su taisyklėmis</p>';
			}
			if(isset($error['slaptazodis'])) {
				echo '<p>Slaptažodžiai turi sutapti</p>';
			}
			if(isset($error['slaptazodioIlgis'])) {
				echo '<p>Slaptažodis turi būti sudarytas iš bent 6 simbolių</p>';
			}
			echo			'
					</div>
				</div>
			';
		} else if(isset($_POST['submitreg'])){
			$db = new mysql();
			$pastas = $_POST["epastas"];
			$slaptazodis = $_POST['slaptazodis'];
			if(isset($_POST["vardas"])) {
				$vardas = $_POST["vardas"];
			} else {
				$vardas = NULL;
			}
			if(isset($_POST["pavarde"])) {
				$pavarde = $_POST["pavarde"];
			} else {
				$pavarde = NULL;
			}
			if(isset($_POST["slapyvardis"])) {
				$slapyvardis = $_POST["slapyvardis"];
			} else {
				$slapyvardis = NULL;
			}
			if(isset($_POST['naujienlaiskiai'])) {
				$naujienlaiskiai = 1;
			} else {
				$naujienlaiskiai = 0;
			}
			//echo $naujienlaiskiai;
			$result = $db -> insertNewKlientas($pastas, md5($slaptazodis), $vardas, $pavarde, $slapyvardis, $naujienlaiskiai, $_SERVER['REMOTE_ADDR']);
			echo '
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Registracija sėkminga</h3>
					</div>
					<div class="panel-body">
						<p>Registracija sėkminga, prašome pasitikrinti elektroninį paštą ir patvirtinti registraciją.</p>
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
						if (isset($_POST["epastas"])) {
							echo '<input type="text" class="form-control" name="vardas" placeholder="Vardas" value='.$_POST["vardas"].'>';
						} else {
							echo '<input type="text" class="form-control" name="vardas" placeholder="Vardas">';
						}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="pavarde" class="col-lg-4 control-label">Pavardė</label>
				<div class="col-lg-8">
					<?php
						if (isset($_POST["epastas"])) {
							echo '<input type="text" class="form-control" name="pavarde" placeholder="Pavarde" value='.$_POST["pavarde"].'>';
						} else {
							echo '<input type="text" class="form-control" name="pavarde" placeholder="Pavarde">';
						}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="slapyvardis" class="col-lg-4 control-label">Slapyvardis</label>
				<div class="col-lg-8">
					<?php
						if (isset($_POST["epastas"])) {
							echo '<input type="text" class="form-control" name="slapyvardis" placeholder="Slapyvardis" value='.$_POST["slapyvardis"].'>';
						} else {
							echo '<input type="text" class="form-control" name="slapyvardis" placeholder="Slapyvardis">';
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
			<div class="checkbox">
				<div class="col-lg-12">
					<label>
						<input type="checkbox" name="naujienlaiskiai"> Noriu gauti naujienlaiškius
					</label>
				</div>
			</div>
			<div class="checkbox">
				<div class="col-lg-12">
					<label>
						<input type="checkbox" name="taisykles"> Sutinku su taisyklėmis
					</label>
				</div>
				<!-- cia reikia iterpti taisykliu puslapi -->
				<a href="" class="btn btn-link">Skaityti taisykles</a>
			</div>
			<div class="checkbox">
			</div>
			<div class="form-group">
				<input type="submit" name="submitreg" value="Registruotis" class="btn btn-primary" />
			</div>
		</form>
	</div>