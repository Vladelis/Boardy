<? php
	if(!empty($_SESSION['user'])) {
		if($_SESSION['user']['fk_role_id']!=2 && $_SESSION['user']['fk_role_id']!=3) {
			header("Location: index.php");
			die();
		}
	}
?>

<div class="col-md-12">
	<a class="btn btn-primary" href="index.php?module=profiliu_perziura">Atgal</a>
</div>