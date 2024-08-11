<!-- modalDemo -->
<div class="modal fade" id="ModalChargingAdmin" tabindex="-1" aria-labelledby="ModalChargingAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" style="max-width: 550px; padding-top: 20px">  
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="h5 text-dark p-0 m-0">
                    {{ lang("headcharge") }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- ChargeAmount -->
            <div class="modal-body" v-if="ChargeAmount != null && ChargingIsInProcess != true">
                <div class="row my-4 fw-medium text-dark" v-if="ChargeAmount != null && ChargeAmount != 0">
                    <div v-if="CommissionIsValid">
                        <!-- increase -->
                        <div class="row" v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount > 0">
                            <div class="row">
                                <p class="h5 mb-4">
                                    {{ lang("increasebalance") }}
                                </p>
                            </div>
                        </div>
                        <!-- decrease -->
                        <div class="row" v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount < 0">
                            <div class="row">
                                <p class="h5 mb-4">
                                    {{ lang("decreasebalance") }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-1" style="width: 400px;">
                                <span class="input-group-text text-start p-0 m-0 px-3 fw-medium" style="--bs-bg-opacity: 0.1; width: 250px;" :class="ChargeBtnClass">
                                    <span>
                                        {{ lang('amounttochargereal') }}
                                    </span>
                                </span>
                                <input class="form-control text-start text-dark fw-medium" :value="new Intl.NumberFormat('en-US').format(ChargeAmount)" style="--bs-bg-opacity: 0.3; width: 110px;" disabled :class="ChargeBtnClass">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-1" style="width: 400px;">
                                <span class="input-group-text text-start p-0 m-0 px-3 fw-medium" style="--bs-bg-opacity: 0.1; width: 250px;" :class="ChargeBtnClass">
                                    <span>
                                        {{ lang('amounttochargewithcommission') }}
                                    </span>
                                </span>
                                <input class="form-control text-start text-dark fw-medium" :value="new Intl.NumberFormat('en-US').format(ChargeAmount * (1+(config?.Commission/100)))" style="--bs-bg-opacity: 0.3; width: 110px;" disabled :class="ChargeBtnClass">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="row my-5 fw-medium text-dark">
                    <p class="fs-5">
                        {{ lang("It is not valid number") }}
                    </p>
                </div>
            </div>
            
            <div class="modal-body" v-if="ChargingIsInProcess == true">
                <div class="">
                    <div class="my-5 fw-medium h5 text-dark">
                        <p class="text-primary" v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount > 0">
                            <span class="">
                                {{ lang("ChargingUserFor") }} ({{ ChargeAmount * (1+(config.Commission/100)) }} {{ lang('euro') }})
                            </span>
                            <span class="m-0 p-0 ps-2">
                                <?php include('./includes/baselayout/threespinner.php'); ?>
                            </span> 
                        </p>
                        <p class="text-danger" v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount < 0">
                            <span class="">
                                {{ lang("DeChargingUserFor") }} ({{ ChargeAmount * (1+(config.Commission/100)) }} {{ lang('euro') }})
                            </span>
                            <span class="m-0 p-0 ps-2">
                                <?php include('./includes/baselayout/threespinner.php'); ?>
                            </span> 
                        </p>
                    </div>
                </div>
            </div>

            <!-- Succeed -->
            <div class="modal-body" v-if="ChargingResponse?.data != null">
                <div class="">
                    <div class="my-5 fw-medium text-dark">
                        <p class="alert alert-success py-2">
                            {{ lang("Charge action has done Successfully") }}
                        </p>
                        <p class="alert alert-primary py-2">
                            {{ lang("willtake") }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- failed -->
            <div class="modal-body" v-if="ChargingResponse?.message != null">
                <div class="">
                    <div class="my-5 fw-medium">
                        <p class="alert alert-danger py-2">
                            <span>
                                {{ lang("error") }}
                            </span>
                            <span>
                                 : 
                            </span>
                            <span>
                                {{ ChargingResponse?.message }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="d-flex flex-column justify-content-end align-items-center">
                    <div class="m-0 p-0 mx-2">
                        <button type="button" class="btn btn-secondary px-4 border-0" data-bs-dismiss="modal" :disabled="ChargingIsInProcess">
                            {{ lang("close") }}
                        </button>
                        <button v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount > 0" class="btn px-4 ms-2 border-0" @click="IncreaseChargeCaasify" :disabled="ChargingIsInProcess" :class="ChargeBtnClass" style="--bs-bg-opacity: 0.2;">
                            {{ lang("doTransaction") }} 
                        </button>
                        <button v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount < 0" class="btn px-4 ms-2 border-0" @click="DecreaseChargeCaasify" :disabled="ChargingIsInProcess" :class="ChargeBtnClass" style="--bs-bg-opacity: 0.2;">
                            {{ lang("doTransaction") }}
                            
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->

