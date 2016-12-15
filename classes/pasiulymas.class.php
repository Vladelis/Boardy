<?php

	class offers {
		
		public function __construct() {
		}
		
		public function createOffer($data) {
			$query = "  INSERT INTO `Specialus_pasiulymas`
									(
										sukurimo_data,
										tipas,
										nuolaidos_dydis,
										zaidimu_skaicius,
										galioja_iki,
										komentaras,
										kurejas,
										ar_galioja,
										Pavadinimas
									)
									VALUES
									(
										'{$data['date']}',
										'{$data['tipe']}',
										'{$data['discount']}',
										'{$data['count']}',
										'{$data['date']}',
										'{$data['comment']}',
										'{$data['user']}',
										'0',
										'{$data['name']}'
										
									)";
			mysql::query($query);
		}
		public function updateNewsletter($data) {
			$query = "  UPDATE 	`Naujienlaiskis`
						SET 	turinys = '{$data['content']}',
								antraste = '{$data['subject']}',
								komentaras = '{$data['comment']}',
								laisko_trumpinys = '{$data['snippet']}',
								apibudinimas = '{$data['description']}'
						WHERE	id = '{$data['id']}'";
						
			mysql::query($query);
		}
	
		public function getOfferById($id) {
			$query = "  SELECT *
						FROM Specialus_pasiulymas
						WHERE id = '{$id}'
						";
			$data = mysql::select($query);
			if (count($data)==0)
				return null;
			else
				return $data[0];
		}
		
		public function deleteNewsletter($id) {
			$query = "  DELETE FROM `Naujienlaiskis`
						WHERE `id`='{$id}'";
			mysql::query($query);
		}
		
		
		public function getTypesList() {
			$query = "  SELECT *
						FROM Pasiulymo_tipas
						ORDER BY tipas
						";
			$data = mysql::select($query);
			return $data;
		}
		
		public function getOffers() {
			$query = "  SELECT *
						FROM Specialus_pasiulymas
						ORDER BY ar_galioja, Pavadinimas
						";
			$data = mysql::select($query);
			return $data;
		}
		
		public function getBoardgames() {
			$query = "  SELECT *
						FROM Zaidimas
						WHERE spec_pasiulymas IS NULL
						ORDER BY pavadinimas
						";
			$data = mysql::select($query);
			return $data;
		}
		
		
		
	}

?>