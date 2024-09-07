<div class="row d-flex flex-row align-items-stretch text-start m-0 p-0">
    <!-- OrderDetails -->
    <div class="col-12 col-xl-6 p-0 m-0 mb-2 flex-grow-1 pe-xl-1">
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 me-xl-1 pb-5 h-100">
            <div class="m-0 p-0">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="">
                        <p class="text-secondary fs-5 m-0 p-0">
                            <img src="<?php echo($systemUrl); ?>/modules/addons/caasify/views/view/includes/assets/img/osicon.svg" width="18">
                            <span class="text-secondary m-0 p-0 ps-4">
                                {{ lang('Machine Info') }}
                            </span>
                        </p>
                    </div>
                    <!-- Datacenter and city -->
                     <div class="d-none d-md-block">
                        <div class="d-flex flex-row justify-content-end align-items-center flex-wrap pe-0" v-if="thisOrder?.records[thisOrder.records.length-1]?.product?.categories">
                            <div class="d-flex flex-row justify-content-start align-items-center bg-secondary rounded-3 py-2 ms-2 px-3 mb-1" v-for="item in thisOrder.records[thisOrder.records.length-1].product.categories" style="max-width: 180px; --bs-bg-opacity: 0.1;">
                                <img :src="showImage(item?.image)" alt="" style="height: 20px;" class="rounded-1">
                                <span class="text-secondary ps-2" v-if="item?.name">
                                    {{ item?.name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-group mt-5 mb-2">
                    <span class="input-group-text" id="basic-addon1" style="width: 100px;">
                        {{ lang('username') }}
                    </span>
                    <input type="text" class="form-control" value="root" disabled>
                </div>
                <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1" style="width: 100px;">
                        {{ lang('password') }}
                    </span>
                    <input v-if="!PassVisible" type="text" class="form-control" value="*********" disabled>
                    <?php if(isset($DemoMode) && $DemoMode == 'off' ): ?>
                        <input v-if="PassVisible" type="text" class="form-control" :value="thisOrder?.secret" disabled>
                    <?php else: ?>
                        <input v-if="PassVisible" type="text" class="form-control" value="Demo Value" disabled>
                    <?php endif ?>
                    <a class="input-group-text" id="basic-addon1" @click="ShowHidePassword">
                        <i v-if="PassVisible" class="bi bi-eye-fill"></i>
                        <i v-if="!PassVisible" class="bi bi-eye-slash-fill"></i>
                    </a>
                </div>
                <div class="m-0 p-0 pb-4 my-3">
                    <hr class="text-secondary border-2 border-secondary m-0 p-0">
                </div>
                <!-- bottom slice -->
                <div class="m-0 p-0 px-1">
                    <div class="m-0 p-0 mt-0">
                        <p class="text-secondary mb-4 fs-5">
                            <i class="bi bi-currency-exchange pe-4"></i>
                            {{ lang('finance') }}
                        </p>
                        <!-- Monthly Price -->
                        <div class="row m-0 p-0 align-items-center">
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    {{ lang('Product Price') }}
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-primary align-middle m-0 p-0 fw-medium" v-if="thisOrder?.records[thisOrder.records.length - 1].price && CurrenciesRatioCloudToWhmcs">
                                    <span v-if="CommissionIsValid">
                                        <span>
                                            {{ formatUserBalance(thisOrder.records[thisOrder.records.length - 1].price) }}
                                        </span>
                                        <span v-if="userCurrencySymbolFromWhmcs" class="ms-1">
                                            {{ userCurrencySymbolFromWhmcs }}/{{ lang('monthly') }}
                                        </span>
                                    </span>
                                    <span v-else>
                                        NAN
                                    </span>
                                </span>
                                <span v-if="userCurrencySymbolFromWhmcs" class="text-secondary align-middle m-0 p-0 fw-light ps-3">
                                    {{ lang('payasyougo') }}
                                </span>
                                <span class="text-secondary align-middle m-0 p-0 fw-medium" v-else>
                                    <span>
                                        ...
                                    </span>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Hourly Price -->
                        <div class="row m-0 p-0  align-items-center">
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-primary align-middle m-0 p-0 fw-medium" v-if="thisOrder?.records[thisOrder.records.length - 1].hourly_price && CurrenciesRatioCloudToWhmcs">
                                    <span v-if="CommissionIsValid">
                                        <span>
                                            {{ formatUserBalance(thisOrder.records[thisOrder.records.length - 1].hourly_price) }}
                                        </span>
                                        <span v-if="userCurrencySymbolFromWhmcs" class="ms-1">
                                            {{ userCurrencySymbolFromWhmcs }}/{{ lang('hourly') }}
                                        </span>
                                    </span>
                                    <span v-else>
                                        NAN
                                    </span>
                                </span>
                            </div>
                        </div>

                        <!-- Balance -->
                        <div class="row m-0 p-0 mt-5">
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    {{ lang('cloudbalance') }}
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-primary align-middle m-0 p-0 fw-medium" v-if="balance">
                                    <span v-if="CommissionIsValid && CurrenciesRatioCloudToWhmcs">
                                        <span>
                                            {{ formatUserBalance(user.balance - user.debt) }}
                                        </span>
                                        <span v-if="userCurrencySymbolFromWhmcs" class="ms-1">
                                            {{ userCurrencySymbolFromWhmcs }}
                                        </span>
                                    </span>
                                    <span v-else>
                                        Nan
                                    </span>
                                </span>
                                <span class="text-secondary align-middle m-0 p-0 fw-medium" v-else>
                                    <span>
                                        ...
                                    </span>
                                </span>
                            </div>
                        </div>

                        <!-- WHMCS User Credit -->
                        <div class="row m-0 p-0">
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    {{ lang('yourcredit') }}
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-secondary align-middle m-0 p-0 fw-medium"
                                    v-if="WhmcsUserInfo?.credit">
                                    {{ showCreditWhmcsUnit(WhmcsUserInfo?.credit) }}
                                </span>
                                <span v-if="userCurrencySymbolFromWhmcs" class="ms-1" v-if="WhmcsUserInfo?.credit">
                                    {{ userCurrencySymbolFromWhmcs }}
                                </span>
                                <span class="text-secondary align-middle m-0 p-0 fw-medium" v-else>
                                    ---
                                </span>
                            </div>
                        </div>

                    </div>
                </div><!-- end bottom --> 
            </div>
        </div>
    </div>
    <!-- Actions -->
    <div class="d-flex flex-column col-12 col-xl-6 p-0 m-0 mb-2 flex-grow-1">
        <div class="row m-0 p-0">
            <div class="col-12 col-md-6 m-0 p-0 mb-2">
                <div class="row m-0 p-0 h-100">
                    <div class="col-12 border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 h-100" style="height: 150px;">
                        <!-- header -->
                        <div class="row">
                            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <img src="<?php echo($systemUrl); ?>/modules/addons/caasify/views/view/includes/assets/img/bandwidth.svg" width="18">
                                    <span class="m-0 p-0 text-secondary ps-2" style="font-size: 1.15rem !important;">
                                        {{ lang('traffics') }}
                                    </span>
                                </div>
                                <div class="text-end text-primary fw-medium p-0 m-0">
                                    <span v-if="TrafficTotal" class="" style="font-size: 1.15rem !important;">
                                        {{ TrafficTotal }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="m-0 p-0 pb-2">
                            <hr class="text-secondary border-2 border-secondary m-0 p-0">
                        </div>
                        
                        <!-- inbound outbond -->
                        <div v-if="trafficsIsLoaded == true" class="row pt-2">
                            <div class="row fw-medium py-1">
                                <span>
                                    <span class="text-secondary">
                                        <i class="bi bi-cloud-arrow-down fs-5 pe-2"></i>
                                    </span>
                                    <span class="ps-1 text-secondary">
                                        {{ lang('Inbound') }}
                                    </span>
                                    <span class="px-1 text-secondary">:</span>
                                    
                                    <span class="text-primary" v-if="TrafficInbound">
                                        {{ TrafficInbound }}
                                    </span>
                                    <span class="text-primary" v-else>
                                        0 MB
                                    </span>
                                </span>
                            </div>
                            <div class="row fw-medium py-1">
                                <span>
                                    <span class="text-secondary">
                                        <i class="bi bi-cloud-arrow-up-fill fs-5 pe-2"></i>
                                    </span>
                                    <span class="ps-1 text-secondary">
                                        {{ lang('Outbound') }}
                                    </span>
                                    <span class="px-1 text-secondary">:</span>
                                    <span class="text-primary" v-if="TrafficOutbound">
                                        {{ TrafficOutbound }}
                                    </span>
                                    <span class="text-primary" v-else>
                                        0 MB
                                    </span>
                                </span>
                            </div>
                        </div>
                        
                        <!-- extra traffic -->
                        <div class="row pt-5" v-if="thisOrder?.records[thisOrder.records.length-1]?.traffic_price && trafficsIsLoaded == true">
                            <div class="d-flex flex-row justify-content-between align-items-center border py-3 px-3 rounded-3">
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <span class="m-0 p-0 text-secondary ps-2">
                                        {{ lang('extraTraffic') }}
                                    </span>
                                </div>
                                <div class="text-end text-primary fw-medium p-0 m-0">
                                    <span>
                                    {{ formatUserBalance(thisOrder?.records[thisOrder.records.length-1]?.traffic_price) }}
                                    </span>
                                    <span class="px-1">
                                        {{ userCurrencySymbolFromWhmcs }}/{{ lang('gb') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Loading -->
                        <div v-if="trafficsIsLoaded != true" class="row pt-2 text-primary">
                            <span>
                                <span class="pe-2">
                                    {{ lang('loadingmsg') }}
                                </span>
                                <span>
                                    <?php include('./includes/baselayout/threespinner.php'); ?>
                                </span>    
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 m-0 p-0 mb-2">
                <?php include('./includes/viewparts/buttons.php');   ?>
            </div>
        </div>
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 pb-5 h-100"
            style="min-height: 320px;">
            <div class="m-0 p-0">
                <div class="d-flex flex-row justify-content-start align-items-center m-0 p-0 flex-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-secondary fw-light">
                                    {{ lang('Action') }}
                                </th>
                                <th scope="col" class="text-secondary fw-light">
                                    {{ lang('status') }}
                                </th>
                                <th scope="col" class="text-secondary fw-light">
                                    {{ lang('Time') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="ActionHistory"
                                v-for="(action, index) in ActionHistory.slice(0, 5)" :key="index">
                                <td>
                                    {{ lang(action.button.name.toUpperCase()) }}
                                </td>
                                <td>
                                    <span style="--bs-bg-opacity: 0.2; width:120px;"
                                        :class="{ 
                                            'btn btn-sm bg-danger py-1 text-danger small': action.status == 'failed',
                                            'btn btn-sm bg-primary py-1 text-primary small': action.status == 'pending',
                                            'btn btn-sm bg-success py-1 text-success small': action.status == 'delivered'
                                        }">
                                        <span>
                                            {{ lang(action.status.toUpperCase()) }}
                                        </span>
                                        <span v-if="action.status == 'pending'" class="spinner-grow my-auto mb-0 ms-1 align-middle" style="--bs-spinner-width: 5px; --bs-spinner-height: 5px; --bs-spinner-animation-speed: 1s;"></span>
                                    </span>
                                </td>
                                <td> {{ convertTime(action.created_at) }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>