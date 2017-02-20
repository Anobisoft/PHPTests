
<html>
  <head>
    <title>Выбор специальности</title>
  </head>
  <body>


    <form action="selcourse.php" method="post">

<?php

echo '      <input type="hidden" name="opt" value="', $_POST["opt"], '" />', "\n\n";

$mysqli = new mysqli('localhost', 'webserv', 'rfnfcnhjaf', 'de_tests');

if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

if ($result = $mysqli->query("SELECT name, code FROM specialization")) {
    $cnt = $result->num_rows;
    printf("Специальнотей: %d<br>\n", $cnt);
    for ($i = 0; $i < $cnt; $i++) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo '<input type="radio" name="specode" value="', $row["code"], '" />', $row["name"], "<br>\n";
    }

    /* free result set */
    $result->close();
}

$mysqli->close();

?>

      <input type="submit" />
    </form>
  </body>
</html>


