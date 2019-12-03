<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <body>  
        <?php
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

        $doctor = $_REQUEST['VAT_doctor'];
        $date = $_REQUEST['date_timestamp']; 
        $VATnurse_sql = "SELECT DISTINCT n.VAT_nurse FROM nurse AS n, consultation_assistant as ca 
                        WHERE n.VAT_nurse = ca.VAT_nurse AND ca.VAT_nurse NOT IN (SELECT ca.VAT_nurse 
                        FROM consultation_assistant AS ca, appointment AS a 
                        WHERE a.date_timestamp = ca.date_timestamp AND a.VAT_doctor = ca.VAT_doctor 
                        AND '$date' = a.date_timestamp";
        $soap_sql = "SELECT SOAP_S, SOAP_O, SOAP_A, SOAP_P FROM consultation WHERE VAT_doctor = '$doctor' AND date_timestamp = '$date'";
        $dcID_sql = "SELECT ID FROM diagnostic_code";
        $medName_sql = "SELECT medication_name FROM medication";
        $medLab_sql = "SELECT medication_lab FROM medication";
        $VAT_nurse = $conn->query($VATnurse_sql);
        $soap = $conn->query($soap_sql);
        $dcID = $conn->query($dcID_sql);
        $medName = $conn->query($medName_sql);
        $medLab = $conn->query($medLab_sql);
        ?>
        <div class="container">
            <h2>Update Consultation:</h2>
            <form action="insert_update_cons.php" method="post">
                <div class="form-group">
                    <label for="vat_doctor">VAT_Doctor:</label>
                    <input readonly type="text" class="form-control" name="vat_doctor" value="<?php echo($doctor) ?>" >
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input readonly type="text" class="form-control" name="date" value="<?php echo($date) ?>" >
                </div>
                <?php
                foreach($soap as $row) { ?> 
                    <div class="form-group">
                        <label for="s">S:</label>
                        <input type="text" class="form-control" name="s" value="<?php echo($row['SOAP_S']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="o">O:</label>
                        <input type="text" class="form-control" name="o" value="<?php echo($row['SOAP_O']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="a">A:</label>
                        <input type="text" class="form-control" name="a" value="<?php echo($row['SOAP_A']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="p">P:</label>
                        <input type="text" class="form-control" name="p" value="<?php echo($row['SOAP_P']) ?>">
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="vat_nurse">VAT_Nurse:</label>
                    <select class="form-control" name="vat_nurse">
                        <option selected disabled>--Choose an option--</option>
                    <?php
                        foreach ($VAT_nurse as $row){ ?>
                            <option><?php echo $row['VAT_nurse'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="diagnostic_id">ID:</label>
                    <select class="form-control" name="diagnostic_id">
                        <option selected disabled>--Choose an option--</option>
                    <?php
                        foreach ($dcID as $row){ ?>
                            <option><?php echo $row['ID'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="medication_name">Medication Name:</label>
                    <select class="form-control" name="medication_name">
                        <option selected disabled>--Choose an option--</option>
                    <?php
                        foreach ($medName as $row){ ?>
                            <option><?php echo $row['medication_name'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="medication_lab">Medication Lab:</label>
                    <select class="form-control" name="medication_lab">
                        <option selected disabled>--Choose an option--</option>
                    <?php
                        foreach ($medLab as $row){ ?>
                            <option><?php echo $row['medication_lab'] ?> </option>
                        <?php } ?>
                    </select>
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