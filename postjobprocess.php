<?php
include("systems/functions.php");
$ErrMsg = array();


if (!isset($_POST["postForm"])) {
  header("location: index.php");
  exit();
} else {
  //clean inputs
  $positionID = cleanInput($_POST['posID']);
  $jobTitle = cleanInput($_POST['jobTitle']);
  $jobDescription = cleanInput($_POST['jobDescription']);
  $jobClosingDate = cleanInput($_POST['jobClosingDate']);
  $jobLocation = cleanInput($_POST['jobLocation']);
  $jobDescription = cleanTextField($jobDescription);

 //check condition for all inputs, return error to array
  if ($positionID == "") {
    array_push($ErrMsg, "Position ID", "Cannot be empty");
  } elseif (!preg_match("/^(P\d{4})$/", $positionID)) {
    array_push($ErrMsg, "Position ID", "Wrong format. Must have 'P' and follow by 4 digits");
  }

  //20 max char
  if ($jobTitle == "") {
    array_push($ErrMsg, "Title", "Cannot be empty");
  } elseif (!preg_match("/^(\w[\s,\.\!]*){1,20}$/", $jobTitle)) {
    if (strlen($jobTitle) > 21) {
      array_push($ErrMsg, "Title", "Characters limit reach. Ensure that title is no more than 20 characters long");
    } else {
      array_push($ErrMsg, "Title", "Only '.'(fullstop), ','(coma) and '!'(exclaimation mark) are allowed");
    }
  }

  // 260 characters max
  if ($jobDescription == "") {
    array_push($ErrMsg, "Description", "Cannot be empty");
  } elseif (strlen($jobDescription) > 261) {
    array_push($ErrMsg, "Description", "Characters limit reach. Ensure that description is no more than 260 characters long");
  }

  if ($jobClosingDate == "") {
    array_push($ErrMsg, "Closing Date", "Cannot be empty");
  } elseif (!preg_match("/^((3[0|1]|2\d|1\d|0\d|[1-9])\/(1[0-2]|0\d|[1-9])\/(\d{2}))$/", $jobClosingDate)) {
    array_push($ErrMsg, "Closing Date", "Wrong date format. Format must be 'dd/mm/yy'. dd- day, mm- month, yy- last 2 digits of the year");
  }

  //check null status
  if (isset($_POST['jobPosition'])) {
    $jobPosition = $_POST['jobPosition'];
  } else {
    array_push($ErrMsg, "Position", "Cannot be blank");
  }

  if (isset($_POST['jobContract'])) {
    $jobContract = $_POST['jobContract'];
  } else {
    array_push($ErrMsg, "Contract", "Cannot be blank");
  }

  if (isset($_POST['jobApplication'])) {
    $jobAcceptApplication = $_POST['jobApplication'];
  } else {
    array_push($ErrMsg, "Position", "Cannot be blank");
  }

  if ($jobLocation == "") {
    array_push($ErrMsg, "Location", "Cannot be blank");
  }

 //check file availability
  if (!file_exists($fileDir)) {
    umask(0007);
    if (!file_exists($dir))
      mkdir($dir, 02770);

    $fileOpen = fopen($fileDir, "w");
    fclose($fileOpen);
  }

  //check PositionID unique
  if (isPosIDExist($positionID, $fileDir)) {
    array_push($ErrMsg, "Position ID", "Found duplicate. Please try another ID");
  }

  //output
  if ($ErrMsg != array()) {
    include("style/header.php");
    echo displayErrMessage($ErrMsg);//send all error in array
    echo "<a class='button' href='postjobform.php'>Back</a>";
    include("style/footer.php");
  } else {
    include("style/header.php");
    echo "<h2>Successfully added your request with the following criteria:</h2>";
    echo "
    <nav class=\"result\">
      <p><strong> Position ID:</strong> " . $positionID . "</p>
      <p><strong> Job title:</strong> " . $jobTitle . "</p>
      <p><strong> Description: </strong> " . $jobDescription . "</p>
      <p><strong> Closing Date: </strong> " . $jobClosingDate . "</p>
      <p><strong> Position: </strong> " . $jobPosition . "</p>
      <p><strong> Contract: </strong> " . $jobContract . "</p>
      <p><strong> Apply by: </strong> " . implode(", ", $jobAcceptApplication) . "</p>
      <p><strong> Location: </strong> " . $jobLocation . "</p>
    </nav>
    ";
    echo "<a class='button' href='postjobform.php'>Back</a>";
    include("style/footer.php");

    // //Convert all data to lower case, upcase first char
    $postJobData = $positionID . "\t" . ucwords(strtolower($jobTitle)) . "\t" . $jobDescription . "\t" . $jobClosingDate . "\t" . $jobPosition . "\t" . $jobContract . "\t" . implode(", ", $jobAcceptApplication) . "\t" . $jobLocation . "\n";
    $openFile = fopen($fileDir, "a+");
    fwrite($openFile, $postJobData);
    fclose($openFile);
  }
  /*clear $ErrMsg array*/
  unset($ErrMsg);
}
