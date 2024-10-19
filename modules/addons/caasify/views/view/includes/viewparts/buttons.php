<div class="row m-0 p-0">
    <div v-if="ControllersAreLoading" class="d-flex flex-row mt-5 text-primary">
        <p class="h5 me-4 ">
            {{ lang('Controllers Are Loading') }}
        </p>
        <span>
            <?php include('./includes/baselayout/threespinner.php'); ?>
        </span>
    </div>
    <div class="row m-0 p-0">
        <div v-if="!ControllersAreLoading" class="row m-0 p-0">
            <div v-if="NoValidControllerItems != true" class="d-flex flex-row align-items-center justify-content-between flex-wrap m-0 p-0 ms-md-1">
                <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                    <div class="col-3 m-0 p-0 d-grid flex-grow-1" v-for="(button, index) in ValidControllerItems">
                        <button data-bs-toggle="modal" data-bs-target="#actionsModal"
                            class="btn btn-light px-4 py-4 fw-medium border-2 border-secondary mx-1 my-1 rounded-4"
                            style="--bs-border-opacity: 0.3; height: 70px;"
                            @click="PushButtonController(button.id, button.name)" :key="index" :id="index"
                            :disabled="button.name.toLowerCase() === 'delete'"
                            >
                            <span>
                                {{ lang(button.name.toUpperCase()) }}
                            </span>
                        </button>
                    </div>
                <?php else: ?>
                    <div class="col-3 m-0 p-0 d-grid flex-grow-1" v-for="(button, index) in ValidControllerItems">
                        <button data-bs-toggle="modal" data-bs-target="#actionsModal"
                            class="btn btn-light px-4 py-4 fw-medium border-2 border-secondary mx-1 my-1 rounded-4"
                            style="--bs-border-opacity: 0.3; height: 70px;"
                            @click="PushButtonController(button.id, button.name)" :key="index" :id="index">
                            <span>
                                {{ lang(button.name.toUpperCase()) }}
                            </span>
                        </button>
                    </div>
                <?php endif ?>
            </div>
            <div v-if="NoValidControllerItems === true" class="alert alert-primary">
                {{ lang('No valid Controller Founded') }}
            </div>
        </div>
    </div>
</div>


