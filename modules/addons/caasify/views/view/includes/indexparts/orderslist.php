<!-- orders List -->
<div class="row px-1 px-md-3 px-lg-4 pb-5 mt-5 pt-5">
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
                        <th scope="col" class="fw-light fs-6 text-secondary pb-3">{{ lang('Views') }}</th>
                    </tr>
                </thead>
                <tbody v-for="order in activeorders">
                    <tr class="border-bottom align-middle text-center"
                        style="--bs-border-width: 1px !important; --bs-border-color: #e1e1e1 !important;">
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
                                    {{ formatPlanPrice(record.price) }} {{ userCurrencySymbolFromWhmcs }}
                                </span>
                                <span v-else class="fw-medium"> --- </span>
                            </span>
                        </td>


                        <!-- view -->
                        <td class="fw-medium">
                            <span v-if="order.id" class="ms-2">
                                <button class="btn btn-outline-primary px-3 px-md-5 py-2" @click="open(order)">
                                    {{ lang('viewontable') }}
                                </button>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="" v-else>
                <p class="fs-6 ps-3 text-danger">
                    {{ lang('noactiveorder') }}
                </p>
            </div>
        </div>


    </div>
</div> 
<!-- End List -->