<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

 <body>
<?php
 /*$host = "localhost";
 $user = "root";
 $pass = "proj_part3";
 $db = "proj_part2";
 $dsn = "mysql:host=$host;dbname=$db";*/

 $host = "db.tecnico.ulisboa.pt";
 $user = "ist187077";
 $pass = "qrtr9733";
 $dsn = "mysql:host=$host;dbname=$user";

 try{
	 $conn = new PDO($dsn, $user, $pass);
 }
 catch(PDOException $exception){
	 echo("<p>Error: ");
	 echo($exception->getMessage());
	 echo("</p>");
	 exit();
 }
   
$client_VAT = $_REQUEST['client_VAT'];
$date = $_REQUEST['date'];
$time= $_REQUEST['time'];
$combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));

$dsql = "SELECT e.employee_VAT, e.employee_name
		FROM employee AS e, doctor AS d
		WHERE d.VAT_doctor = e.employee_VAT
		AND d.VAT_doctor NOT IN(
		SELECT a.VAT_doctor
		FROM appointment a
		WHERE '$combinedDT' BETWEEN  a.date_timestamp AND DATE_ADD(a.date_timestamp, INTERVAL 1 HOUR));";

$drows = $conn->query($dsql);
$d_rows = $drows->rowCount();

if($d_rows > 0): ?>
  <h2>Let's mark an appointment </h2>
  </br>
   <h3>Your VAT: <?php echo $client_VAT ?> </h3>
    </br>
 <h3>Doctors avaiable for <?php echo $combinedDT ?>: </h3>
<form action="insert_appointment.php" method="post">
<div class="table table-striped">
<table class="table">
  <thead>
    <tr>
    <th scope="col">VAT</th>
    <th scope="col">Name</th>
	<th scope="col">Select</th>

   </tr>
  </thead>
  <tbody>
 <?php foreach ($drows as $row): ?>
 
	<tr> 
	<td><?php echo $row['employee_VAT']; ?></a></td> 
	<td><?php echo $row['employee_name']; ?></td>
	<td><input type="checkbox" name="doc_vat[]" value="<?php echo $row['employee_VAT']; ?>"> </td>
	
	
	</tr>
 <?php endforeach;?>
  </tbody>
</table>
</div>
<input hidden type="text" name="date_timestamp" value=<?php echo $combinedDT ?> />
<input hidden type="text" name="client_VAT" value=<?php echo $client_VAT ?> />
 <p>Appointment description: <input type="text" name="descp"/></p>
 <p><input type="submit" value="Create appointment"></p>
 </form>
  <?php
else: 
 echo("<p>No doctor avaiable. Click to select other time</p>");?>
 
<form action="client_page.php" method="post">
	<input hidden type="text" name="client_VAT" value=<?php echo $client_VAT ?>>
	<p><input type="submit" class="btn btn-info" value="Change time"/></p>
</form>
  <?php endif;?>

 </body>
</html>