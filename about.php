<?php include("style/header.php");


echo "
    <h2>About This Assignment</h2>
    <nav class='display'>
    <p><strong>PHP Version: </strong><em>" . phpversion() . "</em></p>
    <br/>
    <p><strong>Task that are not attempted or completed?</strong></p>
      <ul>
        <li>Task 8 - Sort by date: Display only those job vacancies that had not closed as of today 
        </li>
      </ul>
      <br/>
    <p><strong>Special Features:</strong></p>
      <ul>
        <li>Auto capitalised search result.</li>
        <li>Recycle functions and error handling using 'functions.php' .</li>
        <li>have header and footer for code reduction</li>
        <li>Auto changing navigation button depends on which site currently active</li>
      </ul>
      <br/>
    <p><strong>What discussion points did you participated on in the unit’s discussion board for Assignment 1?</strong></p>
      <ul>
        <li>I've not visited discussion board, because it is useless</li>
      </ul>
      <br/>
    </nav>
";

include("style/footer.php");
