<html>
<head>
<title>PHP und MySQL</title>
</head>
<body>
<h1>PHP und MySQL</h1>
<table border="1">
<tr>
    <th>Vorname</th>
    <th>Nachname</th>
    <th>Telefonnummer</th>
</tr>
<?php
    mysqli_connect("localhost", "oswald", "geheim");
    mysqli_select_db("phonebook");

    $query = "SELECT * FROM users";
    $result = mysqli_query(null,$query);
    while ($row = mysqli_fetch_array  ($result))
    {
        echo "<tr>";
        echo "<td>".$row['firstname']."</td>";
        echo "<td>".$row['lastname']."</td>";
        echo "<td>".$row['phone']."</td>";
        echo "</tr>";
    }

?>
</table>
</body>
</html>
