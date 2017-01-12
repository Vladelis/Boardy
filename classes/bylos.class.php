<?php

	class cases {
		
		public function __construct() {
		}
		
		public function getCases() {
			$query = "  SELECT Byla.Pavadinimas as Pavadinimas, Bylos_tipas.busena as Busena, Byla.komentaras as Komentaras, Byla.id as id
						FROM Byla, Bylos_tipas
						WHERE Byla.busena = Bylos_tipas.id
						ORDER BY Busena
						";
			$data = mysql::select($query);
			return $data;
		}
		
		public function getCasesId($id) {
			$query = "  SELECT Byla.Pavadinimas as Pavadinimas, Bylos_tipas.busena as Busena, Byla.komentaras as Komentaras, Byla.id as id, Uzsakymas.data as Data, Klientas.vardas as Vardas, Klientas.email as Email, Klientas.sukurimo_data as KlientoReg, Bylos_tipas.id as BusenaId
						FROM Byla, Bylos_tipas, Uzsakymas, Klientas
						WHERE Byla.busena = Bylos_tipas.id AND
							  Byla.uzsakymas_id = Uzsakymas.id AND
							  Uzsakymas.klientas_id = Klientas.id AND
						      Byla.id = '{$id}'
						";
			$data = mysql::select($query);
			return $data[0];
		}
		
		public function getTypes() {
			$query = "  SELECT *
						FROM Bylos_tipas
						ORDER BY busena
						";
			$data = mysql::select($query);
			return $data;
		}

		
		public function updateCase($data) {
			$query = "  UPDATE 	`Byla`
						SET 	busena = '{$data['status']}',
								komentaras = '{$data['comment']}'
						WHERE	id = '{$data['id']}'";
			mysql::query($query);
		}
		
		public function openCase($data) {
			$date = date("Y-m-d");
			
			$query = "  INSERT INTO `Byla`
									(
										uzsakymas_id,
										sukurimo_data,
										komentaras,
										busena,
										ar_pavyko_susisiekti,
										Pavadinimas
									)
									VALUES
									(
										'{$data['order']}',
										'{$date}',
										' ',
										'1',
										'0',
										'Byla atidaryta {$date}'
									)";
			mysql::query($query);
			$query1 = "  UPDATE  `Uzsakymas`
						SET 	ar_yra_byla = '1'
						WHERE	id = '{$data['order']}'";
			mysql::query($query1);
		}
		
		
	}

?>