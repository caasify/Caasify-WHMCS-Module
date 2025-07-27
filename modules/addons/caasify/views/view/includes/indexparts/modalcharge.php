
<div class="modal fade modal-lg" id="chargeModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="chargeModalLabel" aria-hidden="false" style="--bs-modal-width: 620px;">

    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header border-bottom-0">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
            
                <div class="row g-3">

                    <div class="col-lg-12">
                        
                        <h5 class="fs-6 fw-bold">
                            {{ lang('Select Gateway') }}
                        </h5>
                    </div>

                    <div class="col-lg-12">
                    
                        <div class="row g-3">
                            <div v-for="(gateway, index) in WhmcsGateways" class="col-lg-6">
                                <div class="c-box" :class="{'c-box-selected': isGatewaySelected(gateway.module)}" @click="selectGateway(gateway.module)">

                                    <div class="c-box-left c-box-left-blue">
                                        <span>{{ index + 1 }}</span>
                                    </div>

                                    <div class="c-box-right">
                                        {{ gateway.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        
                        <h5 class="fs-6 fw-bold">
                            {{ lang('Select Amount') }}
                        </h5>
                    </div>

                    <div class="col-lg-12">

                        <div class="row g-3">

                            <div v-for="charge in CaasifyCharges" class="col-lg-6">
                                <div class="c-box" :class="{'c-box-selected': isChargeSelected(charge)}" @click="selectCharge(charge)">

                                    <div class="c-box-left c-box-left-purple">
                                        <span>
                                            {{ userCurrencySymbolFromWhmcs }}
                                        </span>
                                    </div>

                                    <div class="c-box-right">
                                        {{ formatCurrencyAmount(charge) }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                            
                                <div class="input-group">

                                    <span class="input-group-text">
                                        {{ lang('Or enter your custom amount') }}
                                    </span>

                                    <input type="text" v-model="SelectedCharge" class="form-control px-4 py-2">
                                </div>
                            </div>

                            <div v-if="ChargeFormError" class="col-lg-12">

                                <div class="alert alert-danger mb-0">
                                    {{ lang(ChargeFormError) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="ChargeInvoiceId" class="modal-footer border-top-0">

                <a target="blank" :href="`${systemUrl}/viewinvoice.php?id=${ChargeInvoiceId}`" class="btn btn-success w-100 px-4">
                    {{ lang('Pay Now') }}
                </a>
            </div>

            <div v-else class="modal-footer border-top-0">
            
                <button v-if="ChargeFormProcessing" type="button" disabled class="btn btn-primary w-100 px-4">
                    {{ lang('Processing') }}
                </button>

                <button v-else type="button" @click="startPayment" class="btn btn-primary w-100 px-4">
                    {{ lang('Pay Now') }}
                </button>
            </div>
        </div>
    </div>
</div>