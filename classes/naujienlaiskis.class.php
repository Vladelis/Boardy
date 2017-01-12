<?php

	class newsletters {
		
		public function __construct() {
		}
		
		public function createNewsletter($data) {
			$query = "  INSERT INTO `Naujienlaiskis`
									(
										sukurimo_data,
										turinys,
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
		
		public function getNewsletters() {
			$query = "  SELECT *
						FROM Naujienlaiskis 
						ORDER BY ar_issiustas, antraste
						";
			$data = mysql::select($query);
			return $data;
		}
		
		public function getNewslettersForDisplay() {
			$query = "  SELECT *
						FROM Naujienlaiskis 
						WHERE ar_issiustas = 1
						ORDER BY issiuntimo_data DESC
						";
			$data = mysql::select($query);
			return $data;
		}
		
		public function getNewsletterById($id) {
			$query = "  SELECT *
						FROM Naujienlaiskis 
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
		
		public function sendNewsletter($id) {
			$data = date("Y-m-d");
			$query = "  UPDATE 	`Naujienlaiskis`
						SET issiuntimo_data = '{$data}',
							ar_issiustas = '1'
						WHERE `id`='{$id}'";
			mysql::query($query);
		}
		
		
	}

?>