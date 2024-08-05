<!-- create machine modal -->
<div class="modal fade modal-lg" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="actionModalLabel" aria-hidden="false" ref="myModal">
    <div class="modal-dialog modal-dialog-top" style="max-width: 800px !important; padding-top: 150px">
        <div class="modal-content border-0" :class="CreateIsLoading ? 'text-secondary' : 'text-dark'">
            <!-- Modal Body -->
            <div class="m-0 p-0">
                <div class="modal-body px-0 px-md-3" style="min-height: 350px !important;" id="CreateModalTop">
                    <div class="row m-0 p-0 pt-5">
                        <div class="col-12 text-start lh-lg pb-3">

                            <!-- Just Open window, Ready to order -->
                            <div v-if="!userClickedCreationBtn">

                                <!-- enough data to push btn -->
                                <div
                                    v-if="themachinename && SelectedRegion && SelectedPlan && PlanConfigSelectedOptions">
                                    <p class="h5 fw-Medium">{{ lang('youarecreating') }}</p>
                                    <p class="fs-6 fw-light mt-3">{{ lang('makesure') }}</p>
                                </div>

                                <!-- Table of parameters -->
                                <div class="px-4 px-lg-5 py-5 rounded-4 bg-primary" style="--bs-bg-opacity: 0.15;">
                                    <table class="table table-borderless m-0 p-0 my-5" style="--bs-table-bg: #fff0;">
                                        <tbody>

                                            <!-- HostName -->
                                            <tr>
                                                <td class="m-0 p-0">
                                                    <i v-if="themachinename" class="bi bi-check-circle-fill me-1"></i>
                                                    <i v-if="!themachinename" class="bi bi-circle me-1"></i>
                                                    <span>{{ lang('name') }}</span>
                                                    <span class="px-1">:</span>
                                                </td>
                                                <td class="text-primary fw-medium m-0 p-0">
                                                    <span v-if="themachinename"
                                                        class="m-0 p-0">{{ themachinename }}</span>
                                                    <span v-else-if="!themachinename">
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- Datacenter -->
                                            <tr v-if="SelectedRegion && SelectedDataCenter">
                                                <td class="m-0 p-0">
                                                    <i v-if="SelectedRegion?.name && SelectedDataCenter?.name"
                                                        class="bi bi-check-circle-fill me-1"></i>
                                                    <i v-if="!SelectedRegion?.name || !SelectedDataCenter?.name"
                                                        class="bi bi-circle me-1"></i>
                                                    <span>{{ lang('datacenter') }}</span>
                                                </td>
                                                <td class="text-primary fw-medium m-0 p-0">
                                                    <span v-if="SelectedDataCenter?.name"
                                                        class="m-0 p-0 pe-2">{{ SelectedDataCenter?.name }}</span>
                                                    <span v-else-if="!SelectedDataCenter?.name">
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>

                                                    <span v-if="SelectedRegion?.name"
                                                        class="m-0 p-0">({{ SelectedRegion?.name }})</span>
                                                    <span v-else-if="!SelectedRegion?.name">
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <!-- Extra Traffic Cost -->
                                            <tr v-if="SelectedPlan">
                                                <td class="m-0 p-0">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    <span>
                                                        {{ lang('tabeltraffic') }}
                                                    </span>
                                                </td>
                                                <td class="text-primary fw-medium m-0 p-0">
                                                    <span v-if="SelectedPlan?.traffic_price" class="m-0 p-0 pe-2">
                                                        <span>
                                                            {{ showTrafficPriceInWhmcsUint(SelectedPlan?.traffic_price) }}
                                                        </span>
                                                        <span class="px-1">
                                                            {{ userCurrencySymbolFromWhmcs }}/{{ lang('gb') }}
                                                        </span>
                                                    </span>
                                                    <span v-else class="m-0 p-0 pe-2">
                                                        ...
                                                    </span>
                                                </td>
                                            </tr>

                                            
                                            <!-- Section Configs -->
                                            <tr v-if="PlanConfigSelectedOptions"
                                                v-for="(value, key) in PlanConfigSelectedOptions">
                                                <td class="m-0 p-0">
                                                    <i v-if="key" class="bi bi-check-circle-fill me-1"></i>
                                                    <i v-else class="bi bi-circle me-1"></i>
                                                    <span>
                                                        {{ key }}:
                                                    </span>
                                                </td>
                                                <td class="text-primary fw-medium m-0 p-0">
                                                    <div v-if="value?.value">
                                                        <span class="m-0 p-0">
                                                            {{ value.name }}
                                                        </span>
                                                    </div>
                                                    <div v-else-if="value?.options">
                                                        <span v-if="value.options != ''" class="m-0 p-0">
                                                            {{ value.options }}
                                                        </span>
                                                        <span v-else class="m-0 p-0">
                                                            <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                        </span>
                                                    </div>
                                                    <span v-else>
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <hr>

                                    <!-- Total Price -->
                                    <div v-if="TotalMachinePrice" class="float-end text-primary fw-medium">
                                        <p>
                                            <span>
                                                {{ lang('totalcost') }}
                                            </span>
                                            <span class="px-1">
                                                :
                                            </span>
                                            {{ formatTotalMachinePrice(TotalMachinePrice) }} {{ userCurrencySymbolFromWhmcs }}
                                            <span class="px-1">
                                                /{{ lang('monthly') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <!-- not enough data -->
                                <div v-if="!themachinename || !SelectedRegion || !SelectedPlan"
                                    class="row m-0 p-0 mt-5">
                                    <p class="alert alert-danger py-1">
                                        <span>
                                            {{ lang('Warning') }}
                                        </span>
                                        <span>
                                            : 
                                        </span>
                                        <span>
                                            {{ lang('notprovideallinformation') }}
                                        </span>
                                    </p>
                                </div>

                                <!-- Low Balance -->
                                <div class="" v-if="user?.balance && CaasifyConfigs?.MinBalanceAllowToCreate" >
                                    <div v-if="user.balance < CaasifyConfigs?.MinBalanceAllowToCreate" class="d-flex flex-row justify-content-between align-items-center mt-5">
                                        <div class="flex-grow-1 me-4">
                                            <p class="alert alert-warning text-start m-0 p-0 px-3 py-1">
                                                {{ lang('balanceisnotenough') }}
                                            </p>
                                        </div>
                                        <div>
                                            <a class="btn btn-outline-secondary float-end py-2 btn-sm"
                                                href="<?php echo($systemUrl . '/index.php?m=caasify&action=pageIndex'); ?>"
                                                target='_top'
                                            >
                                            {{ lang('movebalance') }}
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Btn Pressed [two case: 1-succed or failed] -->
                            <div v-if="userClickedCreationBtn" class="col-12 text-start lh-lg pb-3">
                                <!-- 1 (succed, reload, open list) -->
                                <div v-if="createActionSucced" class="m-0 p-0">
                                    <div class="row m-0 p-0 px-3">
                                        <p class="fs-5 fw-Medium text-primary p-0 m-0">
                                            {{ lang('machinecreatesuccessfully') }}
                                        </p>
                                        <p class="fs-6 fw-Medium text-dark p-0 m-0 pb-5">
                                            {{ lang('createsuccessmsg') }}
                                        </p>
                                    </div>
                                    <div v-if="newMachineCreated == null || NewMcahineCreatedViewLink == null" class="row d-flex flex-row justify-content-end p-0 m-0">
                                        <a class="col-auto btn btn-primary px-4 py-2"
                                            href="<?php echo($systemUrl . '/index.php?m=caasify&action=pageIndex'); ?>"
                                            target='_top'>{{ lang('Machine View') }}</a>
                                    </div>
                                    <div v-else class="row d-flex flex-row justify-content-end p-0 m-0">
                                        <a class="col-auto btn btn-primary px-4 py-2"
                                            :href="NewMcahineCreatedViewLink"
                                            target='_top'>{{ lang('Machine View') }}</a>
                                    </div>
                                </div>

                                <!-- 2 (failed, reload, do again) -->
                                <div v-if="createActionFailed" class="m-0 p-0">
                                    <div class="row m-0 p-0 px-3">
                                        <p class="fs-5 fw-Medium text-dark p-0 m-0">
                                            {{ lang('createmachinefailed') }}
                                        </p>
                                        <p v-if="CreateMSG != null" class="text-danger p-0 m-0 mt-5 h5">
                                            {{ CreateMSG }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="!userClickedCreationBtn" class="row m-0 p-0 px-3 py-3">
                        <div class="py-4 rounded-4 bg-primary" style="--bs-bg-opacity: 0.15;">
                            <div class="form-check form-switch d-flex flex-row justify-content-start align-items-center px-0 px-md-3">
                                <input v-model="checkboxconfirmation" class="form-check-input ms-2 fs-5" type="checkbox"
                                    role="switch" id="checkboxconfirmation" :disabled="CreateIsLoading">
                                <label class="form-check-label ms-3" :class="CreateIsLoading ? 'text-secondary' : 'text-dark'" for="checkboxconfirmation">
                                    {{ lang('confirmationtext') }}
                                </label>
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
                            {{ formatUserBalance(user.balance) }} {{ userCurrencySymbolFromWhmcs }}
                        </span>
                        <span v-else>
                            <?php include('./includes/baselayout/threespinner.php'); ?>
                        </span>
                    </span>
                    <span v-else class="text-primary fw-medium"> --- </span>
                </div>

                <!-- BTN's -->
                <div class="d-flex flex-row">
                    <!-- Close BTN ( two typ: 1-[normal close] , 2-[close+relaod] )-->

                    <!-- 1- Normal close, before click -->
                    <div v-if="!userClickedCreationBtn" class="m-0 p-0">
                        <button @click="closeConfirmDialog" type="button" class="btn btn-secondary px-4 mx-2 border-0"
                            style="background-color: #515151" data-bs-dismiss="modal" :disabled="CreateIsLoading">
                            <div>
                                {{ lang('close') }}
                            </div>
                        </button>
                    </div>

                    <!-- 2- CloseReload, after click [Close + Reload = make another machine] -->
                    <div v-if="userClickedCreationBtn && createActionSucced" class="m-0 p-0">
                        <a @click="reloadpage" type="button" class="btn btn-secondary px-4 mx-2 border-0"
                            style="background-color: #515151" data-bs-dismiss="modal" :disabled="CreateIsLoading">
                            <div>
                                {{ lang('createanothermachine') }}
                            </div>
                        </a>
                    </div>
                    
                    <div v-if="userClickedCreationBtn && createActionFailed" class="m-0 p-0">
                        <a @click="reloadpage" type="button" class="btn btn-secondary px-4 mx-2 border-0"
                            style="background-color: #515151" data-bs-dismiss="modal" :disabled="CreateIsLoading">
                            <div>
                                {{ lang('close') }}
                            </div>
                        </a>
                    </div>

                    <?php 
                        $DemoMode == 'off' ;
                    ?>
                    <!-- Create BTN -->
                    <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                        <div v-if="!userClickedCreationBtn">
                            <div class="m-0 p-0" v-if="themachinename && SelectedRegion && SelectedPlan && TotalMachinePrice != null">
                                <button v-if="checkboxconfirmation" @click="RunDemoModal" type="button" class="btn btn-primary px-5 mx-2">
                                    <span>{{ lang('Create Machine') }}</span>
                                    <div v-if="CreateIsLoading" class="spinner-border spinner-border-sm text-light small p-0 m-0 ms-3" role="status"></div>
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        <div v-if="!userClickedCreationBtn">
                            <div class="m-0 p-0" v-if="themachinename && SelectedRegion && SelectedPlan && TotalMachinePrice != null">
                                <button v-if="checkboxconfirmation" @click="acceptConfirmDialog" type="button" class="btn btn-primary px-5 mx-2" :disabled="CreateIsLoading">
                                    <span>{{ lang('Create Machine') }}</span>
                                    <div v-if="CreateIsLoading" class="spinner-border spinner-border-sm text-light small p-0 m-0 ms-3" role="status"></div>
                                </button>
                            </div>
                        </div>
                    <?php endif ?>


                    <!-- try again, (force reload) -->
                    <div v-if="userClickedCreationBtn && createActionFailed" class="m-0 p-0">
                        <div class="m-0 p-0">
                            <button @click="reloadpage" type="button" class="btn btn-primary px-5 mx-2"
                                data-bs-dismiss="modal" :disabled="CreateIsLoading">
                                <span>{{ lang('tryagain') }}</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->