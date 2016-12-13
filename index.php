<?php
	// nuskaitome konfigūracijų failą
	session_start();
	include 'config.php';
	include 'utils/mysql.class.php';
	
	
	// iškviečiame prisijungimo prie duomenų bazės klasę
	$module = 'home';
	if(isset($_GET['module'])) {
		$module = mysql::escape($_GET['module']);
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
				  <a class="navbar-brand" href="index.php?module=home">Boardy</a>
				</div>

				<div class="collapse navbar-collapse">
				  <ul class="nav navbar-nav">
					<li><a href='index.php?module=item1'>Item1</a></li>
					<li><a href='index.php?module=item2'>Item2</a></li>
                                        <li><a href='index.php?module=stalo_zaidimu_perziura'>Stalo žaidimai</a></li>
                                        
										<?php
											if(!empty($_SESSION['user'])) {
												if($_SESSION['user']['fk_role_id']==2 || $_SESSION['user']['fk_role_id']==3) {
													echo '
                                                                                                                <li><a href="index.php?module=stalo_zaidimu_registracija">Naujas stalo žaidimas</a></li>
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
											}
								?>
					<li><a href='https://bootswatch.com/journal/'>Nuoroda į temą</a></li>
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