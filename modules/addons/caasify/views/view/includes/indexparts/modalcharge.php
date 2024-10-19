<!-- create order modal -->
<div class="modal fade modal-lg" id="chargeModal"  data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="chargeModalLabel" aria-hidden="false" style="--bs-modal-width: 720px;">
    <div class="modal-dialog">
        <!-- usercredit or balance is null -->
        <div v-if="userCreditinWhmcs == null || balance == null" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="chargeModalToggleLabel">{{ lang('chargecloudaccount') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>    
            <div class="modal-body mt-4 mx-1 mx-md-3 mx-lg-4" style="height:150px">
                <p class="h5 py-2">
                    {{ lang('waittofetch') }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">{{ lang('close') }}</button>
            </div>
        </div>
        
        <div v-if="userCreditinWhmcs != null && balance != null" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ lang('chargecloudaccount') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>    
            <div class="modal-body mt-4 px-3 px-md-4 pb-5">
                <div class="row m-0 p-0 align-items-start">
                    <div class="col-12 m-0 p-0">
                        <!-- Table balance and credit -->    
                        <div class="row m-0 p-0">
                            <div class="col-12 m-0 p-0">
                                <p class="fs-5 lh-lg mt-2">
                                    {{ lang('InsertValidNumber') }}
                                </p>
                            </div>
                        </div>

                        <!-- form input -->
                        <div class="row m-0 p-0 mt-4">            
                            <div class="col-12 m-0 p-0">
                                <div class="row m-0 p-0">
                                    <div class="col-12 col-md-7 m-0 p-0 mb-2">
                                        <div class="row m-0 p-0 pe-md-2">
                                            <div class="col-12 m-0 p-0 input-group">
                                                <span class="input-group-text bg-body-secondary border-secondary" id="chargecredit" style="width: 140px !important;">
                                                    {{ lang('amounttocharge') }}
                                                </span>
                                                <input type="text" class="form-control bg-body-secondary border-secondary" 
                                                placeholder="100" aria-label="chargecredit" aria-describedby="chargecredit" 
                                                v-model="chargeAmountinWhmcs" style="max-width: 140px !important;">
                                                <span class="input-group-text border-secondary" id="chargecredit" style="min-width: 50px;">
                                                    {{ userCurrencySymbolFromWhmcs }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(isset($MyCaasifyStatus) && $MyCaasifyStatus == 'on'): ?>
                                        <div class="col-12 col-md-5 m-0 p-0 mb-2">
                                            <div class="row m-0 p-0 pe-md-2">
                                                <div class="col-12 m-0 p-0 input-group">
                                                    <span class="input-group-text" id="gateway">
                                                        {{ lang('gateway') }}
                                                    </span>
                                                    <select class="form-select" aria-label="Default select example" style="max-width: 150px;" v-model="SelectedGetway">
                                                        <option v-if="WhmcsUserInfo?.countrycode != null && WhmcsUserInfo?.countrycode != 'IR'" value="stripe">Credit Card</option>
                                                        <option v-if="WhmcsUserInfo?.countrycode != null && WhmcsUserInfo?.countrycode != 'IR'" value="paypal">Paypal</option>
                                                        <option value="mailin" selected>Bank Transfer</option>
                                                        <option value="cryptomusgateway">Crypto Currency</option>
                                                        <option value="plisio">USDT</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Validate -->
                        <div class="row m-0 p-0 mt-5" v-if="chargeAmountinWhmcs && NewChargingValidity">
                            <div class="col-12 m-0 p-0">
                                <div class="m-0 p-0" v-if="NewChargingValidity == 'noenoughchargeamount'">
                                    <p class="alert alert-danger">
                                        <span>
                                            {{ lang('lessthanalowedminimum') }}
                                        </span>
                                        <span class="px-1">
                                            ({{ showMinimumeWhmcsUnit(ConvertFromCaasifyToWhmcs(config.MinimumCharge))}})
                                        </span>
                                        <span v-if="userCurrencySymbolFromWhmcs">
                                            {{ userCurrencySymbolFromWhmcs }}
                                        </span>
                                        <span>.</span>
                                    </p>
                                </div>
                                
                                <div class="m-0 p-0" v-if="NewChargingValidity == 'notinteger'">
                                    <p class="alert alert-danger">
                                        <span>{{ lang('notvaliddecimal') }}</span>
                                    </p>
                                </div>
                                
                                <div class="m-0 p-0" v-if="NewChargingValidity == 'overcredit'">
                                    <p class="alert alert-danger">
                                        <span>{{ lang('thisismorethancredit') }}</span>
                                    </p>
                                </div>
                                
                                <div class="m-0 p-0" v-if="NewChargingValidity == 'MoreThanMax'">
                                    <p class="alert alert-danger">
                                        <span>{{ lang('MoreThanMax') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Steps -->
                        <div class="row m-0 p-0 mt-5" v-if="chargeAmountinWhmcs && NewChargingValidity == 'fine' && InvoiceCreationStatus != null">
                            <div class="col-12 m-0 p-0 rounded border bg-body-secondary p-3">
                                <div class="row">
                                    
                                    <!-- Start to create Invoice  -->
                                    <div v-if="InvoiceCreationStatus == 'start'" class="d-flex flex-row justify-content-start align-items-center">
                                        <div class="text-primary">
                                            <span class="me-2 h5"><i class="bi bi-check"></i></span>
                                            <span class="text-primary pe-3">
                                                {{ lang('Creating invoice') }}
                                                <span>
                                                    <?php include('./includes/baselayout/threespinner.php'); ?>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- success to create Invoice  -->
                                    <div v-if="InvoiceCreationStatus == 'success'" class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="text-primary">
                                            <span class="me-2 h5"><i class="bi bi-check"></i></span>
                                            <span class="text-primary pe-3">
                                                {{ lang('invoice created successfully') }}
                                            </span>
                                        </div>
                                        <div class="">
                                            <button v-if="InvoiceCreationStatus == 'success'" class="btn btn-primary col-auto px-4" target="_parent" @click="openInvoicePage">
                                                <span>
                                                    {{ lang('Go to invoice payment') }}
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- fail to create Invoice  -->
                                    <div v-if="InvoiceCreationStatus == 'fail'" class="d-flex flex-row justify-content-start align-items-center">
                                        <div class="text-danger">
                                            <span class="me-2 h5"><i class="bi bi-check"></i></span>
                                            <span class="text-danger pe-3">
                                                {{ lang('Creating invoice Failed, try again') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>                    
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex flex-row justify-content-between">
                <div class="m-0 p-0">
                    <span class="text-dark fw-medium">
                        <span>
                            {{ lang('yourcredit') }}
                        </span>
                        <span class="px-1">:</span>
                    </span>
                    <span v-if="userCreditinWhmcs" class="text-primary fw-medium">
                        <span class="px-1">
                            {{ showCreditWhmcsUnit(userCreditinWhmcs) }}
                        </span>
                        <span v-if="userCurrencySymbolFromWhmcs">
                            {{userCurrencySymbolFromWhmcs}}
                        </span>
                    </span>    
                    
                    <span v-else class="text-primary fw-medium">
                        --- 
                    </span>
                </div>
                <div class="d-flex flex-row justify-content-between">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" aria-label="Close">{{ lang('close') }}</button>
                    
                    <!-- BTN Reseller mycaasify -->
                    <?php if(isset($MyCaasifyStatus) && $MyCaasifyStatus == 'on'): ?>

                        <div class="m-0 p-0 ps-2" v-if="chargeAmountinWhmcs && NewChargingValidity == 'fine'">
                            <a v-if="InvoiceCreationStatus == null" class="btn btn-primary col-auto px-4" @click="ResellerNewCreateUnpaidInvoice">
                                <span>{{ lang('starttransferring') }}</span>
                            </a>
                            <a v-if="InvoiceCreationStatus == 'start'" class="btn btn-primary col-auto px-4" disabled>
                                <span>
                                    {{ lang('Creating invoice') }}
                                </span>
                                <span>
                                    <?php include('./includes/baselayout/threespinner.php'); ?>
                                </span>
                            </a>
                            <a v-if="InvoiceCreationStatus == 'fail'" class="btn btn-danger col-auto px-4" @click="ResellerNewCreateUnpaidInvoice">
                                <span>
                                    {{ lang('tryagain') }}
                                </span>
                            </a>
                            <button v-if="InvoiceCreationStatus == 'success'" class="btn btn-primary col-auto px-4" target="_parent" @click="openInvoicePage">
                                <span>
                                    {{ lang('Go to invoice payment') }}
                                </span>
                            </button>
                        </div>
                    
                    <?php else: ?>
                        <!-- BTN ordinary -->
                        <div class="m-0 p-0 ps-2" v-if="chargeAmountinWhmcs && NewChargingValidity == 'fine'">
                            <a v-if="InvoiceCreationStatus == null" class="btn btn-primary col-auto px-4" @click="NewCreateUnpaidInvoice">
                                <span>{{ lang('starttransferring') }}</span>
                            </a>
                            <a v-if="InvoiceCreationStatus == 'start'" class="btn btn-primary col-auto px-4" disabled>
                                <span>
                                    {{ lang('Creating invoice') }}
                                </span>
                                <span>
                                    <?php include('./includes/baselayout/threespinner.php'); ?>
                                </span>
                            </a>
                            <a v-if="InvoiceCreationStatus == 'fail'" class="btn btn-danger col-auto px-4" @click="NewCreateUnpaidInvoice">
                                <span>
                                    {{ lang('tryagain') }}
                                </span>
                            </a>
                            <button v-if="InvoiceCreationStatus == 'success'" class="btn btn-primary col-auto px-4" target="_parent" @click="openInvoicePage">
                                <span>
                                    {{ lang('Go to invoice payment') }}
                                </span>
                            </button>
                        </div>
                    <?php endif ?>

                </div>
            </div>
        </div>  
    </div> 
</div><!-- end modal -->