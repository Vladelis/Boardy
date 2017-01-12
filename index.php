<?php
	// nuskaitome konfigūracijų failą
	session_start();
	include 'config.php';
	include 'utils/mysql.class.php';
	
	
	// iškviečiame prisijungimo prie duomenų bazės klasę
	$module = 'naujienos';
	if(isset($_GET['module'])) {
		$module = mysql::escape($_GET['module']);
	}
	
	$id = '';
	if(isset($_GET['id'])) {
		$id = mysql::escape($_GET['id']);
	}
	
	$removeNewsletterId = 0;
	if(!empty($_GET['removeNewsletter'])) {
		$removeNewsletterId = mysql::escape($_GET['removeNewsletter']);
	}
	$openCaseId = 0;
	if(!empty($_GET['openCase'])) {
		$openCaseId = mysql::escape($_GET['openCase']);
	}
	
	$sendNewsletterId = 0;
	if(!empty($_GET['sendNewsletter'])) {
		$sendNewsletterId = mysql::escape($_GET['sendNewsletter']);
	}
	
	$removeOfferId = 0;
	if(!empty($_GET['removeOffer'])) {
		$removeOfferId = mysql::escape($_GET['removeOffer']);
	}
	
	$activateOfferId = 0;
	if(!empty($_GET['activateOffer'])) {
		$activateOfferId = mysql::escape($_GET['activateOffer']);
	}
	
	$deactivateOfferId = 0;
	if(!empty($_GET['deactivateOffer'])) {
		$deactivateOfferId = mysql::escape($_GET['deactivateOffer']);
	}
	
	// Atsijungiame
	if(isset($_POST['atsijungimas']) && !empty($_SESSION['user'])) {
		session_unset();
		header("Location: index.php");
		die();
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="robots" content="noindex">
		<title>Boardy</title>
		<script src="scripts/jquery-1.10.2.min.js"></script>
		<script src="scripts/bootstrap.min.js"></script>
		<script src="scripts/sitescripts.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="styles/site.css">
		<link rel="stylesheet" type="text/css" href="styles/naujienlaiskiai.css">
		<link rel="stylesheet" type="text/css" href="styles/pasiulymai.css">
	</head>
	<body>

		<nav class="navbar navbar-inverse navbar-fixed-top container">
			<div class="container-fluid">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="index.php?module=naujienos">Boardy</a>
				</div>

				<div class="collapse navbar-collapse">
				  <ul class="nav navbar-nav">
                     <li><a href='index.php?module=stalo_zaidimu_perziura'>Stalo žaidimai</a></li>
										<?php
											if(!empty($_SESSION['user'])) {
												if($_SESSION['user']['fk_role_id']==2 || $_SESSION['user']['fk_role_id']==3) {
													echo '
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Valdymo panelė<span class="caret"></span></a>
															<ul class="dropdown-menu" role="menu">
																<li><a href="index.php?module=stalo_zaidimu_registracija">Naujas stalo žaidimas</a></li>
																<li><a href="index.php?module=naujienlaiskiai_sarasas">Naujienlaiškiai</a></li>
																<li><a href="index.php?module=pasiulymai_sarasas">Specialūs pasiūlymai</a></li>
																<li><a href="index.php?module=bylos_sarasas">Bylos</a></li>
															</ul>
														</li>
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Profilų kūrimas<span class="caret"></span></a>
															<ul class="dropdown-menu" role="menu">
																<li><a href="index.php?module=kliento_profilio_kurimas">Registruoti vartotoją</a></li>
														
													';		
													// Cia ideti patikrinima tik vadybininkui
													if($_SESSION['user']['fk_role_id']==3) {
														echo'
																<li><a href="index.php?module=darbuotojo_profilio_kurimas">Registruoti darbuotoją</a></li>
																<li><a href="index.php?module=vadybininko_profilio_kurimas">Registruoti vadybininką</a></li>
														';
													}
													echo'
															</ul>
														</li>
														
													';
												}
												//Biuro valdymu meniu vadybininkams
												if($_SESSION['user']['fk_role_id']==3)
												{
													echo'
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Biurų valdymas<span class="caret"></span></a>
															<ul class="dropdown-menu" role="menu">
																<li><a href="index.php?module=biuro_kurimas">Naujo biuro kūrimas</a></li>
																<li><a href="index.php?module=biuro_redagavimas">Biuro redagavimas</a></li>
																<li><a href="index.php?module=biuro_trynimas">Biuro trynimas</a></li>
															</ul>
														</li>
													';
												}
												if($_SESSION['user']['fk_role_id']==3 || $_SESSION['user']['fk_role_id']==2)
												{
                                                                                                    echo'<li><a href="index.php?module=visi_uzsakymai">Visi užsakymai</a></li>';
                                                                                                    //echo'<li><a href="index.php?module=mano_uzsakymai">Mano užsakymai</a></li>';
                                                                                                    /*
                                                                                                    echo'
                                                                                                        <li class="dropdown">
                                                                                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Užsakymai<span class="caret"></span></a>
                                                                                                                <ul class="dropdown-menu" role="menu">
                                                                                                                        <li><a href="index.php?module=mano_uzsakymai">Mano užsakymai</a></li>
                                                                                                                        <li><a href="index.php?module=visi_uzsakymai">Visi užsakymai</a></li>
                                                                                                                </ul>
                                                                                                        </li>
                                                                                                    ';
                                                                                                     */
												}
                                                                                                else
                                                                                                {
                                                                                                    echo'
                                                                                                        <li><a href="index.php?module=mano_uzsakymai">Mano užsakymai</a></li>
                                                                                                    ';
                                                                                                }
											}
								?>
				  </ul>
				  <ul class="nav navbar-nav navbar-right">
						<?php
							if(!empty($_SESSION['user'])) {
								// Sito font neatinka kitu, bet as nzn kaip kitaip padaryti atsijungima
								echo '	
									<li><a href="index.php?module=profiliu_perziura">Peržiurėti profilį</a></li>
									<li>
										<form class="form" method="post" action="">
											<input class="hidden" name="atsijungimas" value="atsijungimas">
											<input type="submit" name="submitAtsijungimas" value="Atsijungti" class="btn btn-primary btn-lg" />
										</form>
									</li>
								';
								
							} else {
								echo "
									<li><a href='index.php?module=login'>Prisijungti</a></li>
									<li><a href='index.php?module=kliento_profilio_kurimas'>Registruotis</a></li>
								";
							}
						?>
				  </ul>
				</div>
			</div>
		</nav>
		<div class="container contentMain">
		<?php
			include "pages/{$module}.php";
		?>
		<div id="footer" class="col-md-12">
			<hr>
			<p>2016 Stalo žaidimų nuomos informacinė sistema. </p>
		</div>
		</div>
		
	
	</body>
</html>