<?php   include_once('caasifyupdatefunc.php');    ?>
<?php   include('caasifyupdater/header.php');     ?>


<div id="app" class="bg-dark text-light p-5 rounded-5 mt-4">
    <?php   include('caasifyupdater/actionsmodal.php');     ?>
    <div class="row" v-cloak>
        <div class="col-12 col-lg-6">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <div class="">
                    <span class="h3">
                        Caasify Module Updater
                    </span>
                </div>
                <div class="d-none d-md-block">
                    <button class="btn btn-info px-5" v-if="ActionIsDoing && CurrentAction">
                        <span class="me-2">
                            {{ CurrentAction.toUpperCase() }}
                        </span>
                        <span class="spinner-border spinner-border-sm" role="status"></span>
                    </button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex flex-row justify-content-start align-items-center mt-3">
                        <div style="width: 170px;">
                            Caasify Latest Version:
                        </div>
                        <?php if($RemoteVersion == 0): ?>
                        <div class="text-info small">
                            NAN
                        </div>
                        <?php else: ?>
                        <button class="btn btn-info btn-sm ms-2 px-3 py-0 rounded-3" style="width: 90px;" :disabled="ActionIsDoing">
                            <?php echo($RemoteVersion); ?>
                        </button>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row justify-content-start align-items-center mt-3">
                        <div style="width: 170px;">
                            Your Current Version: 
                        </div>
                        <?php if($LocalVersion == 0): ?>
                            <div class="text-info small">
                                NAN
                            </div>
                        <?php else: ?>
                            <button class="btn btn-info btn-sm ms-2 px-3 py-0 rounded-3" style="width: 90px;" :disabled="ActionIsDoing">
                                <?php echo($LocalVersion); ?>
                            </button>
                        <?php endif ?>                    
                    </div>
                </div>
            </div>
            <div class="row mt-5 pt-5">
                <p class="text-info fw-light">
                    <?php if($LocalVersion == 0 && $RemoteVersion != 0): ?>
                        <span>
                            Can not find your version, please Reinstall
                        <span>
                    <?php elseif($LocalVersion != 0 && $RemoteVersion == 0): ?>
                        <span>
                            Can not find the latest Versions, please refresh the page again
                        </span>
                    <?php elseif($LocalVersion != 0 && $RemoteVersion != 0): ?>
                        <?php if($LocalVersion == $RemoteVersion): ?>
                            <span>
                                Your module is updated to lates version
                            </span>
                        <?php else: ?>
                            <span>
                                You should update the module
                            </span>
                        <?php endif ?>
                    <?php endif ?>
                </p>
            </div>

            <hr>
            <div class="d-flex flex-row justify-content-start align-items-center pb-3">
                <button class="btn btn-info px-3 mx-2" style="width: 415px;" data-bs-toggle="modal" data-bs-target="#actionsmodal" @click="funcUpdate" :disabled="ActionIsDoing">Auto Update Module</button>
            </div>
            <div class="d-flex flex-row justify-content-start align-items-center">
                <button class="btn btn-outline-info px-3 mx-2" style="width: 200px;" data-bs-toggle="modal" data-bs-target="#actionsmodal" @click="funcDownload" :disabled="ActionIsDoing">Download Module</button>
                <button class="btn btn-outline-info px-3 mx-2" style="width: 200px;" data-bs-toggle="modal" data-bs-target="#actionsmodal" @click="funcFix" :disabled="ActionIsDoing">Fix Permision</button>
            </div>
        </div>
        <div class="col-12 col-lg-6 mt-5 mt-lg-0">
            <div class="bg-body-secondary p-4 rounded-4 border-2 shadow-lg text-secondary small" style="min-height: 390px;">
                <div class="">
                    <p>
                        <span class="h5">
                            Action Result
                        </span>
                    </p>
                    <hr>
                    <span v-if="ActionIsDoing">
                        <span class="h6">
                            Loading
                        </span>
                        <span class="spinner-grow my-auto mb-0 ms-1 align-middle" style="--bs-spinner-width: 5px; --bs-spinner-height: 5px; --bs-spinner-animation-speed: 1s;"></span>
                        <span class="spinner-grow my-auto mb-0 ms-1 align-middle" style="--bs-spinner-width: 5px; --bs-spinner-height: 5px; --bs-spinner-animation-speed: 1s;"></span>
                        <span class="spinner-grow my-auto mb-0 ms-1 align-middle" style="--bs-spinner-width: 5px; --bs-spinner-height: 5px; --bs-spinner-animation-speed: 1s;"></span>
                    </span>
                </div>
                <div v-if="ActonResponse" v-html="ActonResponse"></div>
            </div>
        </div>
    </div>
</div>


<?php   include('caasifyupdater/footer.php');    ?>