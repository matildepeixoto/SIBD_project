<html>
 <body>
<?php
 $host = "localhost";
 $user = "root";
 $pass = "";
 $db = "SIBD";
 $dsn = "mysql:host=$host;dbname=$db";

 /*$host = "db.tecnico.ulisboa.pt";
 $user = "ist187077";
 $pass = "qrtr9733";
 $dsn = "mysql:host=$host;dbname=$user";*/

 try{
	 $conn = new PDO($dsn, $user, $pass);
 }
 catch(PDOException $exception){
	 echo("<p>Error: ");
	 echo($exception->getMessage());
	 echo("</p>");
	 exit();
 }
$client_VAT = $_REQUEST['client_vat'];
$client_name = $_REQUEST['client_name'];
$client_birth_date = $_REQUEST['client_birth_date'];
$client_street = $_REQUEST['client_street'];
$client_city = $_REQUEST['client_city'];
$client_zip = $_REQUEST['client_zip'];
$client_gender = $_REQUEST['client_gender'];
$client_age = $_REQUEST['client_age'];

$sql = "insert into client values ('$client_VAT', '$client_name', '$client_birth_date', '$client_street', '$client_city', '$client_zip', '$client_gender', '$client_age');";
?>
	<form action="client.php" method="post">
<?php if ($conn->query($sql) == TRUE): ?>

	<h2>Client inserted:</h2>
	<p>VAT:<?php echo $client_VAT ?></p>
	<p>Name:<?php echo $client_name ?></p>
	<p>Birth-date:<?php echo $client_birth_date ?></p>
	<p>Street:<?php echo $client_street ?></p>
	<p>City:<?php echo $client_city ?></p>
	<p>Zip:<?php echo $client_zip ?></p>
	<p>Gender:<?php echo $client_gender ?></p>
	<p>Age:<?php echo $client_age ?></p>

<?php else:
    echo "Error: " . $sql . "<br>" ;
endif;
?>
	 <p><input type="submit" value="Go to search"/></p>
	</form>
    </body>

 </body>
</html>