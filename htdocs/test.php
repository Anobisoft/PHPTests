<html>
  <head>
    <title>Тест</title>

<script language ="JavaScript">
<!--

function check() {
  var correct = 0;
  for (j = 0; j < document.forms.length-1; j++) {
    var allright = true;
    var checked = false;
    for (i = 0; i < document.forms[j].elements.length; i++) {
      if (document.forms[j].elements[i].checked != document.forms[j].elements[i].value) allright = false;
      if (document.forms[j].elements[i].checked) checked = true;
    }
    correct += allright;
    var formj = document.getElementsByTagName('form')[j];
    var p = formj.getElementsByTagName('p')[0];
    if (checked) p.innerHTML = allright ? '<font color="#00AA00">Верно</font>' : '<font color="#DD0000">Неверно</font>';
    else p.innerHTML = 'Вариант не выбран';
  }
 
  g = Math.round(correct * 100 / j);
  p = document.body.getElementsByTagName('p')[j];
  p.innerHTML = 'Всего вопросов: ' + j + '<br>Правильных ответов: ' + correct + ', что составляет ' + g + '%';
 
  alert('Вы правильно ответили на ' + correct + ' вопросов из ' + j);

}

//-->
</script> 


 
  </head>

  <body>
    <h3>Тест для самоконтроля знаний студентов дистанционного обучения</h3>
<?php 
  if (!isset($_POST["testid"])) die('Тест не выбран!');
  $course = $_POST["course"];
  $testid = $_POST["testid"];

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

  if ($result = $mysqli->query("SELECT theme FROM test WHERE id='$testid'")) {
    $theme = $result->fetch_array(MYSQLI_ASSOC)["theme"];
    $result->close();
  }

  echo '    <font size="4">Специальность: ', $specn, "</font><br>\n";
  echo '    <font size="4">Курс: ', $coursen, "</font><br>\n";
  echo '    <font size="4">Тема: ', $theme, "</font><br>\n    <br><br>\n";

  if ($resultq = $mysqli->query("SELECT qtext, id FROM question WHERE testid=$testid")) {
    $cntq = $resultq->num_rows;
    for ($i = 0; $i < $cntq; $i++) {
      $rowq = $resultq->fetch_array(MYSQLI_ASSOC);
      $quest = $rowq["qtext"];
      $qid = $rowq["id"];
      echo "  $i.", " $quest<br>\n";
      echo '  <form name="q', $i, '">', "\n";
      if ($result = $mysqli->query("SELECT atext, correct FROM answer WHERE questid=$qid")) {
        $cnt = $result->num_rows;
        $cc = 0;
        for ($j = 0; $j < $cnt; $j++) {
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $answer[$j] = $row["atext"];
          $correct[$j] = $row["correct"];
          $cc += $correct[$j];
          
        }
        for ($j = 0; $j < $cnt; $j++) {
          echo '    <input name="q', $i, '" type="';
          if ($cc == 1) echo "radio";
          else echo"checkbox";
          echo '" value="', $correct["$j"], '" />', $answer["$j"], "<br>\n";

        }
        $result->close();
      }   
      echo "    <p></p>\n  </form>\n";

    }
    $resultq->close();
  }

?>

    
  <form name="checkBtn">
    <input type="button" value="Проверка" onClick="check()">
  </form>
  <p></p>

  </body>
</html>
