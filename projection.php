/**Projection page for the company that gives a future budget each year for a certain number 
of years based on the specified inflation rate */

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
    // Form to input user data for  number of years and inflation rate
    <form action="./projection.php" method="POST">
        <label for="numYear">Enter number of upcoming year:</label>
        <input name="numYear" type="number"/>
        <label for="inflation">Enter inflation rate:</label>
        <input name="inflation" type="decimal"/>
        <input type="submit"/>
    </form>
    <?php
     <!-- Connect to databse  to retrieve -->
    require("./mysql.php");

    if (!$conn) {
        die("could not connect to MySQL");
    }

    $lastYear = date("Y") - 1;
    $numYear = $_REQUEST["numYear"];
    $inflation = $_REQUEST["inflation"];
<!-- calculate the budget based on the last year expenses -->
    $annualExpenses = mysqli_query($conn, "select sum(pts.price)
    from (select year(_when) as year, (parts.price * order_items.qty) as price 
    from orders, order_items, parts 
    where orders._id = order_items.order_id and
        order_items.part_id = parts._id and 
        year(_when) = $lastYear) as pts
        group by pts.year;");
<!-- Displays the budget each year upto the required number of years
    if (mysqli_num_rows($annualExpenses) > 0) {
        $recentAmount = mysqli_fetch_row($annualExpenses)[0];
        print "<table border=1>\n";
        for ($year = 0; $year <= $numYear; $year++) {
            print "<tr>";
            print "<td>". round($recentAmount * (1.0 + $inflation), 2) ."</td>";
            print "</tr>";
            $recentAmount = $recentAmount * (1.0 + $inflation);
        }
        print "</table>";
    } else {
        print "<p>fail to get year!</p>";
    }
    ?>
    
</body>
</html>