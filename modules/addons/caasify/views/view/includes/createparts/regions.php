<!-- SPOT Alarm -->
<div v-if="SelectedDataCenter?.type?.toLowerCase() == 'spot'" class="row m-0 p-0 mt-5 px-1 px-md-2 px-lg-4">
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="row">
            <div class="col-12 border border-2 border-danger rounded-4 p-4">
                <p class="alert alert-danger h5 bg-danger text-light">
                    {{ lang('SpotAlert01') }}
                </p>
                <p class="pt-4">
                    <span class="h5">
                        {{ lang('SpotAlert02') }}
                    </span>
                    <ul class="h6 lh-lg">
                        <li>
                            <b>{{ lang('SpotAlert03') }} </b> {{ lang('SpotAlert04') }}
                        </li>
                        <li>
                            <b>{{ lang('SpotAlert05') }} </b> {{ lang('SpotAlert06') }}
                        </li>
                        <li>
                            <b>{{ lang('SpotAlert07') }} </b> {{ lang('SpotAlert08') }}
                        </li>
                    </ul>
                    <p class="h6 mt-4">
                        {{ lang('SpotAlert09') }}
                    </p>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Cities -->
<div v-if="SelectedDataCenter != null" class="row m-0 p-0 mt-5 py-5 px-1 px-md-2 px-lg-4">
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="row">
            <div class="col-12 mb-5">
                <p class=" h3">
                    <span class="pe-2">
                        {{ SelectedDataCenter?.title }}
                    </span>
                    <span class="">
                        {{ lang('Locations') }} *
                    </span>
                </p>    
            </div>
        </div> 
        <div class="row">
            <div v-for="region in regions" class="col-12 col-md-6 col-lg-4 col-xl-3 p-2 m-0">
                <div 
                style="--bs-bg-opacity: 0.5 !important; height: 70px !important;"
                class="d-flex flex-row align-items-center bg-light rounded-4 shadow-lg bg-white border"
                :class="{ 'border border-2 border-dark': isRegion(region) }" 
                @click="selectRegion(region)">
                    <div class="px-3">
                        <img :src="showImage(region?.image)" class="m-0 p-0 rounded-3" style="width: 55px; height: 40px">
                    </div>
                    <div class="text-center pe-5">
                        <span class="h4 text-dark m-0 p-0">
                            {{ region.name }}
                        </span>
                    </div>
                </div>
            </div>
            <div v-if="regions == null" class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                <p class="h5 me-4">
                    Err. There is no region to show
                </p>
            </div>
        </div>
    </div>
</div>
<div id="plansPoint"></div>

