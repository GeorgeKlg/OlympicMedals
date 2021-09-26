<?php

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME','george');
    define('DB_PASSWORD','');
    define('DB_DATABASE','medalsdb');

    function getDB() 
	{
		$dbhost=DB_SERVER;
		$dbuser=DB_USERNAME;
		$dbpass=DB_PASSWORD;
		$dbname=DB_DATABASE;
		$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);	
		$dbConnection->exec("set names 'utf8';");
		$dbConnection->exec("SET CHARACTER SET 'utf8';"); 
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
	}

    $sport = $_POST['sportName'];
    $country = $_POST['countryName'];
    $medal = $_POST['medal'];
    $sql = "INSERT INTO medalstandings (sport, country, medal) VALUES (:sport, :country, :medal)";

    try {
        $dbCon = getDB();
        $stmt = $dbCon->prepare($sql);  
        $stmt->bindParam("sport", $sport);
		$stmt->bindParam("country", $country);
		$stmt->bindParam("medal", $medal);
        $stmt->execute();
        $dbCon = null;
        return header("Location: Page1.php");
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }

?>
