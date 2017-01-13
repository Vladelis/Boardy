<?php 
/**
 * Database wrapper for a MySQL with PHP tutorial
 * 
 * @copyright Eran Galperin
 * @license MIT License
 * @see http://www.binpress.com/tutorial/using-php-with-mysql-the-right-way/17
 */
class mysql {
    // The database connection
    protected static $connection;

	/**
     * Connect to the database
     * 
     * @return bool false on failure / mysqli MySQLi object instance on success
     */
    public static function connect() {
        // Try and connect to the database
		if(!isset(self::$connection)) {
            self::$connection = new mysqli(config::DB_SERVER, config::DB_USERNAME, config::DB_PASSWORD, config::DB_NAME);
			
			if(self::$connection !== false) {
				// try to set mysql connection character set to UTF-8
				if (!mysql::$connection->set_charset("utf8")) {
					printf("Error loading character set: %s\n", self::$connection->error);
				}
			} else {
				// Handle error - notify administrator, log to a file, show an error screen, etc.
				return false;
			}
        }
        return self::$connection;
    }
	
	function insertRedagavimoIstorija($ip, $redaguotoId, $redaguotojoId, $tipas) {
		$q = 
		"INSERT INTO  `boardy`.`Redagavimo_istorija` (
			`id` ,
			`data_laikas` ,
			`redaguotas_profilis` ,
			`kas_redagavo` ,
			`ip_adresas` ,
			`fk_tipas`
		)
		VALUES (
			NULL , CURTIME(),  '".$redaguotoId."',  '".$redaguotojoId."',  '".$ip."',  '".$tipas."'
		);";
		$result = self::query($q);
		return $result;
	}
	
	function deleteKlientas($email) {
		$q = "
		DELETE FROM `boardy`.`Klientas` WHERE  `Klientas`.`email` = '".$email."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function deleteDarbuotojas($kodas) {
		$q = "
		DELETE FROM `boardy`.`Darbuotojas` WHERE  `Darbuotojas`.`kodas` = '".$kodas."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function updateUserLogin($ip, $email) {
		$q = 
		"UPDATE  `boardy`.`Klientas` 
		SET  
			`paskutinis_prisijungimas` =  CURTIME(),
			`paskutinis_ip` =  '".$ip."',
			apsilankymu_kiekis =  apsilankymu_kiekis + 1
		WHERE  `Klientas`.`email` = '".$email."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function updateDarbuotojasLogin($ip, $email) {
		$q = 
		"UPDATE  `boardy`.`Darbuotojas` 
		SET  
			`paskutinis_prisijungimas` =  CURTIME(),
			`paskutinis_ip` =  '".$ip."'
		WHERE  `Darbuotojas`.`email` = '".$email."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function getFullKlientasData($email) {
		$q = 
		"SELECT `Klientas`.`email`, `Klientas`.`slapyvardis`, `Klientas`.`vardas`, `Klientas`.`pavarde`, `Klientas`.`ar_nori_naujienlaiskio`
		FROM  `boardy`.`Klientas`
		WHERE  `email` = '".$email."'"
		;
		$result = self::select($q);
		return $result;
	}
	
	function getFullDarbuotojasData($kodas) {
		$q = 
		"SELECT `Darbuotojas`.`email`, `Darbuotojas`.`vardas`, `Darbuotojas`.`pavarde`, `Darbuotojas`.`kodas`
		FROM  `boardy`.`Darbuotojas`
		WHERE  `kodas` = '".$kodas."'"
		;
		$result = self::select($q);
		return $result;
	}
	
	function redaguotiKlientoVarda($email, $vardas) {
		$q = "
		UPDATE `boardy`.`Klientas` SET  `vardas` =  '".$vardas."' WHERE  `Klientas`.`email` = '".$email."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function redaguotiKlientoPavarde($email, $pavarde) {
		$q = "
		UPDATE `boardy`.`Klientas` SET  `pavarde` =  '".$pavarde."' WHERE  `Klientas`.`email` = '".$email."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function redaguotiKlientoSlapyvardi($email, $slapyvardis) {
		$q = "
		UPDATE `boardy`.`Klientas` SET  `slapyvardis` =  '".$slapyvardis."' WHERE  `Klientas`.`email` = '".$email."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function redaguotiKlientoNaujienlaiskius($email, $ar_nori_naujienlaiskio) {
		$q = "
		UPDATE `boardy`.`Klientas` SET  `ar_nori_naujienlaiskio` =  '".$ar_nori_naujienlaiskio."' WHERE  `Klientas`.`email` = '".$email."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function redaguotiKlientoSlaptazodi($email, $slaptazodis) {
		$q = "
		UPDATE `boardy`.`Klientas` SET  `slaptazodis` =  '".$slaptazodis."' WHERE  `Klientas`.`email` = '".$email."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function redaguotiDarbuotojoSlaptazodi($kodas, $slaptazodis) {
		$q = "
		UPDATE `boardy`.`Darbuotojas` SET  `slaptazodis` =  '".$slaptazodis."' WHERE  `Darbuotojas`.`kodas` = '".$kodas."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function redaguotiDarbuotojoEmail($kodas, $email) {
		$q = "
		UPDATE `boardy`.`Darbuotojas` SET  `email` =  '".$email."' WHERE  `Darbuotojas`.`kodas` = '".$kodas."';
		";
		$result = self::query($q);
		return $result;
	}
	
	function checkUserLogin($email, $slaptazodis) {
		$q = 
		"SELECT `Klientas`.`id`, `Klientas`.`email`, `Klientas`.`ar_patvirtintas`, `Klientas`.`fk_role_id`
		FROM  `boardy`.`Klientas`
		WHERE  `email` = '".$email."' AND `slaptazodis` = '".$slaptazodis."'"
		;
		$result = self::select($q);
		if(isset($result)) {
			if(count($result)==0) {
				return null;
			}
			if($result==false) {
				return null;
			}
		}
		return $result;
	}	
	
	function checkDarbuotojasLogin($email, $slaptazodis) {
		$q = 
		"SELECT `Darbuotojas`.`id`, `Darbuotojas`.`email`, `Darbuotojas`.`kodas`, `Darbuotojas`.`fk_role_id`
		FROM  `boardy`.`Darbuotojas`
		WHERE  `email` = '".$email."' AND `slaptazodis` = '".$slaptazodis."'"
		;
		$result = self::select($q);
		if(isset($result)) {
			if(count($result)==0) {
				return null;
			}
			if($result==false) {
				return null;
			}
		}
		return $result;
	}
	
	function checkForSameEmail($email) {
		$q = 
		"SELECT `Klientas`.`email`
		FROM  `boardy`.`Klientas`
		WHERE  `email` = '".$email."'";
		$result = self::select($q);
		return $result;
	}
	
	function getKlientasId($email) {
		$q = 
		"SELECT `Klientas`.`id`
		FROM  `boardy`.`Klientas`
		WHERE  `email` = '".$email."'";
		$result = self::select($q);
		return $result;
	}
	
	function getDarbuotojasId($kodas) {
		$q = 
		"SELECT `Darbuotojas`.`id`
		FROM  `boardy`.`Darbuotojas`
		WHERE  `kodas` = '".$kodas."'";
		$result = self::select($q);
		return $result;
	}
	
	function checkForSameEmailDarbuotojas($email) {
		$q = 
		"SELECT `Darbuotojas`.`email`
		FROM  `boardy`.`Darbuotojas`
		WHERE  `email` = '".$email."'";
		$result = self::select($q);
		return $result;
	}
	
	function checkForSameSlapyvardis($slapyvardis) {
		$q = 
		"SELECT `Klientas`.`email`
		FROM  `boardy`.`Klientas`
		WHERE  `slapyvardis` = '".$slapyvardis."'";
		$result = self::select($q);
		return $result;
	}
	
	// Returns boolean
	function checkForSameKodas($kodas) {
		$q = 
		"SELECT `Darbuotojas`.`email`
		FROM  `boardy`.`Darbuotojas`
		WHERE  `kodas` = '".$kodas."'";
		$result = self::select($q);
		if(isset($result)) {
			return true;
		} else {
			return false;
		}
	}
	
	function insertNewKlientas($email, $slaptazodis, $vardas, $pavarde, $slapyvardis, $ar_nori_naujienlaiskio, $ip, $patvirtinimas) {
		$q = 
		"INSERT INTO  `boardy`.`Klientas` (
			`id` ,
			`sukurimo_data` ,
			`email` ,
			`slaptazodis` ,
			`slapyvardis` ,
			`vardas` ,
			`pavarde` ,
			`ar_nori_naujienlaiskio` ,
			`ar_patvirtintas` ,
			`paskutinis_prisijungimas` ,
			`paskutinis_ip` ,
			`apsilankymu_kiekis` ,
			`fk_role_id`
		)
			VALUES (
			NULL ,  
			CURTIME(),  
			'".$email."',  
			'".$slaptazodis."', 
			'".$slapyvardis."' , 
			'".$vardas."' , 
			'".$pavarde."' ,  
			'".$ar_nori_naujienlaiskio."',  
			'".$patvirtinimas."',  
			CURTIME(),  
			'".$ip."',  
			'0',  
			'1'
		);"
		;
		$result = self::query($q);
		if (!$result) {
			//echo 'false';
			return NULL;
		}
		return $result;
	}
	
	// tipas : 2 - darbuotojas, 3 - vadybininkas
	function insertNewDarbuotojas($email, $slaptazodis, $vardas, $pavarde, $kodas, $ip, $tipas) {
		$q = 
		"INSERT INTO  `boardy`.`Darbuotojas` (
			`id`,
			`sukurimo_data` ,
			`email` ,
			`vardas` ,
			`pavarde` ,
			`kodas`,
			`slaptazodis`,
			`paskutinis_prisijungimas` ,
			`paskutinis_ip` ,
			`fk_role_id`
		)
			VALUES (
			NULL ,  
			CURTIME(),  
			'".$email."',  
			'".$vardas."' , 
			'".$pavarde."',  
			'".$kodas."', 
			'".$slaptazodis."', 
			CURTIME(),  
			'".$ip."', 
			'".$tipas."'		
		);"
		;
		$result = self::query($q);
		if (!$result) {
			//echo 'false';
			return NULL;
		}
		return $result;
	}
	
	function insertNewBiuras($el_pastas, $tel_nr, $darbo_laikas, $faksas, $isteigimo_data, $pavadinimas, $banko_saskaita, $gatve, 
		$miestas, $rajonas, $salis, $komentaras, $aukstas_pastate, $kabineto_nr)
	{
		$query = "INSERT INTO `boardy`.`Adresas` (
			`gatve` ,
			`miestas` ,
			`rajonas` ,
			`salis` ,
			`komentaras` ,
			`aukstas_pastate` ,
			`kabineto_nr`
		)
		VALUES (
			'".$gatve."', 
			'".$miestas."',
			'".$rajonas."',
			'".$salis."',
			'".$komentaras."',
			'".$aukstas_pastate."',
			'".$kabineto_nr."'
		)";
		
		$result = self::query($query);
		if (!$result) {
			echo 'false';
			return NULL;
		}
		
		//katik sukurto adreso id
		$lastID = self::getLastInsertedId();
		
		$query = "INSERT INTO `boardy`.`Biuras` (
			`el_pastas` ,
			`tel_nr` ,
			`darbo_laikas` ,
			`faksas` ,
			`isteigimo_data` ,
			`pavadinimas` ,
			`banko_saskaita` ,
			`adresas_id`
		)
		VALUES (
			'".$el_pastas."',
			'".$tel_nr."',
			'".$darbo_laikas."',
			'".$faksas."',
			'".$isteigimo_data."',
			'".$pavadinimas."',
			'".$banko_saskaita."',
			'".$lastID."' 
		)";
		
		$result = self::query($query);
		if (!$result) {
			echo 'false';
			return NULL;
		}
		return $result;
	}
	
	//Grazina visu biuru masyva
	function getBiurai() 
	{
		$query = "SELECT `Biuras`.`id`,`Biuras`.`pavadinimas`,`Biuras`.`banko_saskaita`, `Biuras`.`isteigimo_data`, `Adresas`.`gatve`, `Adresas`.`miestas` 
					FROM `boardy`.`Biuras`,`boardy`.`Adresas` 
					WHERE Biuras.adresas_id = Adresas.id";
		$result = self::select($query);
		return $result;
	}
	
	//Grazina biura pagal id
	function getBiuras($biuro_id) 
	{
		//SELECT * FROM Biuras, Adresas WHERE Biuras.adresas_id = Adresas.id
		$query = "SELECT * FROM `boardy`.`Biuras`,`boardy`.`Adresas` WHERE Biuras.adresas_id = Adresas.id AND Biuras.id = ".$biuro_id.";";
		$result = self::select($query);
		return $result;
	}
	
	function updateBiuras($el_pastas, $tel_nr, $darbo_laikas, $faksas, $isteigimo_data, $pavadinimas, $banko_saskaita, $gatve, 
		$miestas, $rajonas, $salis, $komentaras, $aukstas_pastate, $kabineto_nr, $adresas_id, $biuro_id)
	{
		
		//atnaujina adresa
		$query = 
		"UPDATE `boardy`.`Adresas` SET 
			`gatve`='".$gatve."',
			`miestas`='".$miestas."',
			`rajonas`='".$rajonas."',
			`salis`='".$salis."',
			`komentaras`='".$komentaras."',
			`aukstas_pastate`='".$aukstas_pastate."',
			`kabineto_nr`='".$kabineto_nr."'
		WHERE Adresas.id=".$adresas_id."";
		
		$result = self::query($query);
		if (!$result) {
			echo $result;
			return NULL;
		}
		
		//atnaujina biura
		$query = "UPDATE `boardy`.`Biuras` SET
			`el_pastas`='".$el_pastas."',
			`tel_nr`='".$tel_nr."',
			`darbo_laikas`='".$darbo_laikas."',
			`faksas`='".$faksas."',
			`isteigimo_data`='".$isteigimo_data."',
			`pavadinimas`='".$pavadinimas."',
			`banko_saskaita`='".$banko_saskaita."'
		WHERE Biuras.id=".$biuro_id."";
		
		$result = self::query($query);
		if (!$result) {
			echo 'false';
			return NULL;
		}
		
		return $result;
	}
	
	function trintiBiura($biuras_id, $adresas_id)
	{
		$query = "DELETE FROM `boardy`.`Adresas` WHERE id=".$adresas_id."";
		$result = self::query($query);
		if (!$result) {
			echo 'false';
			return NULL;
		}
		
		$query = "DELETE FROM `boardy`.`Biuras` WHERE id=".$biuras_id."";
		$result = self::query($query);
		if (!$result) {
			echo 'false';
			return NULL;
		}
		
		return $result;
	}
	
    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public static function query($query) {
        // Connect to the database
        $connection = mysql::connect();
        
        // Query the database
        $result = $connection->query($query);
		
        return $result;
    }
	
    /**
     * Fetch rows from the database (SELECT query)
     *
     * @param $query The query string
     * @return bool False on failure / array Database rows on success
     */
    public static function select($query) {
        $rows = array();
        $result = mysql::query($query);
        if($result === false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Fetch the last error from the database
     * 
     * @return string Database error message
     */
    public static function error() {
        $connection = mysq::connect();
        return $connection->error;
    }

    /**
     * Quote and escape value for use in a database query
     *
     * @param string $value The value to be quoted and escaped
     * @return string The quoted and escaped string
     */
    public static function quote($value) {
        $connection = mysql::connect();
        return "'" . $connection->real_escape_string($value) . "'";
    }
	
	/**
	 * Return id of last inserted row
	 * @return type
	 */
	public static function getLastInsertedId() {
		$connection = mysql::connect();
		return $connection->insert_id;
	}
	
	/**
	 * Escape variable for security
	 * @param type $field
	 * @return type
	 */
	public static function escape($field) {
		$connection =  mysql::connect();
		return mysqli_real_escape_string($connection, $field);
	}
	
}