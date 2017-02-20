
<html>
  <head>
    <title>Выбор темы</title>
  </head>
  <body>

<?php
  $opt = $_POST["opt"];
  echo '  <form action="', $opt, '.php" method="post">', "\n";
  $course = $_POST["course"];

  echo '      <input type="hidden" name="course" value="', $course, '" />', "\n\n";

  $mysqli = new mysqli('localhost', 'webserv', 'rfnfcnhjaf', 'de_tests');

  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
  }

  if ($result = $mysqli->query("SELECT name, specode FROM course WHERE id='$course'")) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $coursen = $row["name"];
    $specode = $row["specode"];
    $result->close();
  }

  if ($result = $mysqli->query("SELECT name FROM specialization WHERE code='$specode'")) {
    $specn = $result->fetch_array(MYSQLI_ASSOC)["name"];
    $result->close();
  }


  echo 'Специальность: ', $specn, "<br>\n";
  echo 'Курс: ', $coursen, "<br>\n";

  if ($result = $mysqli->query("SELECT theme, id FROM test WHERE courseid='$course'")) {
    $cnt = $result->num_rows;
    printf("Тестов по курсу \"%s\": %d<br>\n\n", $coursen, $cnt);
    for ($i = 0; $i < $cnt; $i++) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo '      <input type="radio" name="testid" value="', $row["id"], '" />', $row["theme"], "<br>\n";
    }

    /* free result set */
    $result->close();
  }
 
  if ($opt == "quest") {
    echo "      <br>\n", '      Новая тема?<input name="newtheme" type="checkbox"';
    if (!$cnt) echo ' checked';
    echo " /><br>\n", '      <textarea name="theme" cols=50 rows=2></textarea>', "<br>\n";
  }
?>
      <input type="submit">
    </form>
  </body>
</html>