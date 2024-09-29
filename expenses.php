/** Expense page to know yearly expenses from a certain range of years */
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
    // connects to the mysql database
    <?php
        require("./mysql.php");
        if (!$conn) {
            die("could not connect to MySQL");
        }
    ?>
// Markup for expense page
    <form action="expenses.php" method="POST">
        <label for="startYear">start year:</label>
        <input name="startYear" type="number"/>
        <label for="endYear">end year:</label>
        <input name="endYear" type="number"/>
    <input type="submit"/>

    <?php
    // Query the database for information of all expenses between the assigned dates 
        $startYear = $_REQUEST["startYear"];
        $endYear = $_REQUEST["endYear"];

        $annualExpenses = mysqli_query($conn, "select pts.year, sum(pts.price), count(pts.price)
            from (select year(_when) as year, (parts.price * order_items.qty) as price
            from orders, order_items, parts 
            where orders._id = order_items.order_id and
             order_items.part_id = parts._id and 
             year(_when) >= $startYear and year(_when) <= $endYear) as pts
             group by pts.year order by pts.year;");
// Creates table to display expenses
        if (mysqli_num_rows($annualExpenses) > 0) {
            print "<table border=1>\n";
            while ($a_row = mysqli_fetch_row($annualExpenses)) {
                    print "<tr>";
                    foreach ($a_row as $field) print "<td>$field</td>";
                    print "</tr>";
            }
            print "</table>";
        } else {
            if ($table) {
                echo "<p>no year found!</p>";
            }
        }
        
    ?>
    </form>
</body>
</html>