<!DOCTYPE html>
<html lang="en">
<head>

	<title>Medals</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="Main.css">
	<script src="page1.js"></script>
</head>
<body>
<?php
	    define('DB_SERVER', 'localhost');
		define('DB_USERNAME','george');
		define('DB_PASSWORD','');
		define('DB_DATABASE','medalsdb');
	
	
		$dbhost=DB_SERVER;
		$dbuser=DB_USERNAME;
		$dbpass=DB_PASSWORD;
		$dbname=DB_DATABASE;
		$dbConnection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

		
?>
	<h3><b>Olympic Games: Store Medals Results</b></h3>
	<form action="store.php" method="POST" id="storeForm">
		<label>Sport:</lable>
		<select name="sportName" >
			<?php 
				$sql = "SELECT * FROM sport ORDER BY sportname";
				mysqli_set_charset($dbConnection, "utf8");				
				$result = mysqli_query($dbConnection, $sql);

				while ($row = mysqli_fetch_assoc($result)){
					$name = $row['sportname'];
					echo "<option value='".$name."'>".$name."</option>";
				}		
			?>
		</select>
		</br>
		<label>Country:</lable>
		<select name="countryName" >
			<?php 
				$sql = "SELECT * FROM country ORDER BY countryname";
				mysqli_set_charset($dbConnection, "utf8");				
				$result = mysqli_query($dbConnection, $sql);

				while ($row = mysqli_fetch_assoc($result)){
					$name = $row['countryname'];
					echo "<option value='".$name."'>".$name."</option>";
				}		
			?>
		</select>
		</br></br>
		<b>Medals</b>
		</br></br>

		<input type="radio" id="gold" name="medal" value="Gold">
		<label for="gold">Gold</label><br>

		<input type="radio" id="silver" name="medal" value="Silver">
		<label for="silver">Silver</label><br>

		<input type="radio" id="bronze" name="medal" value="Bronze">
		<label for="bronze">Bronze</label>
		</br></br>
	</form>

	<button onclick="submitForm()">Store</button>
	<button onclick="testsFunction()" type="button">View Medal Standings</button>

	<div id="TestsDiv" style="display:none">
		<h3><b>Medal Standings</b></h3>
		<div id="greyDiv">
			<div id="MedalDiv" class="box">
				<div class="StatsDiv">
					<lable>Country</lable></br></br>
					<?php 
						$sql = "SELECT country, count(*) as c FROM medalstandings GROUP BY country";
						mysqli_set_charset($dbConnection, "utf8");				
						$result = mysqli_query($dbConnection, $sql);
						$sum = 0;
						while ($row1 = mysqli_fetch_assoc($result)){
							$num = $row1['c'];
							$sum += $row1['c'];
						}
						$result = mysqli_query($dbConnection, $sql);
						while ($row1 = mysqli_fetch_assoc($result)){
							$country = $row1['country'];
							$num = $row1['c'];
							echo $country.": ".$num."</br>";
							echo "<progress value='".$num."' max='".$sum."'></progress></br>";
						}
					?>
				</div>
			</div>
			<div id="DetailsDiv" class="box">
				<label for="detailsForm">Details for</lable>
					<form acttion="" method="GET" id="detailsForm" name="detailsForm">
						<select name="countryNameDetails" onchange="getDetails()">
							<option value="">-</option>
							<?php 
								$sql = "SELECT * FROM country ORDER BY countryname";
								mysqli_set_charset($dbConnection, "utf8");				
								$result = mysqli_query($dbConnection, $sql);

								while ($row = mysqli_fetch_assoc($result)){
									$name = $row['countryname'];
									if(isset($_GET["countryNameDetails"])){
										if($name == $_GET["countryNameDetails"]){
											echo "<option value='".$name."' selected>".$name."</option>";
										}
										else{
											echo "<option value='".$name."'>".$name."</option>";
										}
									}
									else{
										echo "<option value='".$name."'>".$name."</option>";
									}
									
								}		
							?>
						</select>
					</form>
					</br>
					<?php 
						if(isset($_GET["countryNameDetails"])){
							$c=$_GET["countryNameDetails"];
							$sql = "SELECT medal, sport FROM medalstandings WHERE country='".$c."'";
							mysqli_set_charset($dbConnection, "utf8");				
							$result = mysqli_query($dbConnection, $sql);
							$g = false;
							$s = false;
							$b = false;
							if($result != null){
								while ($row = mysqli_fetch_assoc($result)){
									$medal = $row['medal'];
									$sport = $row['sport'];
									if($medal == "Gold"){
										$g = true;
									}
									else if($medal == "Silver"){
										$s = true;
									}
									else{
										$b = true;
									}
									echo $medal.": ".$sport."</br>";
								}
							}
							
							if(!$g){
								echo "Gold: -</br>";
							}
							if(!$s){
								echo "Silver: -</br>";
							}
							if(!$b){
								echo "Bronze: -</br>";
							}
							echo "<script type='text/javascript'>testsFunction();</script> ";
						}
					?>
			</div>
		</div>
	</div>
		
</div>
</body>

</html>
