
<!-- Simple alert Pop Up -->
<div class="modal fade" id="BalanceAlertModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="BalanceAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" style="max-width: 600px;">  
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex flex-column">
                    <div class="my-4">
                        <p class="text-center alert alert-danger fw-medium">
                            {{ lang('BalanceIsLow') }}
                            <br>
                            {{ lang('MachienWouldDelete') }}
                            <br>
                            <span class="">
                                <span v-if="CaasifyUserInfo?.balance_alarm" class="">
                                    <span v-if="CaasifyUserInfo?.balance_alarm > 1">
                                        {{ Number(CaasifyUserInfo?.balance_alarm).toFixed(0) }} 
                                        <span>
                                        {{ lang('hours or less') }}
                                        </span>
                                    </span>
                                    <span v-else>
                                        {{ lang('an hour or less') }}
                                    </span>
                                </span>
                                <span v-else class="">
                                    {{ lang('24 hours or less') }}
                                </span>
                            </span>
                        </p>
                    </div>
                    <div class="row m-0 p-0">
                        <div class="d-flex flex-row justify-content-between align-items-center flex-wrap pe-0">
                            <div class="row mb-1 ms-3 ms-md-1 ms-lg-0">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" v-model="CLBlanaceChecked">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">
                                        {{ lang('I am aware of the Risk') }}
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-end flex-wrap">
                                <button type="button" class="btn btn-danger px-3 mx-1 border-0 py-2 mb-1" data-bs-dismiss="modal" :disabled="!CLBlanaceChecked">
                                    <span class="fw-medium">
                                        {{ lang('Confirm Alert and Close') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->