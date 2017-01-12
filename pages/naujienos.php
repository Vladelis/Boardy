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

		<div class="col-md-12">
			<legend style="padding-top:20px">Naujienos</legend>
			<?php
				$data = $newslettersObj -> getNewslettersForDisplay();
								foreach($data as $key => $val) {
									if ($val['ar_issiustas'] == 1) {
										echo "
											<div class='newsletteritem'>
												<h3><a href='index.php?module=naujienlaiskiai_perziura&id={$val['id']}'>{$val['antraste']}</a></h3> 
													<span class='itallicGray'>{$val['issiuntimo_data']}</span>
												  <p>
													{$val['laisko_trumpinys']}
												  </p>
											</div>";
									}
								}
			?>
			
		</div>