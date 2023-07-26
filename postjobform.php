<?php
include("systems/functions.php");
$currentDate = date("d/m/y");
?>


<?php include("style/header.php"); ?>
<h2>Post a Job</h2>


<form method="POST" action="postjobprocess.php">
  <table>
    <tr>
      <td>
        <p>
          <label for="posID"><strong>Position ID:</strong></label><br />
          <input type="text" name="posID" id="posID" >
        </p>
        <p>
          <label for="jobTitle"><strong>Title:</strong></label><br />
          <input type="text" name="jobTitle" id="jobTitle">
        </p>
        <p>
          <label for="jobDescription"><strong>Description:</strong></label><br />
          <textarea name="jobDescription" id="jobDescription" rows="4" cols="25"></textarea>
        </p>
        <p>
          <label for="jobClosingDate"><strong>Closing Date:</strong></label><br />
          <input type="text" name="jobClosingDate" id="jobClosingDate" value="<?php echo $currentDate; ?>">
        </p>
      </td>
      <td>
        <p>
          <strong>Position: </strong><br />
          <input type="radio" id="fullTime" name="jobPosition" value="Full-time">
          <label for="fullTime">Full Time</label>
          <br />
          <input type="radio" id="partTime" name="jobPosition" value="Part-time">
          <label for="partTime">Part Time</label>
        </p>
        <p>
          <strong>Contract: </strong><br />
          <input type="radio" id="ongoing" name="jobContract" value="On-going">
          <label for="ongoing">On-going</label>
          <br />
          <input type="radio" id="fixedterm" name="jobContract" value="Fixedterm">
          <label for="fixedterm">Fixed Term</label>
        </p>
        <p>
          <strong>Accept Application by: </strong><br />
          <input type="checkbox" id="post" name="jobApplication[]" value="Post">
          <label for="post">Post</label>
          <br />
          <input type="checkbox" id="mail" name="jobApplication[]" value="Mail">
          <label for="mail">Mail</label>
        </p>
        <p>
          <label for="jobLocation"><strong>Location: </strong></label><br />
          <select name="jobLocation" id="jobLocation">
            <option value="">---</option>
            <option value="Australian Capital Territory">ACT</option>
            <option value="New South Wales">NSW</option>
            <option value="Northern Territory">NT</option>
            <option value="Queensland">QLD</option>
            <option value="South Australia">SA</option>
            <option value="Tasmania">TAS</option>
            <option value="Victoria">VIC</option>
            <option value="Western Australia">WA</option>
          </select>
        </p>
      </td>
    </tr>
  </table>
  <input type="submit" name="postForm" class="buttOn" value="Post">
  <input type="reset" name="resetForm" class="buttOn" value="Reset">
</form>
<?php include("style/footer.php"); ?>