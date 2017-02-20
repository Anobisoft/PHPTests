<html>
  <head>
    <title>Создание теста</title>
  </head>
  <body>
    <form action="send.php" method="post">

<?php
  $question = $_POST["question"];
  $vrcnt = $_POST["vrcnt"];
  $testid = $_POST["testid"];
  echo '      <input type="hidden" name="question" value="', $question, '" />', "\n";
  echo '      <input type="hidden" name="vrcnt" value="', $vrcnt, '" />', "\n";
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

Правильные ответы отмечены красным.<br>

<?php
  for ($i = 0; $i < $vrcnt; $i++) {

    if (isset($_POST["correct$i"])) {
      echo '<input type="hidden" name="correct', $i, '" value=on />', "\n";
      echo '<font color="#FF0000">', "\n";
    }
    echo $i, ') ';
    echo $_POST["answer$i"], "<br>\n";
    if (isset($_POST["correct$i"])) echo "</font>\n";
    echo '<input type="hidden" name="answer', $i, '" value="', $_POST["answer$i"], '" />', "\n\n";
  }

?>

      <input type="submit">
    </form>
  <body>
</html>