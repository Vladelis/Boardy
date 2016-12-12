<?php
	if(empty($_SESSION['user'])) {
		header("Location: index.php");
		die();
	}
	
	if(isset($_POST['submitred'])) {
		echo "Registruotas submit";
		//die();
	}
	
	$db = new mysql();
	
	// Ar darbuotojas perziuri klienta
	$arPerziuretiKlienta = false;
	if(isset($_POST['submitperKlienta'])) {
		$data = $db -> getFullKlientasData($_POST['klientoPastas']);
		if(count($data)>0) {
			$arPerziuretiKlienta = true;
		} else {
			// Show error and return button
			echo '
				<div class="col-md-12">
					<label class="col-lg-12 control-label">Klientas nerastas</label>
				</div>
			';
			echo '
				<div class="col-md-12">
					<a class="btn btn-primary" href="index.php?module=profiliu_perziura">Atgal</a>
				</div>
			';
		}
	}
	
	// Ar vadybininkas perziuri darbuotojai
	$arPerziuretiDarbuotoja = false;
	if(isset($_POST['submitperDarbuotojas'])) {
		$data = $db -> getFullDarbuotojasData($_POST['darbuotojoKodas']);
		if(count($data)>0) {
			$arPerziuretiDarbuotoja = true;
		} else {
			// Show error and return button
			echo '
				<div class="col-md-12">
					<label class="col-lg-12 control-label">Darbuotojas nerastas</label>
				</div>
			';
			echo '
				<div class="col-md-12">
					<a class="btn btn-primary" href="index.php?module=profiliu_perziura">Atgal</a>
				</div>
			';
		}
	}
	
	// Jei vartotojas - ziuri save, arba ji ziuri darbuotojai
	if($_SESSION['user']['fk_role_id']==1 || $arPerziuretiKlienta){
		$email = "";
		if($arPerziuretiKlienta) {
			$email = $_POST['klientoPastas'];
		} else {
			$email = $_SESSION['user']['email'];
		}
		$data = $db -> getFullKlientasData($email);
		echo '
			<div class="col-md-12">
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Elektroninis paštas :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$data[0]['email'].'">
							<label class="control-label">'.$data[0]['email'].'</label>
						</div>
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Vardas :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$data[0]['email'].'">
							<input type="text" class="hidden" name="vardasKlientas" value="'.$data[0]['vardas'].'">
							<label class="control-label">'.$data[0]['vardas'].'</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Redaguoti" class="btn btn-primary" />
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Pavarde :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$data[0]['email'].'">
							<input type="text" class="hidden" name="pavardeKlientas" value="'.$data[0]['pavarde'].'">
							<label class="control-label">'.$data[0]['pavarde'].'</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Redaguoti" class="btn btn-primary" />
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Slapyvardis :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$data[0]['email'].'">
							<input type="text" class="hidden" name="slapyvardisKlientas" value="'.$data[0]['slapyvardis'].'">
							<label class="control-label">'.$data[0]['slapyvardis'].'</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Redaguoti" class="btn btn-primary" />
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Naujienlaiškiai :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$data[0]['email'].'">
							<input type="text" class="hidden" name="naujienlaiskisKlientas" value="'.$data[0]['ar_nori_naujienlaiskio'].'">
							<label class="control-label">'; if($data[0]['ar_nori_naujienlaiskio']==1) echo "Užsakyti"; else "Atsisakyta"; echo '</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Redaguoti" class="btn btn-primary" />
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Slaptažodis :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$data[0]['email'].'">
							<input type="text" class="hidden" name="slaptazodisKlientas" value="redaguoti">
							<label class="control-label">******</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Redaguoti" class="btn btn-primary" />
					</div>
				</form>
		';
		echo '
			</div>
		';
	}
	
	// Jei darbuotojas - ziuri save, arba ji ziuri vadybininkas
	if(($_SESSION['user']['fk_role_id']==2 || $_SESSION['user']['fk_role_id']==3) && (isset($_POST['submitperSave']) || (isset($_POST['submitperDarbuotojas']) && $arPerziuretiDarbuotoja)) ){
		$kodas = "";
		if($arPerziuretiDarbuotoja) {
			$kodas = $_POST['darbuotojoKodas'];
		} else {
			$kodas = $_SESSION['user']['kodas'];
		}
		$data = $db -> getFullDarbuotojasData($kodas);
		echo '
			<div class="col-md-12">
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Kodas :</label>
						<div class="col-lg-8">
							<label class="control-label">'.$data[0]['kodas'].'</label>
						</div>
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Vardas :</label>
						<div class="col-lg-8">
							<label class="control-label">'.$data[0]['vardas'].'</label>
						</div>
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Pavardė :</label>
						<div class="col-lg-8">
							<label class="control-label">'.$data[0]['pavarde'].'</label>
						</div>
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Elektroninis paštas :</label>
						<div class="col-lg-8">
							<input type="text" class="hidden" name="kodas" value="'.$data[0]['kodas'].'">
							<input type="text" class="hidden" name="epastas" value="redaguoti">
							<label class="control-label">'.$data[0]['email'].'</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Redaguoti" class="btn btn-primary" />
					</div>
				</form>
		';
		echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_redagavimas">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Slaptažodis :</label>
						<div class="col-lg-8">
							<input type="text" class="hidden" name="kodas" value="'.$data[0]['kodas'].'">
							<input type="text" class="hidden" name="slaptazodisDarbuotojas" value="redaguoti">
							<label class="control-label">******</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Redaguoti" class="btn btn-primary" />
					</div>
				</form>
		';
		echo '
			</div>
		';
	}
	
	// Jei darbuotojas - ziuri save arba klienta
	if(($_SESSION['user']['fk_role_id']==2 || $_SESSION['user']['fk_role_id']==3) && !isset($_POST['submitperKlienta']) && !isset($_POST['submitperSave']) && !isset($_POST['submitperDarbuotojas']) ){
		// submitperKlienta arba submitperSave
		echo '
			<div class="col-md-12">
		';
		// Rodyti pasirinkimus
			echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_perziura">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Peržiūrėti klientą</label>
						<div class="col-lg-8">
							<input type="email" class="form-control" name="klientoPastas" placeholder="pastas@pastas.lt" required>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitperKlienta" value="Peržiūrėti" class="btn btn-primary" />
					</div>
				</form>
			';
			// Jei vadybininkas tai gali ir darbuotoja ziureti
			if($_SESSION['user']['fk_role_id']==3) {
				echo '
					<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_perziura">
						<div class="form-group col-md-8">
							<label class="col-lg-4 control-label">Peržiūrėti darbuotoją</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="darbuotojoKodas" placeholder="000000000000000000000000000000" required>
							</div>
						</div>
						<div class="form-group col-md-4">
							<input type="submit" name="submitperDarbuotojas" value="Peržiūrėti" class="btn btn-primary" />
						</div>
					</form>
				';
			}
			echo '
				<form class="form-horizontal col-md-12" method="post" action="index.php?module=profiliu_perziura">
					<div class="form-group col-md-4">
						<label class="col-lg-8 control-label">Peržiūrėti savo profilį</label>
						<input type="submit" name="submitperSave" value="Peržiūrėti" class="btn btn-primary" />
					</div>
				</form>
			';
		echo '
			</div>
		';
	}
?>