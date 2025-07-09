
<!-- right: OrderDetails for vps -->
<div v-if="thisOrder?.type == 'vps'" class="col-lg-8 col-sm-12 p-0 m-0 mb-2">
    <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 me-xl-1 pb-5 h-100">
        <div class="m-0 p-0">
            <!-- machine Info -->
            <div class="d-flex flex-row justify-content-between align-items-center">
                <div class="">
                    <p class="text-secondary fs-5 m-0 p-0">
                        <img src="<?php echo($systemUrl); ?>/modules/addons/caasify/views/view/includes/assets/img/osicon.svg" width="18">
                        <span class="text-secondary m-0 p-0 ps-4">
                            {{ lang('Machine Info') }}
                        </span>
                        <button v-if="thisOrder?.id" class="small btn bg-primary btn-sm p-0 m-0 px-3 ms-3 py-2 text-primary" style="--bs-bg-opacity: 0.2;">
                            <span class="p-0 m-0">
                                {{ thisOrder?.id }}
                            </span>
                        </button>
                    </p>
                </div>
                <div class="">
                    <button v-if="convertZone(findZone.dcname?.name)" class="btn border-secondary text-secondary p-0 m-0 px-3 py-2" style="--bs-bg-opacity: 0.2; --bs-border-opacity: 0.5;">
                        <div class="d-flex flex-row justify-content-center align-items-center">
                            <span class="small">
                                Zone {{ convertZone(findZone.dcname?.name) }}
                            </span>
                        </div>
                    </button>
                    <button v-if="findZone?.city" class="btn border-secondary text-secondary p-0 m-0 ps-2 pe-3 ms-1 py-2" style="--bs-bg-opacity: 0.2; --bs-border-opacity: 0.5;">
                        <div class="d-flex flex-row justify-content-center align-items-center">
                            <img :src="showImage(findZone.city?.image)" class="img-fluid rounded-1 me-2" :alt="findZone.dcname?.name" style="width: 25px;">
                            <span class="small">
                                {{ lang(findZone.city.name) }}
                            </span>
                        </div>
                    </button>
                </div>
            </div>
            <div class="input-group mt-4 mb-2">
                <span class="input-group-text" id="basic-addon1" style="width: 100px;">
                    {{ lang('username') }}
                </span>
                <input type="text" class="form-control" value="Linux: root    |    Windows: administrator" disabled>
            </div>
            <div class="input-group mb-4">
                <span class="input-group-text" id="basic-addon1" style="width: 100px;">
                    {{ lang('password') }}
                </span>
                <input v-if="!PassVisible" type="text" class="form-control" value="*********" disabled>
                <?php if(isset($DemoMode) && $DemoMode == 'off' ): ?>
                    <input v-if="PassVisible" type="text" class="form-control" :value="PasswordInHistory ?? thisOrder?.secret" disabled>
                <?php else: ?>
                    <input v-if="PassVisible" type="text" class="form-control" value="Demo Value" disabled>
                <?php endif ?>
                <a class="input-group-text" id="basic-addon1" @click="ShowHidePassword">
                    <i v-if="PassVisible" class="bi bi-eye-fill"></i>
                    <i v-if="!PassVisible" class="bi bi-eye-slash-fill"></i>
                </a>
            </div>
            <!-- bottom slice -->
            <div class="m-0 p-0 px-1">
                <div class="m-0 p-0 mt-0">
                    <!-- Monthly Price -->
                    <div class="row m-0 p-0 align-items-center">
                        <div class="col-auto m-0 p-0" style="min-width: 120px;">
                            <span class="text-secondary align-middle m-0 p-0">
                                {{ lang('Product Price') }}
                            </span>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <span class="text-secondary align-middle m-0 p-0 fw-medium" v-if="thisOrder?.records[thisOrder.records.length - 1].price && CurrenciesRatioCloudToWhmcs">
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
                            <span class="text-secondary align-middle m-0 p-0 fw-medium" v-if="thisOrder?.records[thisOrder.records.length - 1].hourly_price && CurrenciesRatioCloudToWhmcs">
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
                </div>
            </div>
            <div class="m-0 p-0 px-1 mt-3">
                <div class="m-0 p-0 mt-0">
                    <!-- user balance -->
                    <div class="row m-0 p-0 align-items-center" v-if="balance && CurrenciesRatioCloudToWhmcs">
                        <div class="col-auto m-0 p-0" style="min-width: 120px;">
                            <span class="text-secondary align-middle m-0 p-0">
                                {{ lang('cloudbalance') }}
                            </span>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <span class="text-secondary align-middle m-0 p-0 fw-medium">
                                <span v-if="CommissionIsValid">
                                    <span>
                                        {{ formatUserBalance(user.balance - user.debt) }}
                                    </span>
                                    <span v-if="userCurrencySymbolFromWhmcs" class="ms-1">
                                        {{ userCurrencySymbolFromWhmcs }}
                                    </span>
                                </span>
                                <span v-else>
                                    NAN
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-0 p-0 px-1 mt-3">
                <div class="m-0 p-0 mt-0">
                    <!-- user balance -->
                    <div class="row m-0 p-0 align-items-center" v-if="CurrenciesRatioCloudToWhmcs">
                        <div class="col-auto m-0 p-0" style="min-width: 120px;">
                            <span class="text-secondary align-middle m-0 p-0">
                                {{ lang('Total Expenses') }}
                            </span>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <span class="text-secondary align-middle m-0 p-0 fw-medium">
                                <span v-if="CommissionIsValid">
                                    <span>
                                        {{ formatUserBalance(thisOrder?.total_expenses) }}
                                    </span>
                                    <span v-if="userCurrencySymbolFromWhmcs" class="ms-1">
                                        {{ userCurrencySymbolFromWhmcs }}
                                    </span>
                                </span>
                                <span v-else>
                                    NAN
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div v-if="thisOrder?.type == 'vps'" class="col-lg-4 col-sm-12 p-0 m-0 mb-2">
    <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 me-xl-1 pb-5 h-100 ms-lg-4">
        <div class="m-0 p-0">

            <div class="m-0 p-0 mb-4 d-flex flex-row justify-content-between">
                <span class="m-0 p-0">
                    <i class="bi bi-hdd-network text-secondary pe-3 fs-5"></i>
                    <span class="m-0 p-0 text-secondary ps-2 fs-5">
                        Traffic Stats
                    </span>
                </span>
            </div>

