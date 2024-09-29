/** Web page to add new applier to the data base */ 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <base href="http://dbcourse.cs.smu.ca/~u05/">
</head>
<body>
    <?php
        require("./mysql.php");
        if (!$conn) {
            die("could not connect to MySQL");
        }
    ?>
    // Form to input supplier information
    <form action="newSupplier.php" methos="POST">
        <label for="Name:">name:</label>
        <input id="name" name="name" type="text"/>
        <label for="Email:">email:</label>    
        <input id="email" name="email" type="email"/>    
        <label for="number">Phone Number:</label>
        <input id="number" name="number" type="text"/>
        <input type="submit"/>
    </form>
    <?php
    // Script to add the new supplier information to the database ensuring no duplicate phone numbers are allowed
        $name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $numbers = explode(" ", $_REQUEST["number"]);

        if (strlen($name) > 0 && strlen($email) > 0) {
            mysqli_query($conn, "insert into suppliers (name, email) values ('$name', '$email')");
            
            $last_id = mysqli_insert_id($conn);

            $numbersExist = false;

            foreach ($numbers as $number) {
                $numberQuery = mysqli_query($conn, "select * from supp_tel where number='$number'");
                
                if (mysqli_num_rows($numberQuery) > 0) {
                    $numbersExist = true;
                    break;
                }
            }

            if (!$numbersExist) {
                foreach ($numbers as $number) {
                    $number_insert = mysqli_query($conn, "insert into supp_tel (supp_id,number) values ('$last_id', '$number')");
                }
            } else {
                echo "<p>Atleast one of the numbers already in database!</p>";
            }
        }


    ?>
</body>
</html>