<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['firstname']) && isset($_POST['lastname']) &&
        isset($_POST['email']) && isset($_POST['venuetype']) &&
        isset($_POST['guestnumber']) && isset($_POST['placement']) && isset($_POST['date']) && isset($_POST['time'])
         && isset($_POST['note'])) {
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $venuetype = $_POST['venuetype'];
        $guestnumber = $_POST['guestnumber'];
        $placement = $_POST['placement'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $note = $_POST['note'];
        
        $host = "localhost";
        $dbUsername = "admin";
        $dbPassword = "";
        $dbName = "evento";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM createevent WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO createevent(firstname, lastname, email, venuetype, guestnumber, placement, date, time, note) 
            values(?, ?, ?, ?, ?, ?,?,?,?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssssssss",$firstname, $lastname, $email, $venuetype, $guestnumber, $placement, $date, $time, $note);
                if ($stmt->execute()) {
                   echo"New record has been inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All fields are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>