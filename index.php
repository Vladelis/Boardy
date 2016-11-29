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
					<li><a href='https://bootswatch.com/journal/'>Nuoroda į temą</a></li>
				  </ul>
				  <ul class="nav navbar-nav navbar-right">
						<li><a href='index.php?module=login'>Prisijungti</a></li>
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