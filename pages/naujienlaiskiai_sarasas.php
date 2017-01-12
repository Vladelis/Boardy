
	<?php
		include 'classes/naujienlaiskis.class.php';
		$newslettersObj = new newsletters();
		if (empty($_SESSION['user']) || $_SESSION['user']['fk_role_id']==1 )
		{
				header("Location: index.php?module=noaccess");
				die();
		}
		
		if(!empty($removeNewsletterId)) {
			$newslettersObj->deleteNewsletter($removeNewsletterId);
			header("Location: index.php?module={$module}");
			die();
		}
		
		if(!empty($sendNewsletterId)) {
			$newslettersObj->sendNewsletter($sendNewsletterId);
			header("Location: index.php?module={$module}");
			die();
		}
	?>

		<div class="col-md-12" >
			<legend style="padding-top:20px">Naujienlaiškiai</legend>
			<div class="col-md-12" style="padding-bottom:15px">
			
			
				<a class="btn btn-primary" href="index.php?module=naujienlaiskis_redagavimas">Naujas naujienlaiškis </a>
			</div>
			<div style="display: table;">
				<?php
							$data = $newslettersObj -> getNewsletters();
								foreach($data as $key => $val) {
									echo "<div class='col-sm-4 newsletterItem' style='display: table-cell;'> <div class='newsletter-options'>";
									if ($val['ar_issiustas']==0) {
										echo"<a class='btn btn-xs btn-success' href='#' onclick='showNewsletterSendConfirm(\"{$module}\", \"{$val['id']}\"); return false;'>Siusti</a>";
										echo"<a class='btn btn-xs btn-info' href='index.php?module=naujienlaiskis_redagavimas&id={$val['id']}'>Redaguoti</a>";
									}
									else {
										echo"<a class='btn btn-xs btn-info' href='index.php?module=naujienlaiskis_redagavimas&id={$val['id']}'>Peržiūrėti</a>";
									}
									echo"<a class='btn btn-xs btn-danger' href='#' onclick='showNewsletterDeleteConfirm(\"{$module}\", \"{$val['id']}\"); return false;'>Šalinti</a>";
									echo"</div> <div class='offerIcon";
									if ($val['ar_issiustas'] == 0)
										echo " unsentMail'>";
									else 
										echo " sentMail'>";
									echo "<span class=' glyphicon glyphicon-envelope' style='padding-top:20px'></span></div>";
									echo "<div><h4>{$val['antraste']}</h4><p><i>{$val['apibudinimas']}</i></p></div>";
									echo "</div>";
								}							
			?>
			</div>
			
			
		</div>

	

