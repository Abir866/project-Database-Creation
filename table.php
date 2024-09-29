/**
Page that displays all the uptions for tables available in the database
 */

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
        $table = $_POST["table"];
    ?>
    <form action="table.php" method="POST">
        <select name="table">
            <option value="">Choose a table</option>
            <option value="suppliers">suppliers</option>
            <option value="supp_tel">supp_tel</option>
            <option value="orders">orders </option>
            <option value="order_items">order_items</option>
            <option value="supp_part">supp_part</option>
            <option value="parts">parts</option>
        </select>
        <input type="submit" value="submit"/>
    </form>
    <?php
    $query = mysqli_query($conn, "select * from $table");

    if (mysqli_num_rows($query) > 0) {
        print "<h2 style='text-transform: capitalize;'>$table</h2>";
        print "<table border=1>\n";
        while ($a_row = mysqli_fetch_row($query)) {
                print "<tr>";
                foreach ($a_row as $field) print "<td>$field</td>";
                print "</tr>";
        }
        print "</table>";
    } else {
        if ($table) {
            echo "<p>table not found!</p>";
        }
    }
    ?>
</body>
</html>