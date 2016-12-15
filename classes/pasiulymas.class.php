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
		
		public function deleteOffer($id) {
			$query = "  DELETE FROM `Specialus_pasiulymas`
						WHERE `id`='{$id}'";
			mysql::query($query);
		}
		
		public function removeOffer($id) {
			$query = "  UPDATE 	`Zaidimas`
						SET 	spec_pasiulymas = NULL
						WHERE	spec_pasiulymas = '{$id}'";
			mysql::query($query);
		}
		
		
		public function activateOffer($id) {
			$query = "  UPDATE 	`Specialus_pasiulymas`
						SET 	ar_galioja = '1'
						WHERE	id = '{$id}'";
			mysql::query($query);
		}
		
		public function updateOffer($data) {
			$query = "  UPDATE 	`Specialus_pasiulymas`
						SET 	tipas = '{$data['tipe']}',
								Pavadinimas = '{$data['name']}',
								komentaras = '{$data['comment']}',
								zaidimu_skaicius = '{$data['count']}',
								nuolaidos_dydis = '{$data['discount']}'
						WHERE	id = '{$data['id']}'";
			mysql::query($query);
		}
		
		public function deactivateOffer($id) {
			$query = "  UPDATE 	`Specialus_pasiulymas`
						SET 	ar_galioja = '0'
						WHERE	id = '{$id}'";
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
						ORDER BY ar_galioja DESC, Pavadinimas
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
		
		public function addGameIds($id, $value) {
			$query = "  UPDATE 	`Zaidimas`
						SET 	spec_pasiulymas = '{$id}'
						WHERE	id = '{$value}'";
			mysql::query($query);
		}
		
		public function getGamesById($id) {
			$query = "  SELECT *
						FROM Zaidimas
						WHERE spec_pasiulymas = '{$id}'
						ORDER BY pavadinimas
						";
			$data = mysql::select($query);
			return $data;
		}
		
		
		
	}

?>