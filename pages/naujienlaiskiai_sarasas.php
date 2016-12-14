
	<?php
		include 'classes/naujienlaiskis.class.php';
		$newslettersObj = new newsletters();
	?>

		<div class="col-md-12">
			<legend style="padding-top:20px">Naujienlaiškiai</legend>
			<div class="col-md-12" style="padding-bottom:15px">
			
			
				<a class="btn btn-primary" href="index.php?module=naujienlaiskis_redagavimas">Naujas naujienlaiškis </a>
			</div>
			<?php
							$data = $newslettersObj -> getNewsletters();
								foreach($data as $key => $val) {
									echo "<div class='col-sm-4 newsletterItem'> <div class='newsletter-options'>";
									if ($val['ar_issiustas']==0) {
										echo"<a class='btn btn-xs btn-success' href='index.php?module=naujienlaiskis_redagavimas'&id={$val['id']}' class=:>Siusti</a>";
										echo"<a class='btn btn-xs btn-info' href='index.php?module=naujienlaiskis_redagavimas'&id={$val['id']}' class=:>Redaguoti</a>";
									}
									echo"<a class='btn btn-xs btn-danger' href='index.php?module=naujienlaiskis_redagavimas'&id={$val['id']}' class=:>Šalinti</a>";
									echo"</div> <div class='mailIcon";
									if ($val['ar_issiustas'] == 0)
										echo " unsentMail'>";
									else 
										echo " sentMail'>";
									echo "<span class=' glyphicon glyphicon-envelope' style='padding-top:20px'></span></div>";
									echo "<div><h4>{$val['antraste']}</h4><p><i>{$val['laisko_trumpinys']}</i></p></div>";
									echo "</div>";
								}							
			?>
		</div>

	

