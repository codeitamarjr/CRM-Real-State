<?php
// Include config file
require "config/config.php";

if (isset($_GET['key'])) {
  $hash = $_GET['key'];
}


//select all data from the mail_income sql
$query = "SELECT * FROM prospect WHERE hash = '$hash'";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_array($result)) {
  //Creates a loop to loop through results
  $name = $row['prospect_full_name'];
  $prospect_cob = $row['prospect_cob'];
  $prospect_dob = $row['prospect_dob'];
  $prospect_phone = $row['prospect_phone'];
  $movein = $row['prospect_expectedMovein'];
  $prospect_sector = $row['prospect_sector'];
  $prospect_employer = $row['prospect_employer'];
  $prospect_job_title = $row['prospect_job_title'];
  $prospect_occupants = $row['prospect_occupants'];
  $prospect_occupants_over18 = $row['prospect_occupants_over18'];
  $prospect_extra = $row['prospect_extra'];
  $prospect_submission_date = $row['prospect_submission_date'];
  $prospect_attach_id = $row['prospect_attach_id'];
  $prospect_attach_proofpayment1 = $row['prospect_attach_proofpayment1'];
  $prospect_attach_proofpayment2 = $row['prospect_attach_proofpayment2'];
  $prospect_attach_proofpayment3 = $row['prospect_attach_proofpayment3'];
  $prospect_attach_proofpayment4 = $row['prospect_attach_proofpayment4'];
}
mysqli_close($link);
?>



<div class="container">
  <div class="main-body">
    <div class="row gutters-sm">
      <div class="col-md-4 mb-0">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="assets/img/avatars/user_blank.png" alt="User Default Profile" class="rounded-circle" width="150">
              <div class="mt-3">
                <h4><?php echo htmlentities($name); ?></h4>
                <p class="text-secondary mb-1"><?php echo htmlentities($prospect_job_title); ?></p>
                <p class="text-muted font-size-sm"><?php echo htmlentities($prospect_cob); ?></p>
              </div>
            </div>
            <hr>
            <div class="d-flex flex-column align-items-center text-center">
              <div class="mt-3">
                <p class="text-secondary mb-1">
                  <a href="prospect_area.php?key=<?php echo $hash; ?>" target="_blank">Personal Link</a>
                </p>
              </div>
            </div>
            <hr>
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                ID
                <span class="text-secondary"><a href="features/uploads/<?php echo $prospect_attach_id; ?>" download><?php if($prospect_attach_id != null) echo 'Download'; ?></a></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                Proof of Payment 1
                <span class="text-secondary"><a href="features/uploads/<?php echo $prospect_attach_proofpayment1; ?>" download><?php if($prospect_attach_proofpayment1 != null) echo 'Download'; ?></a></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                Proof of Payment 2
                <span class="text-secondary"><a href="features/uploads/<?php echo $prospect_attach_proofpayment2; ?>" download><?php if($prospect_attach_proofpayment2 != null) echo 'Download'; ?></a></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                Proof of Payment 3
                <span class="text-secondary"><a href="features/uploads/<?php echo $prospect_attach_proofpayment3; ?>" download><?php if($prospect_attach_proofpayment3 != null) echo 'Download'; ?></a></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                Proof of Payment 4
                <span class="text-secondary"><a href="features/uploads/<?php echo $prospect_attach_proofpayment4; ?>" download><?php if($prospect_attach_proofpayment4 != null) echo 'Download'; ?></a></span>
              </li>
            </ul>
    
          </div>
        </div>

      </div>
      <div class="col-md-8">
        <div class="card mb-0">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Full Name</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($name); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Country of Birth</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_cob); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Date of Birth</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_dob); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Mobile</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_phone); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Expected Move-in Date</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($movein); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Sector</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_sector); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Employer</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_employer); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Job Title</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_job_title); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Total of Occupants</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_occupants); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Occupants over 18 years</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_occupants_over18); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Extra info</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_extra); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Submission Date</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities($prospect_submission_date); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>