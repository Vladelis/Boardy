<?php

	class newsletters {
		
		public function __construct() {
		}
		
		public function getRepairsList() {
			$query = "  SELECT remontai.Kodas, itaisai.Pavadinimas AS Itaisas, klientai.Vardas, klientai.Pavarde, busenos.Busena, remontai.Komentaras, remontai.Id AS Id
						FROM itaisai, klientai, remontai, busenos
						WHERE remontai.Irenginys = itaisai.id AND 
						klientai.id = remontai.Klientas AND 
						remontai.Busena = busenos.id";
			$data = mysql::select($query);
			return $data;
		}
		
	}

?>