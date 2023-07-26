<?php
$dir = "data/jobposts";
$fileDir = "$dir/jobs.txt";
/*set directory*/
?>

<?php

function cleanTextField($paragraph)
{
  $paragraph = preg_replace('/\s\s+/', '\n', $paragraph);
  $paragraph = "\"$paragraph\"";
  //clean text field
  return $paragraph;
}
function cleanInput($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  //clean input
}
/*Check if ID is same*/
function isPosIDExist($data, $fileDir)
{
  $openFile = fopen($fileDir, "r");

  while (!feof($openFile)) {
    /*get position id start at pos: 0 and search to 5 characters long*/
    $eachPostID = substr(fgets($openFile), 0, 5);
    if ($eachPostID === $data) {
      return true;
    }
  }
  fclose($openFile);
  return false;
}



/*Display Error message*/
function displayErrMessage($ErrMsg)
{
  $dataAmount = count($ErrMsg);
  // Split $ErrMsg into 2 seperate array
  $fieldName = array();
  $reason = array();
  $data = "";

  //*Field name
  for ($i = 0; $i < $dataAmount; $i += 2) {
    array_push($fieldName, $ErrMsg[$i]);
  }

  //*Reason
  for ($i = 1; $i < $dataAmount; $i += 2) {
    array_push($reason, $ErrMsg[$i]);
  }

  /* Error code in Html Format */
  for ($i = 0; $i < count($reason); $i++) {
    $data .= "
      <li>
        <p><strong>" . $fieldName[$i] . ":</strong></p>
        <ul><li><p><em>" . $reason[$i] . ".</em></p></li></ul>
      </li>";
  }

  $displayError = "<nav class='ErrorBox'>
    <h3><strong>Cannot procces request.</strong></h3>
      <h4><em>The following need to changed:</em></h4>
        <ul>
          " . $data . "
        </ul>
      </nav>";
  return $displayError;
}

/*Function sort-array-dates-php */
function sortDate($date1, $date2)
{
  echo "UNIX:<br/>";
  echo "DeadLine: $date1<br/>Date Now: $date2<br/><br/>";
  echo "DeadLine: " . strtotime(str_replace('/', '-', $date1)) . "<br/>Date Now:" . strtotime(str_replace('/', '-', $date2)) . "<hr>";
  /*convert date to unix timestamp, compare it*/
  if (strtotime(str_replace('/', '-', $date1)) < strtotime(str_replace('/', '-', $date2))) {
    return false;
  } elseif (strtotime(str_replace('/', '-', $date1)) > strtotime(str_replace('/', '-', $date2))) {
    return true;
  }
}

function temp_sortDate($deadLine, $currDate)
{
  $arrDeadLine = explode("/", $deadLine);
  $arrcurrDate = explode("/", $currDate);

  if ($arrcurrDate[0] > $arrDeadLine[0]) {
    return false;
  } else {
    return true;
  }
}


/*Display Job Vacancy at searchjobprocess.php*/
function displayJobVacancy($findString, $fileDir, $regex)
{
  /*
  Convert input to lower case, then capitalized the
  first letter for each word
  */
  $currentDate = date("d/m/y");
  $findString = ucwords(strtolower(cleanInput($findString)));
  $eachLineData = "";
  $handle = fopen($fileDir, "r");

  if (is_readable($fileDir)) {
    while (!feof($handle)) {
      /*make List with the following var*/
      /*set the last line on file with value null*/
      $listData = list($posID, $jobTitle, $jobDesc, $jobClosingDate, $jobPosition, $jobContract, $jobAcceptBy, $jobLocation) = array_pad(explode("\t", fgets($handle)), 8, null);

      /*check current time with $jobClosingDate*/
      if (temp_sortDate($jobClosingDate, $currentDate)) {
        /* put $listData as 'an array' and loop through each list */
        if ($findString != "") {
          foreach ($listData as $data) {
            /*
            if regex matches with $data from the List
            then check the actual string with it's own matching type 
            */
            if (preg_match($regex, $data)) {
              /*used '(?i) to ignore case sensitive'*/
              if (preg_match("/(?i)$findString/", $data)) {
                $eachLineData .= "
                  <nav class=\"result\">
                  <p class=\"title\"><strong>" . $jobTitle . "</strong></p>
                  <p><strong> Description: </strong>" . $jobDesc . "</p>
                  <p><strong> Closing Date: </strong>" . $jobClosingDate . "</p>
                  <p><strong> Position: </strong>" . $jobPosition . "</p>
                  <p><strong> Contract: </strong>" . $jobContract . "</p>
                  <p><strong> Apply by: </strong>" . $jobAcceptBy . "</p>
                  <p><strong> Location: </strong>" . $jobLocation . "</p>
                  </nav>
                  <hr>";
              }
            }
          }
        } elseif ($findString == "") {
          /*
          check if $posID is not EMPTY. Or print all
          the data except the new empty line
          */
          if ($posID != null) {
            $eachLineData .= "
            <nav class=\"result\">
            <p class=\"title\"><strong>" . $jobTitle . "</strong></p>
            <p><strong> Description: </strong>" . $jobDesc . "</p>
            <p><strong> Closing Date: </strong>" . $jobClosingDate . "</p>
            <p><strong> Position: </strong>" . $jobPosition . "</p>
            <p><strong> Contract: </strong>" . $jobContract . "</p>
            <p><strong> Apply by: </strong>" . $jobAcceptBy . "</p>
            <p><strong> Location: </strong>" . $jobLocation . "</p>
            </nav>
            <hr>";
          }
        }
      }
    }
    fclose($handle);
  }
  /*if $eachLineData is not empty, Give out the result.*/
  if ($eachLineData != "") {
    $headingTitle = "<h3><strong>We found the following result in our database:</strong></h3>";
  } else {
    /*Else display the following warning message*/
    $headingTitle = "<h3><strong>Unfortunately, We cannot found any result in our database.</strong></h3>";
    $eachLineData = "<p>Please try checking your spelling, or there is no available Job in this criteria.</p>";
  }
  return $headingTitle . $eachLineData;
}
