<!-- Data Centers -->
<div class="row m-0 p-0 py-5 px-4 px-md-2 px-lg-4">
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="row">
            <div class="col-12 mb-5">
                <span class="h3">
                {{ lang('datacenters') }}
                </span>
            </div>
        </div> 
        <div class="row">
            <div v-if="DataCentersAreLoaded && DataCentersLength > 0" v-for="DataCenter in DataCenters" class="col-12 col-md-6 col-lg-4 m-0 p-0 mb-4">
            <?php if(isset($DemoMode) && $DemoMode == 'on'): ?>
                <div class="m-0 p-0" v-if="DataCenter?.name != 'AutoVM'">
            <?php endif ?>
                    <div class="d-flex flex-row align-items-strat shadow-lg mx-1 rounded-4" 
                    style="--bs-bg-opacity: 0.5 !important;"
                    :class="{ 'shadow-lg border border-2 border-secondary': isDataCenter(DataCenter) }" 
                    @click="selectDataCenter(DataCenter)">
                        <div v-if="CaasifyConfigs != null" class="m-0 p-0" style="width: 80px;">
                            <img class="img-fluid rounded-start-4 " :src="showImage(DataCenter?.image)">
                        </div>
                        <div class="text-start ps-3 pt-2">
                            <p v-if="DataCenter.name" class="h3 text-dark m-0 p-0">
                                {{ DataCenter?.name }}
                            </p>
                            <p v-if="DataCenter.type" class="text-secondary fw-medium m-0 p-0">
                                {{ DataCenter?.type.toUpperCase() }}
                            </p>
                            <p v-if="DataCenter.categories" class="text-secondary fw-medium m-0 p-0">
                                {{ DataCenter?.categories?.length }} Locations
                            </p>
                        </div>
                    </div>
                    <?php if(isset($DemoMode) && $DemoMode == 'on'): ?>
                    </div>
                <?php endif ?>
            </div>
            <div v-if="!DataCentersAreLoaded" class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                <p class="h5 me-4">{{ lang('loadingmsg') }}</p>
                <span>
                    <?php include('./includes/baselayout/threespinner.php'); ?>
                </span>
            </div>
            <div v-if="DataCentersAreLoaded && DataCentersLength == 0" class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                <p class="h5 me-4">
                    Err. There is no DataCenter to show
                </p>
            </div>
        </div>
    </div>
</div>
<div id="RegionsPoint"></div>