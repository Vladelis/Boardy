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
	
	function updateUserLogin($ip, $email) {
		$q = 
		"UPDATE  `harhib`.`Klientas` 
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
		"UPDATE  `harhib`.`Darbuotojas` 
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
		FROM  `harhib`.`Klientas`
		WHERE  `email` = '".$email."'"
		;
		$result = self::select($q);
		return $result;
	}
	
	function getFullDarbuotojasData($kodas) {
		$q = 
		"SELECT `Darbuotojas`.`email`, `Darbuotojas`.`vardas`, `Darbuotojas`.`pavarde`, `Darbuotojas`.`kodas`
		FROM  `harhib`.`Darbuotojas`
		WHERE  `kodas` = '".$kodas."'"
		;
		$result = self::select($q);
		return $result;
	}
	
	function checkUserLogin($email, $slaptazodis) {
		$q = 
		"SELECT `Klientas`.`email`, `Klientas`.`ar_patvirtintas`, `Klientas`.`fk_role_id`
		FROM  `harhib`.`Klientas`
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
		"SELECT `Darbuotojas`.`email`, `Darbuotojas`.`kodas`, `Darbuotojas`.`fk_role_id`
		FROM  `harhib`.`Darbuotojas`
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
		FROM  `harhib`.`Klientas`
		WHERE  `email` = '".$email."'";
		$result = self::select($q);
		return $result;
	}
	
	function checkForSameEmailDarbuotojas($email) {
		$q = 
		"SELECT `Darbuotojas`.`email`
		FROM  `harhib`.`Darbuotojas`
		WHERE  `email` = '".$email."'";
		$result = self::select($q);
		return $result;
	}
	
	function checkForSameSlapyvardis($slapyvardis) {
		$q = 
		"SELECT `Klientas`.`email`
		FROM  `harhib`.`Klientas`
		WHERE  `slapyvardis` = '".$slapyvardis."'";
		$result = self::select($q);
		return $result;
	}
	
	// Returns boolean
	function checkForSameKodas($kodas) {
		$q = 
		"SELECT `Darbuotojas`.`email`
		FROM  `harhib`.`Darbuotojas`
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
		"INSERT INTO  `harhib`.`Klientas` (
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
		"INSERT INTO  `harhib`.`Darbuotojas` (
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