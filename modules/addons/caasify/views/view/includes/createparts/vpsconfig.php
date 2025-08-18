<?php
$verificationIsEnabled = caasify_get_email_verification_is_enabled();
$isVerified = caasify_get_client_email_is_verified();

if ($verificationIsEnabled && !$isVerified) {?>
<div class="modal-body">
    <div class="row text-center px-3 py-4 fs-6">
        <p class="m-0 p-0 h5">
            <span>
                {{ lang('To continue, please verify your email') }}
            </span>
        </p>
    </div>
    </div>
<?php } else {?>
<div class="m-0 p-0">
    <div class="modal-body px-0 px-md-3 py-5" id="ConfigModalTop">
        <div class="row m-0 p-0">
            <div class="col-12 px-4">
                <?php  include('./includes/createparts/hostname.php');  ?>
                <?php  include('./includes/createparts/configs.php');  ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal Footer -->
<div class="d-flex flex-row modal-footer justify-content-between">
    <!-- Balance -->
    <div class="m-0 p-0 mx-3">
        <span class="fw-medium me-2" :class="CreateIsLoading ? 'text-secondary' : 'text-dark'">
            {{ lang('cloudbalance') }} : 
        </span>
        <span v-if="user?.balance" class="fw-medium" :class="CreateIsLoading ? 'text-secondary' : 'text-primary'">
            <span v-if="CurrenciesRatioCloudToWhmcs != null">
                {{ formatUserBalance(user.balance - user.debt) }} {{ userCurrencySymbolFromWhmcs }}
            </span>
            <span v-else>
                <?php include('./includes/baselayout/threespinner.php'); ?>
            </span>
        </span>
        <span v-else class="text-primary fw-medium"> --- </span>
    </div>

    <!-- create Bbtn -->
    <div class="d-flex flex-row">
        <?php  include('./includes/createparts/createbtn.php');    ?>
    </div>
</div>
<?php }?>