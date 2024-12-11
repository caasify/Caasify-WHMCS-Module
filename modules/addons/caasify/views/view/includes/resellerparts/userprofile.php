
<div class="h5 fw-bold m-0 p-0 px-0 px-md" style="--bs-text-opacity: 0.8; color: #293949;">
    Reseller Profile
</div>

<div class="mt-3 mb-4">
    <div v-if="CaasifyResellerUserInfo != null && WhmcsUserIsNull != true" class="row">
        <div class="col-12">
            <div class="row">
                <div v-if="CaasifyResellerUserInfo.name != null" class="input-group">
                    <span class="input-group-text" id="username" style="max-width: 140px; min-width: 70px;">Name</span>
                    <input type="text" class="form-control border-1 bg-primary" :value="CaasifyResellerUserInfo.name" style="max-width: 350px; min-width: 130px; --bs-bg-opacity: 0.06;" disabled>
                </div>
                <div v-if="CaasifyResellerUserInfo.email != null" class="input-group my-1">
                    <span class="input-group-text" id="useremail" style="max-width: 140px; min-width: 70px;">Email</span>
                    <input type="text" class="form-control border-1 bg-primary" :value="CaasifyResellerUserInfo.email" style="max-width: 350px; min-width: 130px; --bs-bg-opacity: 0.06;" disabled>
                </div>
                <div class="input-group">
                    <span class="input-group-text fw-bold" id="token" style="max-width: 140px; min-width: 70px;">
                        Token
                    </span>
                    <input v-if="usertoken == null" type="text" class="form-control border-1 bg-primary" aria-label="Username" aria-describedby="Username" value="no token" style="max-width: 270px; min-width: 130px; --bs-bg-opacity: 0.06;" disabled>
                    <input v-if="usertoken != null" type="text" class="form-control border-1 bg-primary" aria-label="Username" aria-describedby="Username" :value="showToken ? usertoken : maskedToken" style="max-width: 270px; min-width: 130px; --bs-bg-opacity: 0.06;" disabled>
                    <span class="input-group-text" id="copy" @click="copyUserToken(usertoken)" style="width: 40px;">
                        <i v-if="!BtnCopyTokenPushed" class="col-auto m-0 p-0 bi bi-c-circle-fill h4 text-priamry"></i>
                        <i v-if="BtnCopyTokenPushed" class="col-auto m-0 p-0 bi bi-check2-circle h4 text-primary"></i>
                    </span>
                    <span class="input-group-text" id="show" @click="changeVisibility()" style="width: 40px;">
                        <i v-if="!showToken" class="col-auto m-0 p-0 bi bi-eye-slash-fill h4 text-secondary"></i>
                        <i v-if="showToken" class="col-auto m-0 p-0 bi bi-eye-fill h4 text-primary "></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div v-if="CaasifyResellerUserInfo == null || WhmcsUserIsNull == true" class="row">
        <p class="alert alert-danger">
            Error 187: Call your admin
        </p>
    </div>    
</div>