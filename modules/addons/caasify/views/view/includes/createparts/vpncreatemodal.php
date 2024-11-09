<!-- vpncreatemodal -->
<!-- Modal Body -->
<div class="m-0 p-0">
    <div class="modal-body px-0 px-md-3 py-5">
        <div class="row m-0 p-0">
            <div class="col-12 px-4">
                <div class="col-12">
                    <p class="h5 pb-4">
                        You have selected 
                    </p>
                </div>
                <div class="col-12 bg-secondary w-100 border rounded-3 text-dark shadow-sm py-3 px-3 px-md-4 plans-childs btn my-1 position-relative" style="--bs-bg-opacity: 0.01;" >
                    <div class="row justify-content-between align-items-center flex-wrap">
                        <div class="col-12 col-md-6 py-3">
                            <span class="text-secondary">
                                {{ lang('Locations') }}
                            </span>
                            <br>
                            <span>
                                {{ lang('Germany, Netherland') }}
                            </span>
                        </div>
                        <div v-if="SelectedPlan?.traffic_limit" class="col-12 col-md-6 py-3">
                            <span class="text-secondary">
                                {{ lang('Free Traffic') }}
                            </span>
                            <br>
                            <span>
                                {{ SelectedPlan?.traffic_limit }} {{ lang('MB') }} {{ lang('monthly') }}
                            </span>
                        </div>
                        <div class="col-12 col-md-6 py-3">
                            <span class="text-secondary">
                                {{ lang('Duration') }}
                            </span>
                            <br>
                            <span>
                                {{ lang('Unlimited') }}
                            </span>
                        </div>
                        <div class="col-12 col-md-6 py-3">
                            <span class="text-secondary">
                                {{ lang('Traffic Price') }}
                            </span>
                            <br>
                            <span>
                                {{ formatTotalMachinePrice(SelectedPlan?.traffic_price) }} {{ userCurrencySymbolFromWhmcs }} /{{ lang('GB') }}
                            </span>
                        </div>
                    </div>
                </div>
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