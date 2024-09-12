<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('config.php');   ?>
<?php  include_once('./includes/baselayout/header.php');   ?>
<body class="container-fluid m-0 p-0" style="background-color: #ff000000 !important;">
    <div class="bg-light rounded-2 border border-body-secondary px-0 px-md-4 py-2" style="min-height: 300px;">
        <div class="adminapp col-12" v-cloak>
            <?php  include_once('./includes/baselayout/modaladmincharging.php');   ?>
            <p class="alert alert-danger" v-if="config?.errorMessage"> {{ config?.errorMessage }}</p>
            <div class="m-0 p-0" v-cloak>
                <div class="row">
                    <div class="col-12">
                        <div class="row m-0 p-0" v-if="CommissionIsValid" style="max-height: 260px; overflow: scroll;">
                            <!-- Col01 -->
                            <div class="col-12 col-md-5 mt-lg-0">      
                                <!-- User Finance -->
                                <div class="row">
                                    <div class="row" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded && config?.Commission != null">
                                        <div class="m-0 p-0 px-1">
                                            <div class="input-group mt-2">
                                                <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-2" style="width: 230px;">
                                                    {{ lang('UserBalanceReal') }}
                                                </span>
                                                <input class="form-control bg-white text-start" 
                                                    style="max-width: 80px;" disabled
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    data-bs-custom-class="debt-tooltip"
                                                    :value="Number(CaasifyUserInfo?.balance - CaasifyUserInfo?.debt).toFixed(2)" 
                                                    :data-bs-title="'Debt : €' + Number(CaasifyUserInfo?.debt).toFixed(2)" 
                                                >
                                            </div>
                                            <div class="input-group my-1">
                                                <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-2" style="width: 230px;">
                                                    {{ lang('UserBalanceWithCommission') }}
                                                </span>
                                                <input class="form-control bg-white text-start" 
                                                    style="max-width: 80px;" disabled
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    data-bs-custom-class="debt-commission-tooltip"
                                                    :value="Number((CaasifyUserInfo?.balance - CaasifyUserInfo?.debt)*(1+(config?.Commission/100))).toFixed(2)" 
                                                    :data-bs-title="'Debt : €' + Number((CaasifyUserInfo?.debt)*(1+(config?.Commission/100))).toFixed(2)" 
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- loading -->
                                    <div v-if="UserInfoIsLoaded == false" class="row">
                                        <div class="text-primary fw-medium fs-5 ms-2">
                                            <span class="">
                                                {{ lang("loadingmsg") }}
                                            </span>
                                            <span class="m-0 p-0 ps-2">
                                                <?php include('./includes/baselayout/threespinner.php'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Charging -->
                                <div class="row mt-5" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded && config?.Commission != null">
                                    <div class="row">
                                        <div class="m-0 p-0 px-1">
                                            <div class="input-group my-2">
                                                <span class="input-group-text text-start p-0 m-0 px-2 fw-medium" style="--bs-bg-opacity: 0.1; width: 230px;" :class="ChargeBtnClass">
                                                    {{ lang('amounttochargereal') }}    
                                                </span>
                                                <input class="form-control bg-light text-start text-dark fw-medium" v-model="ChargeAmount" style="max-width: 80px;">
                                            </div>
                                            <div class="input-group my-2">
                                                <span class="input-group-text text-start p-0 m-0 px-2 fw-medium" style="--bs-bg-opacity: 0.1; width: 230px;" :class="ChargeBtnClass">
                                                    {{ lang('amounttochargewithcommission') }}    
                                                </span>
                                                <input class="form-control text-start text-dark fw-medium" :value="new Intl.NumberFormat('en-US').format(ChargeAmount * (1+(config?.Commission/100)))" style="--bs-bg-opacity: 0.3; max-width: 80px;" disabled :class="ChargeBtnClass">
                                            </div>
                                            <div v-if="ChargeAmount != null" class="d-flex flex-row">
                                                <button class="col-12 btn bg-primary text-dark px-4 fw-medium mt-3" style="--bs-bg-opacity: 0.4; max-width:310px;" @click="openChargingDialogue" v-if="ChargeAmount > 0">
                                                    <span>
                                                        {{ lang('Increase User Balance') }}
                                                    </span>
                                                </button>
                                                <button class="col-12 btn bg-danger text-dark px-4 fw-medium mt-3" style="--bs-bg-opacity: 0.4; max-width:310px;" @click="openChargingDialogue" v-if="ChargeAmount < 0">
                                                    <span>
                                                        {{ lang('Decrease User Balance') }}
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-2 my-4 d-block d-md-none" v-if="CommissionIsValid && UserInfoIsLoaded && ResellerInfoIsLoaded">
                            </div>
                            <!-- Col02 -->
                            <div class="col-12 col-md-7 mt-lg-0 px-4 px-md-0">            
                                <!-- Orders -->
                                 <div class="row mt-2 justify-content-center">
                                    <div v-if="UserOrdersIsLoaded && UserOrders != null" class="row border rounded-2 bg-white p-3">
                                        <table class="table table-borderless pb-5 mb-5" style="--bs-table-bg: #ff000000;">
                                            <thead>
                                                <tr class="border-bottom text-center"
                                                    style="--bs-border-width: 2px !important; --bs-border-color: #e1e1e1 !important;">
                                                    <th scope="col" class="fw-light fs-6 text-secondary pb-3">
                                                        {{ lang("ID") }}
                                                    </th>
                                                    <th scope="col" class="fw-light fs-6 text-secondary pb-3">
                                                        {{ lang("name") }}
                                                    </th>
                                                    <th scope="col" class="fw-light fs-6 text-secondary pb-3">
                                                        {{ lang("Alive") }}
                                                    </th>
                                                    <th scope="col" class="fw-light fs-6 text-secondary pb-3 d-none d-md-block">
                                                        {{ lang("Price") }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="(order, index) in UserOrders" :key="index">
                                                
                                                <tr class="border-bottom align-middle text-center" style="--bs-border-width: 1px !important; --bs-border-color: #e1e1e1 !important;">
                                                    <!-- ID -->
                                                    <td class="fw-medium">
                                                        <span v-if="order.id" class="text-dark fs-6 fw-medium">{{ order.id }}</span>
                                                        <span v-else class="text-dark fs-6 fw-medium"> --- </span>
                                                    </td>

                                                    <!-- Name -->
                                                    <td class="fw-medium">
                                                        <span v-if="order.note" class="text-dark fs-6 fw-medium">{{ order.note }}</span>
                                                        <span v-else class="text-dark fs-6 fw-medium"> --- </span>
                                                    </td>

                                                    <!-- Uptime -->
                                                    <td class="fw-medium">
                                                        <span v-if="order?.created_at" class="ms-2">
                                                            {{ order?.created_at }} 
                                                        </span>
                                                        <span v-else class="fw-medium"> --- </span>
                                                    </td>

                                                    <!-- record -->
                                                    <td class="fw-medium d-none d-md-block py-3">
                                                        <span v-for="record in order.records" class="m-0 p-0">
                                                            <span v-if="record.price" class="ms-2 text-primary">
                                                                <span>
                                                                    <span>
                                                                        {{ Number(addCommision(record.price)).toFixed(2) }}
                                                                    </span>
                                                                    <span>
                                                                        {{ lang('euro') }}
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span v-else class="fw-medium"> --- </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Alert -->
                                    <div v-if="UserOrdersIsLoaded && UserOrders == null" class="row">
                                        <div class="alert alert-primary small py-2">
                                            {{ lang("User has no active order") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="border-2 my-3" v-if="CommissionIsValid && UserInfoIsLoaded && ResellerInfoIsLoaded">
                        <!-- Admin Balance -->
                        <div class="row m-0 p-0" v-if="CommissionIsValid">
                            <div class="d-flex flex-row flex-wrap" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded">
                                <div class="m-0 p-0 me-2">
                                    <div class="input-group my-1">
                                        <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="min-width: 140px;">
                                        {{ lang('AdminBalance') }}
                                        </span>
                                        <input class="form-control bg-white text-start" :value="Number(CaasifyResellerInfo?.balance).toFixed(2)" disabled style="max-width: 150px;">
                                    </div>
                                </div>
                                <div class="m-0 p-0 me-2">
                                    <div class="input-group my-1">
                                        <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="min-width: 140px;">
                                            {{ lang('Commission') }}
                                            <span class="px-1">%</span>
                                        </span>
                                        <input class="form-control bg-white text-start" :value="config?.Commission" disabled style="max-width: 150px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <p class="h5 p-4 alert alert-danger">
                                Error 670: Commission is not valid, enter a valid value (ENGLISH Number) in WHMCS Setting -> Addons
                            </p>
                        </div>
                    </div><!-- User Details -->
                </div>
            </div>
        </div>
    </div>

<?php include_once('./includes/baselayout/footer.php'); ?>