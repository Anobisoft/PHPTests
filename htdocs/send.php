
<html>
  <head>
    <title>Создание теста</title>
  </head>
  <body>

    <form action="quest.php" method="post">

<?php

  $question = $_POST["question"];
  $vrcnt = $_POST["vrcnt"];
  $testid = $_POST["testid"];

  echo '<input type="hidden" name="testid" value="', $testid, '" />', "\n";


  $mysqli = new mysqli('localhost', 'webserv', 'rfnfcnhjaf', 'de_tests');

  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
  }

  if ($mysqli->query("INSERT INTO question (qtext, testid) VALUES ('$question', '$testid')")) {
    $qid = $mysqli->insert_id;
  }

  for ($i = 0; $i < $vrcnt; $i++) {
    echo $i, " ", $t = isset($_POST["correct$i"]) ? 1 : 0, " ";
    echo $answer = $_POST["answer$i"], "<br>\n";
    $mysqli->query("INSERT INTO answer (atext, questid, correct) VALUES ('$answer', '$qid', '$t')");
  }
  echo "Вопрос отправлен в базу<br>\n";

?>

      <input type="submit" value="Добавить еше вопрос" />
    </form>
    <a href="index.php">Домой</a>
  </body>
</html>