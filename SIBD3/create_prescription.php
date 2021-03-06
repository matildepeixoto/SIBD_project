<html>     
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <body>  
    <?php 
        $host = "db.tecnico.ulisboa.pt";
        $user = "ist187077";
        $pass = "qrtr9733";
        $dsn = "mysql:host=$host;dbname=$user";
    
        /*$host = "localhost";
        $user = "root";
        $pass = "";
        $db = "SIBD";
        $dsn = "mysql:host=$host;dbname=$db";*/

        try{
            $conn = new PDO($dsn, $user, $pass);
        }
        catch(PDOException $exception){
            echo("<p>Error: ");
            echo($exception->getMessage());
            echo("</p>");
            exit();
        }

        $vat_doctor = $_REQUEST['vat_doctor'];
        $date = $_REQUEST['date'];
        $id = $_REQUEST['id'];
        $med_sql = "SELECT medication_name, medication_lab FROM medication";
        $med = $conn->query($med_sql);
    ?>    
        <div class="container">
            <h2>Prescription:</h2>
            <form action="insert_prescription.php" method="post">  
                <div class="form-group">
                    <label for="vat_doctor">VAT_Doctor:</label>
                    <input readonly type="text" class="form-control" name="vat_doctor" value="<?php echo($vat_doctor) ?>" >
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input readonly type="text" class="form-control" name="date" value="<?php echo($date) ?>" >
                </div>
                <div class="form-group">
                    <label for="medication">Medication Name/Medication Lab:</label>
                    <select class="form-control" name="medication">
                            <option selected disabled>--Choose an option--</option>
                        <?php
                            foreach ($med as $row){
                            $medName = $row['medication_name'];
                            $medLab = $row['medication_lab'];
                                echo("<option> $medName/$medLab</option>"); 
                            } ?>
                        </select>
                </div>
                <div class="form-group">
                    <label for="presc_id">Prescription ID:</label>
                    <input readonly type="text" class="form-control" name="presc_id" value="<?php echo($id) ?>">
                </div>
                <div class="form-group">
                    <label for="dosage">Dosage:</label>
                    <input type="text" class="form-control" name="dosage">
                </div>
                <div class="form-group">
                    <label for="prescription_description">Prescription Description:</label>
                    <input type="text" class="form-control" name="prescription_description">
                </div>
                <input type="submit" class="btn btn-info" value="Insert"/>
            </form>
        </div>
    </body>
</html>