
<html>
  <head>
    <title>Выбор курса</title>
  </head>
  <body>


    <form action="theme.php" method="post">

<?php

  $specode = $_POST["specode"];

  echo '      <input type="hidden" name="opt" value="', $_POST["opt"], '" />', "\n\n";

  $mysqli = new mysqli('localhost', 'webserv', 'rfnfcnhjaf', 'de_tests');

  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
  }

  if ($result = $mysqli->query("SELECT name FROM specialization WHERE code='$specode'")) {
    $specn = $result->fetch_array(MYSQLI_ASSOC)["name"];
    $result->close();
  }

  if ($result = $mysqli->query("SELECT name, id FROM course WHERE specode='$specode'")) {
    $cnt = $result->num_rows;
    printf("Курсов по специальности \"%s\": %d<br>\n", $specn, $cnt);
    for ($i = 0; $i < $cnt; $i++) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo '<input type="radio" name="course" value="', $row["id"], '" />', $row["name"], "<br>\n";
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


