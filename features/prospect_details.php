<?php

if (isset($_GET['message_id'])) {
  $hash =  getMessage('message_id', $_GET['message_id'], 'message_hash');
}
?>



<div class="container">
  <div class="row">
    <div class="row gutters-sm">
      <div class="col-md-4 mb-0">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="assets/img/avatars/user_blank.png" alt="User Default Profile" class="rounded-circle" width="150">
              <div class="mt-3">
                <h4><?php echo htmlentities(getProspectData($hash, 'prospect_full_name')); ?></h4>
                <p class="text-secondary mb-1"><?php echo htmlentities(getProspectData($hash, 'prospect_job_title')); ?></p>
                <p class="text-muted font-size-sm"><?php echo htmlentities(getProspectData($hash, 'prospect_cob')); ?></p>
              </div>
            </div>
            <hr>
            <div class="d-flex flex-column align-items-center text-center">
              <div class="mt-3">
                <p class="text-secondary mb-1">
                  <a href="prospect_area.php?key=<?php echo $hash; ?>" target="_blank">View Application Area</a>
                </p>
              </div>
            </div>
            <hr>
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                ID
                <span class="text-secondary"><a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_id'); ?>" download><?php if (getProspectData($hash, 'prospect_attach_id') != null) echo '<i class="fa fa-cloud-download"></i>'; ?></a></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                Proof of Payment 1
                <span class="text-secondary"><a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_proofpayment1'); ?>" download><?php if (getProspectData($hash, 'prospect_attach_proofpayment1') != null) echo '<i class="fa fa-cloud-download"></i>'; ?></a></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                Proof of Payment 2
                <span class="text-secondary"><a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_proofpayment2'); ?>" download><?php if (getProspectData($hash, 'prospect_attach_proofpayment2') != null) echo '<i class="fa fa-cloud-download"></i>'; ?></a></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                Proof of Payment 3
                <span class="text-secondary"><a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_proofpayment3'); ?>" download><?php if (getProspectData($hash, 'prospect_attach_proofpayment3') != null) echo '<i class="fa fa-cloud-download"></i>'; ?></a></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                Proof of Payment 4
                <span class="text-secondary"><a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_proofpayment4'); ?>" download><?php if (getProspectData($hash, 'prospect_attach_proofpayment4') != null) echo '<i class="fa fa-cloud-download"></i>'; ?></a></span>
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
                <?php echo htmlentities(getProspectData($hash, 'prospect_full_name')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Country of Birth</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_cob')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Date of Birth</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_dob')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Mobile</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_phone')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Expected Move-in Date</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_expectedMovein')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Sector</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_sector')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Employer</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_employer')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Job Title</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_job_title')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Net Income</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_income')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Total of Occupants</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_occupants')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Occupants over 18 years</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_occupants_over18')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Car Parking Requested</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_carpark')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Pet</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_pet')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Extra info</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_extra')); ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Submission Date</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?php echo htmlentities(getProspectData($hash, 'prospect_submission_date')); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>