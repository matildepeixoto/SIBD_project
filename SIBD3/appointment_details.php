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

    $date = $_REQUEST['date_timestamp'];
    $doctor = $_REQUEST['VAT_doctor'];
    $appdetsql = "SELECT VAT_client, appointment_description
                    FROM appointment 
                    WHERE date_timestamp = '$date' AND VAT_doctor = '$doctor'";
    $appdetails = $conn->query($appdetsql);
    if ($appdetails == FALSE)
    {
        $info = $conn->errorInfo();
        echo("<p>Error: {$info[2]}</p>");
        exit();
    }
    echo("<h2>Appointment details:</h2>");
    foreach ($appdetails as $row){
        $client = $row['VAT_client'];
        $description = $row['appointment_description'];
        echo("<br>Client: $client</br>");
        echo("<br>Date: $date</br>");
        echo("<br>Doctor: $doctor</br>");
        echo("<br>Description: $description</br>");
    }

    /*foreach ($consverification as $row){
        if ($row['c.VAT_doctor'] == NULL){
            echo("<form action=\"create_consultation.php?date_timestamp=$date&doctor=$doctor\" method=\"post\">");
            echo("<input type=\"submit\" value=\"New Consultation\"></form>\n");
        }
    }*/

    ?>
    </body>
</html>