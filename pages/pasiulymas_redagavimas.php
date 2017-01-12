
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
				'discount' => $_POST['nuolaida']
			);
			$offersObj -> createOffer($data);
			
			$lastId = getLastId();
			
			foreach ($games as &$value) {
				$offersObj -> addGameIds($lastId,$value);
			}
			
			header("Location: index.php?module=pasiulymai_sarasas");
			die();
		}
		
		if(isset($_POST['submitUpdateOffer'])) {
			$games = json_decode($_REQUEST['contents']);

			
			$data = array (
				'name' => $_POST['name'],
				'tipe' => 0,
				'comment' => $_POST['comment'],
				'count' => sizeof($games),
				'discount' => $_POST['nuolaida'],
				'id' => $id
			);
			$offersObj -> updateOffer($data);
			$offersObj->removeOffer($id);
			
			foreach ($games as &$value) {
				$offersObj -> addGameIds($id,$value);
			}
			
			header("Location: index.php?module=pasiulymai_sarasas");
			die();
		}
		
			function getLastId() {
			$connection = mysql::connect();
			return $connection->insert_id;
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
			
				<div class="form-group" id="discountItem">
					<label>Nuolaidos dydis (%)</label>
					<input class="form-control" type="number" placeholder="Nuolaida" name="nuolaida" value="<?php echo $offer['nuolaidos_dydis'] ?>"/>
				</div>
				<div class="form-group">
					<label>Komentaras</label>
					<textarea class="form-control" rows="3" placeholder="Komentaras" name="comment" style="resize:none"><?php echo $offer['komentaras'] ?></textarea>
				</div>
				<div id="BoardGameList">
					<?php
						$selectGames = $offersObj -> getGamesById($id);
						foreach($selectGames   as $key => $val) {
									echo "<div class='panel panel-default'><div class='panel-body'><strong class='aad'>{$val['pavadinimas']}</strong><button class='btn btn-danger btn-xs itembutton' type='button' style='float:right'>Pašalinti<span class='itemm' style='display:none'>{$val['id']}</span><span class='itemmm' style='display:none'>{$val['pavadinimas']}</span></button></div></div>"; 
							}
					?>
					
				</div>
				<div class="form-group">
						<label >Stalo žaidimai</label> <button class="btn btn-primary btn-sm " id="gameAddButton" style="margin:10px" type="button">Pridėti žaidimą</button>
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
				<a href="index.php?module=pasiulymai_sarasas" class="btn btn-default"> Grįžti </a>
				<?php 
					if (!empty($offer['id']))
						echo "<input class='btn btn-primary' type='submit' name='submitUpdateOffer' value='Atnaujinti' onclick='addData()'/>";
					else
						echo "<input class='btn btn-primary' type='submit' name='submitCreateOffer' value='Sukurti' onclick='addData()'/>";
				?>
				
			</form>
		</div>
		
		<script>
			var boardgames = [];
			<?php
				foreach($selectGames   as $key => $val) {
					echo "boardgames.push('{$val['id']}');";
				}
			?>
			
			$('#gameAddButton').on( 'click', function() {
				if ($("#zaidimai").val() != -1) {
					$("#BoardGameList").append("<div class='panel panel-default'><div class='panel-body'><strong class='aad'>" + $("#zaidimai :selected").text() + "</strong><button class='btn btn-danger btn-xs itembutton' type='button' style='float:right'>Pašalinti<span class='itemm' style='display:none'>"+$('#zaidimai').val()+"</span><span class='itemmm' style='display:none'>"+$("#zaidimai :selected").text()+"</span></button></div></div>");
					boardgames.push($("#zaidimai").val());
					$('#zaidimai option[value="' + $("#zaidimai").val()+ '"]').remove();
				}
				console.log(boardgames);
			});
			
			$('#BoardGameList').on('click', '.itembutton', function() {
				boardgames.splice(boardgames.indexOf($(this).find(".itemm").text()), 1);
				$("#zaidimai").append("<option value='"+$(this).find('.itemm').text()+"' >"+$(this).find('.itemmm').text()+"</option>");
				$(this).parent().parent().remove();
				console.log(boardgames);
			});
			
			
			function addData() {
				var x= JSON.stringify(boardgames);
				$("#Contents").val(x);
				alert(("#zaidimai").val());
			}
		</script>