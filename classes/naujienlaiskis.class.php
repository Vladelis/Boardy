<?php

	class newsletters {
		
		public function __construct() {
		}
		
		public function createNewsletter($data) {
			$query = "  INSERT INTO `Naujienlaiskis`
									(
										sukurimo_data,
										laisko_turinys,
										antraste,
										ar_issiustas,
										komentaras,
										kurejoId,
										laisko_trumpinys,
										apibudinimas
									)
									VALUES
									(
										'{$data['date']}',
										'{$data['content']}',
										'{$data['subject']}',
										'0',
										'{$data['comment']}',
										'{$data['user']}',
										'{$data['snippet']}',
										'{$data['description']}'
										
									)";
			mysql::query($query);
		}
		
		public function getNewsletters() {
			$query = "  SELECT *
						FROM Naujienlaiskis 
						ORDER BY ar_issiustas
						";
			$data = mysql::select($query);
			return $data;
		}
		
		public function getNewsletterById($id) {
			$query = "  SELECT *
						FROM Naujienlaiskis 
						ORDER BY ar_issiustas
						";
			$data = mysql::select($query);
			return $data;
		}
	}

?>