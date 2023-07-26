<?php
include("systems/functions.php");


if (isset($_GET['submit'])) {
  $jobTitle = cleanInput($_GET['findJob']);
  $searchJobLocation = $_GET['searchJobLocation'];
  $ErrMsg = array();

  // check RegExp
  if (!$jobTitle == "") {
    if (!preg_match("/(\w[\s,\.\!]*){1,20}/", $jobTitle)) {
      if (strlen($jobTitle) > 21) {
        array_push($ErrMsg, "Job Title", "Characters limit reach. Ensure that title is no more than 20 characters long");
      } else {
        array_push($ErrMsg, "Title", "Only '.'(fullstop), ','(coma) and '!'(exclaimation mark) are allowed");
      }
    }
  }
  // Error checking
  if (!file_exists($fileDir)) {
    array_push($ErrMsg, "404 - File not found", "File does not exist. Please Create a job application first.");
  }
  if ($ErrMsg != array()) {
    include("style/header.php");
    echo displayErrMessage($ErrMsg);
    include("style/footer.php");
  } else {
    include("style/header.php");

    /* Change value in searchJobPosition to string */

    if ($jobTitle) {
      echo "<p class='notice'>Result for: <strong>$jobTitle</strong></p>";
      echo displayJobVacancy($jobTitle, $fileDir, "/$jobTitle/");
    } else {
      echo "<p class='notice'><strong>Showing all result</strong></p>";
      echo displayJobVacancy("", $fileDir, "");
    }
    echo "<a class='button' href='searchjobform.php'>Back</a>";

    if (isset($_GET['searchJobPosition'])) {
      $searchJobPosition = implode($_GET['searchJobPosition']);
      echo "<p class='notice'>Result for: <strong>$searchJobPosition</strong></p>";
      echo displayJobVacancy($searchJobPosition, $fileDir, "/(\w{4}-\w{4})/");
    }

    if (isset($_GET['searchJobContract'])) {
      $searchJobContract = implode($_GET['searchJobContract']);
      echo "<p class='notice'>Result for: <strong>$searchJobContract</strong></p>";
      echo displayJobVacancy($searchJobContract, $fileDir, "/(On-going|Fixedterm)/");
    }

    if (isset($_GET['searchJobApplication'])) {
      $searchJobApplication = implode($_GET['searchJobApplication']);
      echo "<p class='notice'>Result for: <strong>$searchJobApplication</strong></p>";
      echo displayJobVacancy($searchJobApplication, $fileDir, "/(Mail|Post)/");
    }

    if ($searchJobLocation) {
      echo "<p class='notice'>Result for: <strong>$searchJobLocation</strong></p>";
      echo displayJobVacancy($searchJobLocation, $fileDir, "/$searchJobLocation/");
    }

    include("style/footer.php");
  }
}
