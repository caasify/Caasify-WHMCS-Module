<!-- orders List -->
<div class="row px-1 px-md-3 px-lg-4 pb-5 mt-5 pt-5">
    <div class="py-5">
    
        <!-- Fetching  -->
        <div v-if="!machinsLoaded">
            <span>
                <div class="spinner-border spinner-border-sm text-primary small" role="status"></div>
                <span class="h4 text-primary py-3 ps-3">{{ lang('listofactiveorders') }}</span>
            </span>    
            <p class="fs-5 pt-3 ps-3">
                {{ lang('waittofetch') }}
            </p>
        </div>

        <!-- Has no orders -->
        <div v-if="machinsLoaded && userHasNoorder">
            <p class="fs-5 ps-3 text-danger">
                {{ lang('noactiveorder') }} 
            </p>
        </div>
        
        <!-- show activ orders -->
        <div v-if="machinsLoaded && !userHasNoorder" >
            <table v-if="!isEmpty(activeorders)" class="table table-borderless pb-5 mb-5" style="--bs-table-bg: #ff000000;">
                <thead>
                    <tr class="border-bottom" style="--bs-border-width: 2px !important; --bs-border-color: #e1e1e1 !important;">
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3">{{ lang('ID') }}</th>
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3">{{ lang('name') }}</th>
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3">{{ lang('Status') }}</th>
                        <!-- <th scope="col" class="fw-light fs-5 text-secondary pb-3">{{ lang('Created_at') }}</th> -->
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3 d-none d-md-block">{{ lang('Records') }}</th>
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3">{{ lang('View') }}</th>
                    </tr>
                </thead>
                <tbody v-for="order in activeorders">
                    <tr class="border-bottom align-middle" style="--bs-border-width: 1px !important; --bs-border-color: #e1e1e1 !important;">
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
                        
                        <!-- Status -->
                        <td class="fw-medium">
                            <span v-if="order.status" class="ms-2">{{ order.status }}</span>
                            <span v-else class="fw-medium" > --- </span>
                        </td>

                        <!-- created_at -->
                        <!-- <td class="fw-medium">
                            <span v-if="order.created_at" class="ms-2">{{ order.created_at }}</span>
                            <span v-else class="fw-medium" > --- </span>
                        </td> -->
                       
                        <!-- record -->
                        <td class="fw-medium d-none d-md-block py-3">
                            <span v-for="record in order.records" class="m-0 p-0">
                                <span v-if="record.product.title" class="ms-2">{{ record.product.title }}</span>
                                <span v-if="record.status" class="ms-2">({{ record.status }})</span>
                                <span v-if="record.price" class="ms-2 text-primary">{{ record.price }} {{ CaasifyDefaultCurrencySymbol }}</span>
                                <span v-else class="fw-medium" > --- </span>
                            </span>
                        </td>   
                        
                        
                        <!-- view -->
                        <td class="fw-medium">
                            <span v-if="order.id" class="ms-2">
                                <a class="btn btn-outline-primary px-3 px-md-5 py-2" @click="open(order)">
                                    View
                                </a>
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