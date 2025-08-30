<!-- Hostname -->
<div class="m-0 p-0 pb-4 px-2">
    <div class="d-flex flex-row justify-content-between align-items-center m-0 p-0 flex-wrap">
        <div class="d-flex flex-row justify-content-between align-items-center m-0 p-0 me-md-3">
            <div class="m-0 p-0">
                <span class="">
                    <span class="m-0 p-0 h5">
                        <span v-if="thisOrder?.type == 'vps'" class="text-secondary">
                            {{ lang('hostname') }}
                        </span>
                        <span v-if="thisOrder?.type == 'vpn'" class="text-secondary">
                            {{ lang('name') }}
                        </span>
                        <span class="px-1">
                            :
                        </span>
                        <span v-if="thisOrder?.note" class="h4 text-primary">
                            {{ thisOrder?.note }}
                        </span>
                        <span v-else class="h4 text-primary">
                            ---
                        </span>
                    </span>
                </span>
            </div>
            <div class="spinner-border spinner-border-sm text-primary ms-4 border-2" role="status"
                v-if="viewsAreLoading">
                <span class="visually-hidden">
                    <span>
                        {{ lang('loadingmsg') }}
                    </span>
                    <span>
                        ...
                    </span>
                </span>
            </div>
        </div>


        <div class="d-flex flex-row justify-content-start align-items-center m-0 p-0 flex-wrap">
            <div v-if="thisOrder?.type == 'vps'" class="m-0 p-0 d-none d-md-block ms-2">
                <span 
                    class="btn btn-outline-secondary py-2 d-flex flex-row align-items-center px-4 btn-sm fw-medium" 
                    @click="HandleOpenConsoleModal" 
                    v-if="thisProductHasConsole"
                >
                    {{ lang('consoleaction') }}
                </span>
            </div>
            
            <!-- delete btn for vpn -->
            <div v-if="thisOrder?.type == 'vpn'" class="m-0 p-0">
                <div class="m-0 p-0 ms-2" v-for="(button, index) in ValidControllerItems">
                    <button data-bs-toggle="modal" data-bs-target="#actionsModal"
                        class="btn btn-danger px-4 py-2 fw-medium mx-1 btn-sm"
                        @click="PushButtonController(button.id, button.name)" :key="index" :id="index">
                        <span>
                            {{ lang(button.name.toUpperCase()) }}
                        </span>
                    </button>
                </div>
            </div>
            <div v-if="OrderStatus == 'online'" class="m-0 p-0 d-none d-md-block ms-2">
                <span class="btn bg-success text-success py-2 d-flex flex-row align-items-center px-2 ms-2 btn-sm"
                    style="--bs-bg-opacity: .2">
                    <span class="ms-1 pe-2 fw-medium">
                        {{ lang('online') }}
                    </span>
                </span>
            </div>
            <div v-if="OrderStatus == 'offline'" class="m-0 p-0 d-none d-md-block ms-2">
                <span class="btn bg-danger text-danger py-2 d-flex flex-row align-items-center px-2 ms-2 btn-sm"
                    style="--bs-bg-opacity: .2">
                    <span class="ms-1 pe-2 fw-medium">
                        {{ lang('offline') }}
                    </span>
                </span>
            </div>
            <div class="m-0 p-0 d-none d-md-block ms-2">
                <span class="btn bg-primary text-primary py-2 d-flex flex-row align-items-center px-4 btn-sm"
                    style="--bs-bg-opacity: .2">
                    <span class="spinner-grow text-primary my-auto m-0 p-0 me-1 align-middle"
                        style="--bs-spinner-width: 7px; --bs-spinner-height: 7px; --bs-spinner-animation-speed: 2s;"></span>
                    <span class="ms-1 pe-2 fw-medium" v-if="thisOrder?.status">
                        {{ lang(thisOrder?.status) }}
                    </span>
                    <span class="ms-1" v-else> - </span>
                </span>
            </div>

            <div v-if="thisOrder?.type == 'vps'"  class="m-0 p-0 d-none d-md-block ms-2">
                <span class="btn bg-primary text-primary py-2 d-flex flex-row align-items-center px-2 ms-2 btn-sm"
                    style="--bs-bg-opacity: .2">
                    <span class="ms-1 pe-2 fw-medium" v-if="thisOrder?.created_at">
                        {{ thisOrder?.created_at }} 
                    </span>
                    <span class="ms-1" v-else> - </span>
                </span>
            </div>

            <!-- Language -->
            <div class="m-0 p-0 ms-2">
                <?php  include('./includes/baselayout/langbtn.php'); ?>
            </div>
        </div>
    </div>
</div>
