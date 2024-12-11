<!-- orders List -->
<div class="row px-1 px-md-3 px-lg-4 pb-5 mt-5" style="overflow-y: scroll; height: 600px;">
    <div class="py-5">

        <!-- Fetching  -->
        <div v-if="!OrdersLoaded">
            <span>
                <div class="spinner-border spinner-border-sm text-primary small" role="status"></div>
                <span class="h4 text-primary py-3 ps-3">{{ lang('listofactiveorders') }}</span>
            </span>
            <p class="fs-5 pt-3 ps-3">
                {{ lang('waittofetch') }}
            </p>
        </div>

        <!-- Has no orders -->
        <div v-if="OrdersLoaded && activeorders == null">
            <p class="fs-5 ps-3 text-danger">
                {{ lang('noactiveorder') }}
            </p>
        </div>

        <!-- show activ orders -->
        <div v-if="OrdersLoaded && activeorders != null">
            <table v-if="!isEmpty(activeorders)" class="table table-borderless pb-5 mb-5"
                style="--bs-table-bg: #ff000000;">
                <thead>
                    <tr class="border-bottom text-center"
                        style="--bs-border-width: 2px !important; --bs-border-color: #e1e1e1 !important;">
                        <th scope="col" class="fw-light fs-6 text-secondary pb-3">{{ lang('ID') }}</th>
                        <th scope="col" class="fw-light fs-6 text-secondary pb-3">{{ lang('name') }}</th>
                        <th scope="col" class="fw-light fs-6 text-secondary pb-3">{{ lang('Alive') }}</th>
                        <th scope="col" class="fw-light fs-6 text-secondary pb-3 d-none d-md-block">{{ lang('Price') }}</th>
                        <th scope="col" class="fw-light fs-6 text-secondary pb-3">{{ lang('Type') }}</th>
                        <th scope="col" class="fw-light fs-6 text-secondary pb-3">{{ lang('Views') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom align-middle text-center text-danger" v-for="order in activeorders"
                        style="--bs-border-width: 1px !important; --bs-border-color: #e1e1e1 !important;">
                        <!-- ID -->
                        <td class="fw-medium">
                            <span v-if="order.id" class="fs-6 fw-medium">{{ order.id }}</span>
                            <span v-else class="fs-6 fw-medium"> --- </span>
                        </td>

                        <!-- Name -->
                        <td class="fw-medium">
                            <span v-if="order.note" class="fs-6 fw-medium">{{ order.note }}</span>
                            <span v-else class="fs-6 fw-medium"> --- </span>
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
                                <span v-if="record.price != null" class="ms-2">
                                    {{ formatPlanPrice(record.price) }} {{ userCurrencySymbolFromWhmcs }}
                                </span>
                                <span v-else class="fw-medium"> --- </span>
                            </span>
                        </td>
                        
                        <!-- type -->
                        <td class="fw-medium">
                            <span v-if="order?.type" class="ms-2">
                                <button class="px-3 px-md-4 py-2" :class="orderTypeClass(order?.type)" @click="open(order)">
                                    <i class="bi bi-record-circle me-2"></i>
                                    {{ order?.type.toUpperCase() }}
                                </button>
                            </span>
                        </td>
                        
                        <!-- view -->
                        <td class="fw-medium">
                            <span v-if="order.id" class="ms-2">
                                <button class="px-3 px-md-5 py-2" @click="open(order)" :class="orderTypeClass(order?.type)">
                                    {{ lang('viewontable') }}
                                </button>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row justify-content-around px-4" v-else>
                <div class="d-flex flex-column justify-content-center align-ietms-center text-center mt-5 border rounded p-5 col-12 col-md-5 col-lg-4 border-secondary bg-primary" style="--bs-bg-opacity: 0.1; --bs-border-opacity: 0.1;">
                    <span class="text-dark fs-5 pe-3 mb-3">
                        {{ lang('chargecloudaccount') }}
                    </span>
                    <a class="btn btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#chargeModal">
                        <span class="h5">
                            {{ lang('topup') }}
                        </span>
                    </a>
                </div>
                <div class="d-flex flex-column justify-content-center align-ietms-center text-center mt-5 border rounded p-5 col-12 col-md-5 col-lg-4 border-secondary bg-primary" style="--bs-bg-opacity: 0.1; --bs-border-opacity: 0.1;">
                    <span class="text-dark fs-5 pe-3 mb-3">
                        {{ lang('noactiveorder') }}
                    </span>
                    <a class="btn btn-primary px-3 py-2" @click="openCreatePage" target='_top'>
                        <span class="h5">
                            {{ lang('createorder') }}
                        </span>
                    </a>
                </div>
            </div>
        </div>


    </div>
</div> 
<!-- End List -->