
	
		<?php
		include 'classes/bylos.class.php';
		$casesObj = new cases();
		if (empty($_SESSION['user']) || $_SESSION['user']['fk_role_id']==1 )
		{
				header("Location: index.php?module=noaccess");
				die();
		}
		
		if(!empty($openCaseId)) {
			$data = array (
				'order' => $openCaseId,
				'name' => 'test'
			);
			$casesObj -> openCase($data);
			header("Location: index.php?module=bylos_sarasas");
			die();
		}
	?>

	
		<div class="col-md-12">
			<legend style="padding-top:20px">Bylos</legend>
			
			<table class="table table-striped table-hover ">
  
			
			  <thead>
				<tr>
				  <th>Byla</th>
				  <th>Komentaras</th>
				  <th>Būsena</th>
				  <th></th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
							$bylos = $casesObj -> getCases();
								foreach($bylos as $key => $val) {
									echo "<tr";
									if ($val['Busena'] == "Susisiekti nepavyko")
										echo " class='warning' ";
									if ($val['Busena'] == "Susisiekti pavyko - grąžins")
										echo " class='info' ";
									if ($val['Busena'] == "Išspręsta")
										echo " class='success' ";
									if ($val['Busena'] == "Perduota policijai")
										echo " class='danger' ";
									echo ">
											<td>{$val['Pavadinimas']}</td>
											<td>{$val['Komentaras']}</td>
											<td>{$val['Busena']}</td>
											<td><a href='index.php?module=byla_redagavimas&id={$val['id']}' class='btn btn-default btn-xs'>Redaguoti</a></td>
										</tr>";
								}							
			?>
			  </tbody>
			</table> 
		</div>



		