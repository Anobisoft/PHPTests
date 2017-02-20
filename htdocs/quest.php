<html>
  <head>
    <title>Создание теста</title>
  </head>
  <body>

    <form action="answer.php" method="post">

<?php

  $maxv = 6;

  $mysqli = new mysqli('localhost', 'webserv', 'rfnfcnhjaf', 'de_tests');

  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
  }

  if (isset($_POST["course"])) {
    $course = $_POST["course"];
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
  }

  echo "Тема: ";

  if (isset($_POST["newtheme"])) {
    $theme = $_POST["theme"];
    if ($result = $mysqli->query("SELECT id FROM test WHERE theme='$theme'")) {
      if ($result->num_rows) die('Такая тема уже есть!');
      $result->close();
    }
    if ($mysqli->query("INSERT INTO test (theme, courseid) VALUES ('$theme','$course')")) {
      $testid = $mysqli->insert_id;
      echo $theme;
    }
  } else {
    $testid = $_POST["testid"];
    if ($result = $mysqli->query("SELECT theme FROM test WHERE id='$testid'")) {
      if ($result->num_rows) echo $theme = $result->fetch_array(MYSQLI_ASSOC)["theme"];
      else die('Нет темы с таким индексом! Как так?!');
      $result->close();
    }
  }
  echo "\n", '      <input type="hidden" name="testid" value="', $testid, '" />';

  echo "<br><br>\n";

?>
      Вопрос<br>
      <textarea name="question" required cols=100 rows=20></textarea><br>
<?php
      echo "      Введите количество вариантов ответов (от 2 до $maxv)<br>\n";
      echo '      <input name="vr" type="range" min="2" max="', $maxv, '" value="', $maxv / 2, '" oninput="vrcnt.value = vr.valueAsNumber" />', "\n";
      echo '      <input name="vrcnt" type="number" min="2" max="', $maxv, '" value="', $maxv / 2, '" oninput="vr.value = vrcnt.valueAsNumber" />', "\n";
?>
      <input type="submit">
    </form>
  </body>
</html>