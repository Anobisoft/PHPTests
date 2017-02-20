<html>
  <head>
    <title>Создание теста</title>
  </head>
  <body>
    <form action="preview.php" method="post">

<?php

  $question = $_POST["question"];
  $vrcnt = $_POST["vrcnt"];
  $testid = $_POST["testid"];

  echo '      <input type="hidden" name="question" value="', $question, '" />', "\n";
  echo '      <input type="hidden" name="vrcnt" value="', $vrcnt, '" />', "\n\n";
  echo '      <input type="hidden" name="testid" value="', $testid, '" />', "\n";

  $mysqli = new mysqli('localhost', 'webserv', 'rfnfcnhjaf', 'de_tests');

  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
  }

  if ($result = $mysqli->query("SELECT theme FROM test WHERE id='$testid'")) {
    $theme = $result->fetch_array(MYSQLI_ASSOC)["theme"];
    $result->close();
  }

  echo 'Тема: ', $theme, "<br><br>\n\n";

  echo $question, "<br><br>\n";

?>

Пометьте правильные варианты ответов<br><br>

<?php
  for ($i = 0; $i < $vrcnt; $i++) {
    echo '      <input type="checkbox" name="correct', $i, '" />';
    echo "Вариант ответа ", $i+1, "<br>\n", '      <textarea name="answer', $i, '" cols="100", rows="4" required></textarea><br>', "\n";
  }

?>

      <input type="submit">
    </form>
  <body>
</html>