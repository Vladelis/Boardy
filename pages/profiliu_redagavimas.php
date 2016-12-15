<?php
	if(empty($_SESSION['user'])) {
		header("Location: index.php");
		die();
	}

	$db = new mysql();
	
	// Jei trinamas klientas
	if(isset($_POST['submitKlientasTrinti'])) {
		if($_SESSION['user']['fk_role_id']!=3) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-md-4">
						<label class="col-lg-12 control-label">Ar tikrai norite trinti klientą '.$_POST['epastas'].'</label>
						<div class="col-lg-12">
							<input type="email" class="hidden" name="epastas" value="'.$_POST['epastas'].'">
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitTrintiKlientaNe" value="Atgal" class="btn btn-default" />
						<input type="submit" name="submitTrintiKlienta" value="Taip" class="btn btn-primary" />
					</div>
				</form>
			';
		}
	}
	if(isset($_POST['submitTrintiKlientaNe'])) {
		header("Location: index.php?module=profiliu_perziura");
		die();
	}
	if(isset($_POST['submitTrintiKlienta'])) {
		$db -> deleteKlientas($_POST['epastas']);
		echo '
			<div class="col-md-8">
				<div class="alert alert-success">
					<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
				</div>
			</div>
		';
	}
	// Jei trinamas darbuotojas
	if(isset($_POST['submitDarbuotojasTrinti'])) {
		if($_SESSION['user']['fk_role_id']!=3) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-md-4">
						<label class="col-lg-12 control-label">Ar tikrai norite trinti darbuotoją '.$_POST['kodas'].'</label>
						<div class="col-lg-12">
							<input type="text" class="hidden" name="kodas" value="'.$_POST['kodas'].'">
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitTrintiDarbuotojaNe" value="Atgal" class="btn btn-default" />
						<input type="submit" name="submitTrintiDarbuotoja" value="Taip" class="btn btn-primary" />
					</div>
				</form>
			';
		}
	}
	if(isset($_POST['submitTrintiDarbuotojaNe'])) {
		header("Location: index.php?module=profiliu_perziura");
		die();
	}
	if(isset($_POST['submitTrintiDarbuotoja'])) {
		$db -> deleteDarbuotojas($_POST['kodas']);
		echo '
			<div class="col-md-8">
				<div class="alert alert-success">
					<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
				</div>
			</div>
		';
	}
	// Jei keiciamas darbuotojo emailas
	if(isset($_POST['epastasDarbuotojas'])) {
		if($_SESSION['user']['fk_role_id']==1 || ($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['kodas']!=$_POST['kodas']) ) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Naujas elektroninis paštas:</label>
						<div class="col-lg-8">
							<input type="text" class="hidden" name="kodas" value="'.$_POST['kodas'].'">
							<input type="email" class="form-control" name="emailDarbuotojasRed" placeholder="pastas@pastas.lt" required>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Keisti" class="btn btn-primary" />
					</div>
				</form>
			';
		}
	}
	// Jei keiciamas darbuotojo	slaptazodis
	if(isset($_POST['slaptazodisDarbuotojas'])) {
		if($_SESSION['user']['fk_role_id']==1 || ($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['kodas']!=$_POST['kodas']) ) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-lg-8">
						<label class="col-lg-4 control-label">Senas slaptažodis :</label>
						<div class="col-lg-8">
							<input type="text" class="hidden" name="kodas" value="'.$_POST['kodas'].'">
							<input type="email" class="hidden" name="epastas" value="'.$_POST['epastas'].'">
							<input type="password" class="form-control" name="slaptazodisDarbuotojasRedOld" placeholder="Senas slaptažodis" required>
						</div>
					</div>
					<div class="form-group col-lg-8">
						<label class="col-lg-4 control-label">Naujas slaptažodis(bent 6 simboliai) :</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" name="slaptazodisDarbuotojasRed" placeholder="Naujas slaptažodis" required>
						</div>
					</div>
					<div class="form-group col-lg-8">
						<label class="col-lg-4 control-label">Pakartokite slaptažodį :</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" name="slaptazodisDarbuotojasRed2" placeholder="Naujas slaptažodis" required>
						</div>
					</div>
					<div class="form-group col-lg-8">
						<label class="col-lg-4 control-label"></label>
						<div class="col-lg-8">
							<input type="submit" name="submitredSlapDarbuotojas" value="Keisti" class="btn btn-primary" />
						</div>
					</div>
				</form>
		';
		}
		
	}
	// Jei keiciamas kliento vardas
	if(isset($_POST['vardasKlientas'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Naujas vardas :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$_POST['epastas'].'">
							<input type="text" class="form-control" name="vardasKlientasRed" placeholder="'.$_POST['vardasKlientas'].'" required>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Keisti" class="btn btn-primary" />
					</div>
				</form>
		';
		}
		
	}
	// Jei keiciama kliento pavarde
	if(isset($_POST['pavardeKlientas'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Nauja pavardė :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$_POST['epastas'].'">
							<input type="text" class="form-control" name="pavardeKlientasRed" placeholder="'.$_POST['pavardeKlientas'].'" required>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Keisti" class="btn btn-primary" />
					</div>
				</form>
		';
		}
		
	}
	// Jei keiciamas kliento slapyvardis
	if(isset($_POST['slapyvardisKlientas'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-md-8">
						<label class="col-lg-4 control-label">Naujas slapyvardis :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$_POST['epastas'].'">
							<input type="text" class="form-control" name="slapyvardisKlientasRed" placeholder="'.$_POST['slapyvardisKlientas'].'" required>
						</div>
					</div>
					<div class="form-group col-md-4">
						<input type="submit" name="submitred" value="Keisti" class="btn btn-primary" />
					</div>
				</form>
		';
		}
		
	}
	// Jei keičiami naujienlaiškių nustatymai
	if(isset($_POST['naujienlaiskisKlientas'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-md-4">
						<label class="col-lg-12 control-label">Naujas nustatymas :</label>
						<div>
							<input type="email" class="hidden" name="epastas" value="'.$_POST['epastas'].'">
							<input type="text" class="hidden" name="naujienlaiskisKlientasRed" value="'.$_POST['naujienlaiskisKlientas'].'">
						</div>
					</div>
					<div class="form-group col-md-4">
			';
			if($_POST['naujienlaiskisKlientas']==1) {
				echo '<input type="submit" name="submitred" value="Atsisakyti" class="btn btn-primary" />';
			} else {
				echo '<input type="submit" name="submitred" value="Užsisakyti" class="btn btn-primary" />';
			}
			echo'
					</div>
				</form>
			';
		}
		
	}
	// Jei keiciamas kliento slaptazodis
	if(isset($_POST['slaptazodisKlientas'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			echo '
				<form class="form-horizontal col-md-12" method="post" action="">
					<div class="form-group col-lg-8">
						<label class="col-lg-4 control-label">Senas slaptažodis :</label>
						<div class="col-lg-8">
							<input type="email" class="hidden" name="epastas" value="'.$_POST['epastas'].'">
							<input type="password" class="form-control" name="slaptazodisKlientasRedOld" placeholder="Senas slaptažodis" required>
						</div>
					</div>
					<div class="form-group col-lg-8">
						<label class="col-lg-4 control-label">Naujas slaptažodis(bent 6 simboliai) :</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" name="slaptazodisKlientasRed" placeholder="Naujas slaptažodis" required>
						</div>
					</div>
					<div class="form-group col-lg-8">
						<label class="col-lg-4 control-label">Pakartokite slaptažodį :</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" name="slaptazodisKlientasRed2" placeholder="Naujas slaptažodis" required>
						</div>
					</div>
					<div class="form-group col-lg-8">
						<label class="col-lg-4 control-label"></label>
						<div class="col-lg-8">
							<input type="submit" name="submitredSlap" value="Keisti" class="btn btn-primary" />
						</div>
					</div>
				</form>
		';
		}
		
	}
	
	// Vykdomas vardo keitimas
	if(isset($_POST['vardasKlientasRed'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			$db -> redaguotiKlientoVarda($_POST['epastas'], $_POST['vardasKlientasRed']);
			$redaguotoId = $db -> getKlientasId($_POST['epastas']);
			$tipas = "";
			if($_SESSION['user']['fk_role_id']==1) {
				$tipas = "klientas_save";
			} else {
				$tipas = "darbuotojas_klienta";
			}
			$db -> insertRedagavimoIstorija($_SERVER['REMOTE_ADDR'], current($redaguotoId[0]), $_SESSION['user']['id'], $tipas);
			echo '
				<div class="col-md-8">
					<div class="alert alert-success">
						<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
					</div>
				</div>
			';
		}
	}
	// Vykdomas pavardes keitimas
	if(isset($_POST['pavardeKlientasRed'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			$db -> redaguotiKlientoPavarde($_POST['epastas'], $_POST['pavardeKlientasRed']);
			$redaguotoId = $db -> getKlientasId($_POST['epastas']);
			$tipas = "";
			if($_SESSION['user']['fk_role_id']==1) {
				$tipas = "klientas_save";
			} else {
				$tipas = "darbuotojas_klienta";
			}
			$db -> insertRedagavimoIstorija($_SERVER['REMOTE_ADDR'], current($redaguotoId[0]), $_SESSION['user']['id'], $tipas);
			echo '
				<div class="col-md-8">
					<div class="alert alert-success">
						<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
					</div>
				</div>
			';
		}
	}
	// Vykdomas slapyvardzio keitimas
	if(isset($_POST['slapyvardisKlientasRed'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			$yraSlapyvardis = null;
			if (strlen($_POST['slapyvardisKlientasRed'])>0) {
				$yraSlapyvardis = $db -> checkForSameSlapyvardis($_POST['slapyvardisKlientasRed']);
			} else {
				$yraSlapyvardis = null;
			}
			if(isset($yraSlapyvardis)) {
				if(count($yraSlapyvardis)!=0) {
					echo '
						<div class="col-md-8">
							<div class="alert alert-danger">
								<strong>Klaida.</strong> Slapyvardis turi būti unikalus. <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal.</a>
							</div>
						</div>
					';
				}
				else {
					$db -> redaguotiKlientoSlapyvardi($_POST['epastas'], $_POST['slapyvardisKlientasRed']);
					$redaguotoId = $db -> getKlientasId($_POST['epastas']);
					$tipas = "";
						if($_SESSION['user']['fk_role_id']==1) {
						$tipas = "klientas_save";
					} else {
						$tipas = "darbuotojas_klienta";
					}
					$db -> insertRedagavimoIstorija($_SERVER['REMOTE_ADDR'], current($redaguotoId[0]), $_SESSION['user']['id'], $tipas);
					echo '
						<div class="col-md-8">
							<div class="alert alert-success">
								<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
							</div>
						</div>
					';
				}
			}
		}
	}
	// Vykdomas naujienlaiskiu keitimas
	if(isset($_POST['naujienlaiskisKlientasRed'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			if($_POST['naujienlaiskisKlientasRed']==1) {
				$db -> redaguotiKlientoNaujienlaiskius($_POST['epastas'], 0); 
				$redaguotoId = $db -> getKlientasId($_POST['epastas']);
				$tipas = "";
				if($_SESSION['user']['fk_role_id']==1) {
					$tipas = "klientas_save";
				} else {
					$tipas = "darbuotojas_klienta";
				}
				$db -> insertRedagavimoIstorija($_SERVER['REMOTE_ADDR'], current($redaguotoId[0]), $_SESSION['user']['id'], $tipas);
			} else {
				$db -> redaguotiKlientoNaujienlaiskius($_POST['epastas'], 1); 
				$redaguotoId = $db -> getKlientasId($_POST['epastas']);
				$tipas = "";
				if($_SESSION['user']['fk_role_id']==1) {
					$tipas = "klientas_save";
				} else {
					$tipas = "darbuotojas_klienta";
				}
				$db -> insertRedagavimoIstorija($_SERVER['REMOTE_ADDR'], current($redaguotoId[0]), $_SESSION['user']['id'], $tipas);
			}
			echo '
				<div class="col-md-8">
					<div class="alert alert-success">
						<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
					</div>
				</div>
			';
		}
	}	
	// Vykdomas slaptazodzio keitimas
	if(isset($_POST['submitredSlap'])) {
		if($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['email']!=$_POST['epastas']) {
			header("Location: index.php?module=error");
			die();
		} else {
			//echo "OK";
			
			if(isset($_POST['slaptazodisKlientasRed']) && isset($_POST['slaptazodisKlientasRed2']) && 
				$_POST['slaptazodisKlientasRed'] != $_POST['slaptazodisKlientasRed2']) {
				echo '
					<div class="col-md-8">
						<div class="alert alert-danger">
							<strong>Klaida.</strong> Slaptažodžiai turi sutapti. <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal.</a>
						</div>
					</div>
				';
			} else if((isset($_POST['slaptazodisKlientasRed']) && strlen($_POST['slaptazodisKlientasRed'])<6) || (isset($_POST['slaptazodisKlientasRed2']) && strlen($_POST['slaptazodisKlientasRed2'])<6)) {
				echo '
					<div class="col-md-8">
						<div class="alert alert-danger">
							<strong>Klaida.</strong> Slaptažodis turi būti bent 6 simbolių ilgio. <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal.</a>
						</div>
					</div>
				';
			} else {
				// Patikrinti ar senas galioja 
				$result = $db -> checkUserLogin($_POST['epastas'],md5($_POST['slaptazodisKlientasRedOld']));
				if(!isset($result)) {
					echo '
					<div class="col-md-8">
						<div class="alert alert-danger">
							<strong>Klaida.</strong> Senas slaptažodis neteisingas. <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal.</a>
						</div>
					</div>
				';
				} else {
					$db -> redaguotiKlientoSlaptazodi($_POST['epastas'],md5($_POST['slaptazodisKlientasRed']));
					$redaguotoId = $db -> getKlientasId($_POST['epastas']);
					$tipas = "";
					if($_SESSION['user']['fk_role_id']==1) {
						$tipas = "klientas_save";
					} else {
						$tipas = "darbuotojas_klienta";
					}
					$db -> insertRedagavimoIstorija($_SERVER['REMOTE_ADDR'], current($redaguotoId[0]), $_SESSION['user']['id'], $tipas);
					echo '
						<div class="col-md-8">
							<div class="alert alert-success">
								<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
							</div>
						</div>
					';
				}
			}
			
		}
	}
	// Vykdomas Darbuotojo pasto keitimas
	if(isset($_POST['emailDarbuotojasRed'])) {
		if($_SESSION['user']['fk_role_id']==1 || ($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['kodas']!=$_POST['kodas']) ) {
			header("Location: index.php?module=error");
			die();
		} else {
			$yraEmail = $db -> checkForSameEmailDarbuotojas($_POST['emailDarbuotojasRed']);
			if(count($yraEmail)!=0) {
				echo '
					<div class="col-md-8">
						<div class="alert alert-danger">
							<strong>Klaida.</strong> Elektroninis paštas jau yra registruotas. <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal.</a>
						</div>
					</div>
				';
			} else {
				$db -> redaguotiDarbuotojoEmail($_POST['kodas'], $_POST['emailDarbuotojasRed']);
				$redaguotoId = $db -> getDarbuotojasId($_POST['kodas']);
				$db -> insertRedagavimoIstorija($_SERVER['REMOTE_ADDR'], current($redaguotoId[0]), $_SESSION['user']['id'], "darbuotojas_darbuotoja");
				echo '
					<div class="col-md-8">
						<div class="alert alert-success">
							<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
						</div>
					</div>
				';
			}
		}
	}
	// Vykdomas Darbuotojo slaptazodzio keitimas
	if(isset($_POST['submitredSlapDarbuotojas'])) {
		if($_SESSION['user']['fk_role_id']==1 || ($_SESSION['user']['fk_role_id']==1 && $_SESSION['user']['kodas']!=$_POST['kodas']) ) {
			header("Location: index.php?module=error");
			die();
		} else {			
			if(isset($_POST['slaptazodisDarbuotojasRed']) && isset($_POST['slaptazodisDarbuotojasRed2']) && 
				$_POST['slaptazodisDarbuotojasRed'] != $_POST['slaptazodisDarbuotojasRed2']) {
				echo '
					<div class="col-md-8">
						<div class="alert alert-danger">
							<strong>Klaida.</strong> Slaptažodžiai turi sutapti. <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal.</a>
						</div>
					</div>
				';
			} else if((isset($_POST['slaptazodisDarbuotojasRed']) && strlen($_POST['slaptazodisDarbuotojasRed'])<6) || (isset($_POST['slaptazodisDarbuotojasRed2']) && strlen($_POST['slaptazodisDarbuotojasRed2'])<6)) {
				echo '
					<div class="col-md-8">
						<div class="alert alert-danger">
							<strong>Klaida.</strong> Slaptažodis turi būti bent 6 simbolių ilgio. <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal.</a>
						</div>
					</div>
				';
			} else {
				// Patikrinti ar senas galioja 
				$result = $db -> checkDarbuotojasLogin($_POST['epastas'],md5($_POST['slaptazodisDarbuotojasRedOld']));
				if(!isset($result)) {
					echo '
					<div class="col-md-8">
						<div class="alert alert-danger">
							<strong>Klaida.</strong> Senas slaptažodis neteisingas. <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal.</a>
						</div>
					</div>
				';
				} else {
					$db -> redaguotiDarbuotojoSlaptazodi($_POST['kodas'],md5($_POST['slaptazodisDarbuotojasRed']));
					$redaguotoId = $db -> getDarbuotojasId($_POST['kodas']);
					$db -> insertRedagavimoIstorija($_SERVER['REMOTE_ADDR'], current($redaguotoId[0]), $_SESSION['user']['id'], "darbuotojas_darbuotoja");
					echo '
						<div class="col-md-8">
							<div class="alert alert-success">
								<strong>Veiksmas atliktas</strong> <a href="index.php?module=profiliu_perziura" class="alert-link"> Grįžti atgal</a>
							</div>
						</div>
					';
				}
			}
			
		}
	}
?>