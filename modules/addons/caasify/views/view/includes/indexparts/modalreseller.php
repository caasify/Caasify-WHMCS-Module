<?php if(isset($resellerMode) && $resellerMode == 'on'): ?>
<!-- reseller modal -->
<div class="modal fade" id="resellerModal" tabindex="-1" aria-labelledby="resellerModalLabel" aria-hidden="true" style="--bs-modal-width: 570px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="resellerModalLabel">
                    {{ lang('Reseller Info') }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-3 mb-4">
                    <div v-if="CaasifyResellerUserInfo != null && WhmcsUserIsNull != true" class="row">
                        <div class="col-12">
                            <div class="row">
                                <div v-if="CaasifyResellerUserInfo.name != null" class="input-group">
                                    <span class="input-group-text" id="username" style="max-width: 140px; min-width: 110px;">
                                        {{ lang('name') }}
                                    </span>
                                    <input type="text" class="form-control border-1 bg-primary" :value="CaasifyResellerUserInfo.name"
                                            style="max-width: 450px; min-width: 130px; --bs-bg-opacity: 0.06;" disabled>
                                </div>
                                <div v-if="CaasifyResellerUserInfo.email != null" class="input-group my-1">
                                    <span class="input-group-text" id="useremail" style="max-width: 140px; min-width: 110px;">
                                            {{ lang('email') }}
                                    </span>
                                    <input type="text" class="form-control border-1 bg-primary"
                                        :value="CaasifyResellerUserInfo.email"
                                        style="max-width: 450px; min-width: 130px; --bs-bg-opacity: 0.06;" disabled>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold" id="token" style="max-width: 140px; min-width: 110px;">
                                        {{ lang('usertoken') }}
                                    </span>
                                    <input v-if="usertoken == null" type="text" class="form-control border-1 bg-primary"
                                        aria-label="Username" aria-describedby="Username" value="no token"
                                        style="max-width: 360px; min-width: 130px; --bs-bg-opacity: 0.06;" disabled>
                                    <input v-if="usertoken != null" type="text" class="form-control border-1 bg-primary"
                                        aria-label="Username" aria-describedby="Username"
                                        :value="showToken ? usertoken : maskedToken"
                                        style="max-width: 360px; min-width: 130px; --bs-bg-opacity: 0.06;" disabled>
                                    <span class="input-group-text" id="copy" @click="copyUserToken(usertoken)"
                                        style="width: 40px;">
                                        <i v-if="!BtnCopyTokenPushed"
                                            class="col-auto m-0 p-0 bi bi-c-circle-fill h4 text-priamry"></i>
                                        <i v-if="BtnCopyTokenPushed"
                                            class="col-auto m-0 p-0 bi bi-check2-circle h4 text-primary"></i>
                                    </span>
                                    <span class="input-group-text" id="show" @click="changeVisibility()"
                                        style="width: 40px;">
                                        <i v-if="!showToken"
                                            class="col-auto m-0 p-0 bi bi-eye-slash-fill h4 text-secondary"></i>
                                        <i v-if="showToken"
                                            class="col-auto m-0 p-0 bi bi-eye-fill h4 text-primary "></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="CaasifyResellerUserInfo == null || WhmcsUserIsNull == true" class="row">
                        <span class="m-0 p-0 ps-2 text-primary">
                            <?php include('./includes/baselayout/threespinner.php'); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ lang('close') }}
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif ?>