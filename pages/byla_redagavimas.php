

		<?php
		include 'classes/bylos.class.php';
		$casesObj = new cases();
		if (empty($_SESSION['user']) || $_SESSION['user']['fk_role_id']==1 )
		{
				header("Location: index.php?module=noaccess");
				die();
		}
		
		$case = $casesObj -> getCasesId($id);
		if(isset($_POST['submitUpdateCase'])) {
	
			$data = array (
				'status' => $_POST['busena'],
				'comment' => $_POST['comment'],
				'id' => $id
			);
			$casesObj -> updateCase($data);
			header("Location: index.php?module=bylos_sarasas");
			die();
		}
		
		
	?>

		<div class="col-md-12">
			<legend style="padding-top:20px">Bylos <strong> <?php echo $case['Pavadinimas']?> </strong> redagavimas</legend>
			<form action="" method="post">
				<div class="col-md-6">
					<div class="row"><h4 style="margin:0">Užsakymo duomenys</h4></div>
					<hr>
					<div class="col-md-6">
						<div class="row"><strong>Byla:</strong></div>
						<div class="row"><strong>Užsakymo data:</strong></div>
						<div class="row"><strong>Busena:</strong></div>
					</div>
					<div class="col-md-6">
						<div class="row"><?php echo $case['Pavadinimas'] ?></div>
						<div class="row"><?php echo $case['Data'] ?></div>
						<div class="row"><?php echo $case['Busena']?></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row"><h4 style="margin:0">Užsakovo duomenys</h4></div>
					<hr>
					<div class="col-md-6">
						<div class="row"><strong>Vartotojas:</strong></div>
						<div class="row"><strong>El. Paštas:</strong></div>
						<div class="row"><strong>Registracijos data:</strong></div>
					</div>
					<div class="col-md-6">
						<div class="row"><?php echo $case['Vardas']?></div>
						<div class="row"><?php echo $case['Email'] ?></div>
						<div class="row"><?php echo $case['KlientoReg'] ?></div>
					</div>
				</div>
				
				<div class="col-md-12">
					<hr>
					<div class="form-group">
						<h3>Busena</h3>
						<select name="busena" class="form-control" id="zaidimai" value="<?php echo $case['BusenaId'] ?>">
							<?php
								$data = $casesObj->getTypes();
								foreach($data as $key => $val) {
									echo "<option value='{$val['id']}'"; 
									if ($val['id'] == $case['BusenaId'])
										echo " selected ";
									echo ">{$val['busena']}</option>";
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<h3>Komentaras</h3>
						<textarea class="form-control" rows="3" placeholder="Komentaras" name="comment" style="resize:none"><?php echo $case['Komentaras'] ?></textarea>
					</div>
					<a href="index.php?module=bylos_sarasas" class="btn btn-default"> Grįžti </a>
					<input class='btn btn-primary' type='submit' name='submitUpdateCase' value='Išsaugoti'/>
				</div>
			</form>
		</div>