<div class="text-start m-0 p-0 py-2">
    <div class="d-flex flex-row justify-content-between align-items-center m-0 p-0">
        <div class="m-0 p-0">
            <span class="text-secondary fs-6 align-middle m-0 p-0">
                Allowed
            </span>
        </div>
        <div class="m-0 p-0">
            <span class="text-primary fw-medium m-0 p-0 fs-5 align-middle">
                {{ thisOrder.records[0].product.traffic_limit }} GB
            </span>
        </div>
    </div>
</div>      

<div class="text-start m-0 p-0 py-2">
    <div class="d-flex flex-row justify-content-between align-items-center m-0 p-0">
        <div class="m-0 p-0">
            <span class="text-secondary fs-6 align-middle m-0 p-0">
                Inbound
            </span>
        </div>
        <div class="m-0 p-0">
            <span class="text-primary fw-medium m-0 p-0 fs-5 align-middle">
                {{ TrafficInbound }}
            </span>
        </div>
    </div>
</div>           


<div class="text-start m-0 p-0 py-2">
    <div class="d-flex flex-row justify-content-between align-items-center m-0 p-0">
        <div class="m-0 p-0">
            <span class="text-secondary fs-6 align-middle m-0 p-0">
                Outbound
            </span>
        </div>
        <div class="m-0 p-0">
            <span class="text-primary fw-medium m-0 p-0 fs-5 align-middle">
                {{ TrafficOutbound }}
            </span>
        </div>
    </div>
</div>      

<div class="text-start m-0 p-0 py-2">
    <div class="d-flex flex-row justify-content-between align-items-center m-0 p-0">
        <div class="m-0 p-0">
            <span class="text-secondary fs-6 align-middle m-0 p-0">
                Total
            </span>
        </div>
        <div class="m-0 p-0">
            <span class="text-primary fw-medium m-0 p-0 fs-5 align-middle">
                {{ TrafficTotal }}
            </span>
        </div>
    </div>
</div>      

        </div>
    </div>
</div>

<!-- left part vps -->
<div v-if="thisOrder?.type == 'vps'" class="d-flex flex-column col-12 col-xl-6 p-0 m-0 mb-2 flex-grow-1">
    <div class="row m-0 p-0">
        <div class="col-12 m-0 p-0 mb-2">
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
                                {{ lang('ID') }}
                            </th>
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
                                {{ action.id }}
                            </td>
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

                                <span v-if="action?.button?.type == 'setup'" class="btn btn-sm bg-primary text-primary py-1 small disabled mx-1" style="--bs-bg-opacity: 0.2;">
                                    {{ lang('It may take few minutes') }}
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