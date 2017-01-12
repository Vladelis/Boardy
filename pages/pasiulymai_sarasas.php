<?php
		include 'classes/pasiulymas.class.php';
		$offersObj = new offers();
		if (empty($_SESSION['user']) || $_SESSION['user']['fk_role_id']==1 )
		{
				header("Location: index.php?module=noaccess");
				die();
		}
		
		if(!empty($removeOfferId)) {
			$offersObj->deleteOffer($removeOfferId);
			$offersObj->removeOffer($activateOfferId);
			header("Location: index.php?module={$module}");
			die();
		}
		
		if(!empty($activateOfferId)) {
			$offersObj->activateOffer($activateOfferId);
			header("Location: index.php?module={$module}");
			die();
		}
		
		if(!empty($deactivateOfferId)) {
			$offersObj->deactivateOffer($deactivateOfferId);
			header("Location: index.php?module={$module}");
			die();
		}
	?>

		<div class="col-md-12">
			<legend style="padding-top:20px">Specialūs pasiūlymai</legend>
			<div class="col-md-12" style="padding-bottom:15px">
				<a class="btn btn-primary" href="index.php?module=pasiulymas_redagavimas">Naujas pasiulymas</a>
			</div>
			<?php
							$data = $offersObj -> getOffers();
								foreach($data as $key => $val) {
									echo "<div class='col-sm-4 offerItem'> <div class='offerItem-options'>";
									if ($val['ar_galioja']==1) {
										echo"<a class='btn btn-xs btn-warning' href='#' onclick='showOfferDeactivateConfirm(\"{$module}\", \"{$val['id']}\"); return false;'>Išjungti</a>";
									}
									else {
										echo"<a class='btn btn-xs btn-success' href='#' onclick='showOfferActivateConfirm(\"{$module}\", \"{$val['id']}\"); return false;'>Įjungti</a>";
										echo"<a class='btn btn-xs btn-info' href='index.php?module=pasiulymas_redagavimas&id={$val['id']}'>Redaguoti</a>";
										echo"<a class='btn btn-xs btn-danger' href='#' onclick='showOfferDeleteConfirm(\"{$module}\", \"{$val['id']}\"); return false;'>Šalinti</a>";
									}
									echo"</div> <div class='offerIcon";
									if ($val['ar_galioja'] == 1)
										echo " activeOffer'>";
									else 
										echo " inactiveOffer'>";
									echo "<span class=' glyphicon glyphicon-eur ' style='padding-top:20px'></span></div>";
									echo "<div><h4>{$val['Pavadinimas']}</h4><p><i>{$val['komentaras']}</i></p></div>";
									echo "</div>";
								}							
			?>
		</div>