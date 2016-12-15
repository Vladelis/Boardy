
		<?php
		include 'classes/pasiulymas.class.php';
	
		$offersObj = new offers();
		
		if (empty($_SESSION['user']) || $_SESSION['user']['fk_role_id']==1 )
		{
				header("Location: index.php?module=noaccess");
				die();
		}
		
		$offer = $offersObj -> getOfferById($id);
		
		if(isset($_POST['submitCreateOffer'])) {
			$games = json_decode($_REQUEST['contents']);
			$type=$_POST['tipas'];

			
			$data = array (
				'name' => $_POST['name'],
				'tipe' => $type,
				'comment' => $_POST['comment'],
				'date' => date("Y-m-d"),
				'count' => sizeof($games),
				'user' => $_SESSION['user']['id'],
				'discount' => $nuolaida
			);
			$offersObj -> createOffer($data);
			echo ("<script>alert({$type});</script>");
			header("Location: index.php?module=pasiulymai_sarasas");
			die();
		}
		
	?>
	

		<div class="col-md-12">
			<legend style="padding-top:20px">Specialaus pasiūlymo kūrimas</legend>
			<form action="" method="post">
				<input name="contents" id="Contents"  type="hidden"/>
				<div class="form-group">
					<label>Pavadinimas</label>
					<input class="form-control" placeholder="Pavadinimas" name="name" value="<?php echo $offer['Pavadinimas'] ?>" required />
				</div>
				<div class="form-group">
						<label >Tipas</label>
						<select name="tipas" class="form-control" onchange="toggleDiscount(this)" required>
							<option value="">---------------</option>
							<?php
								$data = $offersObj->getTypesList();
								foreach($data as $key => $val) {
									echo "<option value='{$val['id']}'"; 
									if ($offer['tipas'] == $val['id'])
										echo " selected ";
									echo ">{$val['tipas']} </option>";
								}
							?>
						</select>
					</div>
				<div class="form-group" id="discountItem" style="display:none">
					<label>Nuolaidos dydis (%)</label>
					<input class="form-control" type="number" placeholder="Nuolaida" name="nuolaida" value="<?php echo $offer['nuolaidos_dydis'] ?>"/>
				</div>
				<div class="form-group">
					<label>Komentaras</label>
					<textarea class="form-control" rows="3" placeholder="Komentaras" name="comment" style="resize:none"><?php echo $offer['komentaras'] ?></textarea>
				</div>
				<div id="BoardGameList">
					
					
				</div>
				<div class="form-group">
						<label >Stalo žaidimai</label> <button class="btn btn-primary btn-sm" style="margin:10px" onclick="addGame()" type="button">Pridėti žaidimą</button>
						<select name="game" class="form-control" id="zaidimai" value="<?php echo $repair['Klientas'] ?>">
							<option value="-1">---------------</option>
							<?php
								$data = $offersObj->getBoardgames();
								foreach($data as $key => $val) {
									echo "<option value='{$val['id']}'"; 
									if (false)
										echo " selected ";
									echo ">{$val['pavadinimas']}</option>";
								}
							?>
						</select>
					</div>
				<a href="index.php?module=naujienlaiskiai_sarasas" class="btn btn-default"> Grįžti </a>
				<?php 
					if (!empty($newsletter['id']))
						echo "<input class='btn btn-primary' type='submit' name='submitUpdateOffer' value='Atnaujinti' onclick='addData()'/>";
					else
						echo "<input class='btn btn-primary' type='submit' name='submitCreateOffer' value='Sukurti' onclick='addData()'/>";
				?>
				
			</form>
		</div>
		
		<script>
			function toggleDiscount(item) {
				if (item.value == 1) 
					$("#discountItem").show();
				else
					$("#discountItem").hide();
			}
			
			var boardgames = [];
			function addGame() {
				if ($("#zaidimai").val() != -1) {
					$("#BoardGameList").append("<div class='panel panel-default'><div class='panel-body'><strong>" + $("#zaidimai :selected").text() + "<button class='btn btn-danger btn-xs' type='button' style='float:right'>Pašalinti</button></strong></div></div>");
					boardgames.push($("#zaidimai").val());
				}
			}
			
			function addData() {
				var x= JSON.stringify(boardgames);
				$("#Contents").val(x);
				alert(("#zaidimai").val());
			}
		</script>