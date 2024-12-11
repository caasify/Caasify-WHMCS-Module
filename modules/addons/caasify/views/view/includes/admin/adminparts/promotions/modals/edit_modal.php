<div class="modal fade" id="editPromotionModal" tabindex="-1" aria-labelledby="editPromotionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPromotionModalLabel">Edit Promotion : {{ editPromotion.form.promotion_code }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" v-if="editPromotion.loading == true">Loading ...</p>
                <form class="col-12 col-lg-12" onsubmit="return false;" v-show="editPromotion.loading == false">
                    <label for="promotion_code" class="form-label">
                        Code
                    </label>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="promotion_code" name="promotion_code" v-model="editPromotion.form.promotion_code">
                        <span class="input-group-text" style="padding: 0;">
                            <button type="button" id="generate_random_button" @click="generateRandomCodeEdit" class="btn btn-primary" style="margin: 0;"> Generate ! </button>
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" v-model="editPromotion.form.type" name="type" ref="type" @change="promotionTypeOnChangeEdit">
                            <option value="percent" selected>percent</option>
                            <option value="fixed">fixed</option>
                        </select>
                    </div>



                    <label for="Value" class="form-label">Value</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="value" v-model="editPromotion.form.value" name="value">
                        <span class="input-group-text" id="typeSign">
                            {{ editPromotion['typeSignArea'] }}
                        </span>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" v-model="editPromotion.form.start_date" name="start_date" >
                        </div>
                        <div class="col">
                            <label for="expiration_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="expiration_date" v-model="editPromotion.form.expiration_date" name="expiration_date">
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="max_use" class="form-label">Max use</label>
                        <input type="number" class="form-control" id="max_use" v-model="editPromotion.form.max_use" name="max_use" value="0">
                        <div id="max_useHelp" class="form-text">Enter "0" for unlimited use</div>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">User Type</label>
                        <select class="form-control" id="user_type" name="user_type" v-model="editPromotion.form.user_type" ref="userType" @change="userTypeOnChange">
                            <option value="all_users" selected>All Users</option>
                            <option value="new_users">New Users</option>
                            <option value="specific_users">Specific Users</option>
                        </select>
                    </div>

                    <div class="mb-3" id="userListSection" v-show="editPromotion.form.user_type == 'specific_users'">
                        <label for="user_list" class="form-label">Allowed users</label>
                        <select class="selectpicker col-12" id="user_list" name="user_list" v-model="editPromotion.form.user_list" multiple aria-label="Default select example" data-live-search="true">
                            <?php
                            $userList = cassify_get_all_wh_users();
                            foreach ($userList as $user) {
                                ?>
                                <option value="<?=$user->id?>"><?=$user->first_name . " " . $user->last_name?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="recurring_no" class="form-label">Recurre time</label>
                        <input type="number" class="form-control" id="recurring_no" v-model="editPromotion.form.recurring_no" name="recurring_no" value="1">
                        <div id="recurring_noHelp" class="form-text">This field indicates the number of repetitions allowed for each user . <b>At least enter '1' as value !</b></div>

                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="min_amount" class="form-label">Min amount</label>
                            <input type="number" class="form-control" id="min_amount" v-model="editPromotion.form.min_amount" name="min_amount" value="0">
                        </div>
                        <div class="col">
                            <label for="max_amount" class="form-label">Max amount</label>
                            <input type="number" class="form-control" id="max_amount" v-model="editPromotion.form.max_amount" name="max_amount" value="0">
                        </div>
                        <div id="min_maxHelp" class="form-text">Enter "0" to consider the minimum and maximum as unlimited</div>

                    </div>

                    <div v-if="editPromotion.alert.type == 'error' &&  editPromotion.alert.show == true" class="alert alert-danger" role="alert">
                        {{ editPromotion.alert.message }}
                    </div>

                    <div v-if="editPromotion.alert.type == 'success' &&  editPromotion.alert.show == true" class="alert alert-success" role="alert">
                        {{ editPromotion.alert.message }}
                    </div>

                    <button type="submit" class="btn btn-primary" @click="editPromotionCode(editPromotion.form.id)" :disabled='editPromotion.isDisabled'>Edit</button>
                </form>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
