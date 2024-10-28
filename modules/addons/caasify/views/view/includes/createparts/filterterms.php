<div class="row border-bottom m-0 p-0 mb-3 py-2 px-1">
    <div class="col-12 m-0 p-0">
        <div class="d-flex flex-row justify-content-between align-items-center pb-2">
            <div class="">
                <p class="fs-6 fw-medium p-0 m-0 py-1">
                    {{ lang('Filters') }}
                </p>
            </div>
            <div class="d-flex flex-row justify-content-end align-items-center">
                <a class="btn bg-primary text-primary btn-sm px-3" style="--bs-bg-opacity: 0.2;"
                    @click="resetTheFilters">
                    <p class="m-0 p-0">
                        {{ lang('Reset') }}
                    </p>
                </a>
                <button type="button" class="btn btn-secondary btn-sm d-block d-md-none ms-2" data-bs-dismiss="modal">
                    {{ lang('close') }}
                </button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="my-2 px-2" v-if="FilterTermsAreLoaded == false" :style="'opacity: ' + opacity">
            <div v-for="i in Array.from({ length: 3 }, (v, k) => k + 1)" class="form-check m-0 p-0 py-1" style="--bs-bg-opacity: 0.2; direction: ltr;">
                <label for="CPU" class="form-label row my-0 py-0">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <div>
                            <p class="h6 p-0 m-0">
                                ...
                            </p>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-end">
                            <div class="d-flex flex-row align-items-center justify-content-end">
                                <span class="ps-2 text-primary py-1">...</span>
                            </div>
                        </div>
                    </div>
                </label>
                <input type="range" class="form-range" min="1" max="12" step="1" id="CPU" style="--val: 0" value="1"/>
            </div>
        </div>
        <div class="row p-0" v-if="FilterTermsAreLoaded">
            <div class="px-0" v-for="(filter, index) in sortedFiltersTerm" :key="index" :id="'accordionPanel' + index">
                <!-- CPU, RAM, DISK, Traffic -->
                <div v-if="['CPU', 'Ram', 'Disk', 'Traffic'].includes(filter?.name)" class="form-check m-0 p-0 py-1 px-4" style="direction: ltr">
                    <label :for="filter?.name" class="form-label row my-0 py-0">
                        <div class="d-flex flex-row align-items-center justify-content-between">
                            <div>
                                <p class="h6 p-0 m-0">
                                    {{ lang(filter?.name) }}
                                </p>
                            </div>
                            <div class="d-flex flex-row align-items-center justify-content-end">
                                <div class="d-flex flex-row align-items-center justify-content-end" v-if="filter?.name == 'CPU'">
                                    <span v-if="selectedRanges[filter?.name] != '1'" class="py-1">
                                        {{ selectedRanges[filter?.name] }}
                                    </span>
                                    <span v-if="selectedRanges[filter?.name] != '1'" class="ps-1">Core</span>
                                    <span v-if="selectedRanges[filter?.name] == '1'" class="text-primary py-1">
                                        {{ lang('All') }}
                                    </span>
                                </div>
                                <div class="d-flex flex-row align-items-center justify-content-end" v-if="filter?.name == 'Ram'">
                                    <span v-if="selectedRanges[filter?.name] != '1'" class="py-1">
                                        {{ selectedRanges[filter?.name] }}
                                    </span>
                                    <span v-if="selectedRanges[filter?.name] != '1'" class="ps-1">GB</span>
                                    <span v-if="selectedRanges[filter?.name] == '1'" class="text-primary py-1">
                                        {{ lang('All') }}
                                    </span>
                                </div>
                                <div class="d-flex flex-row align-items-center justify-content-end" v-if="filter?.name == 'Disk'">
                                    <span v-if="selectedRanges[filter?.name] != '10'" class="py-1">
                                        {{ selectedRanges[filter?.name] }}
                                    </span>
                                    <span v-if="selectedRanges[filter?.name] != '10'" class="ps-1">GB</span>
                                    <span v-if="selectedRanges[filter?.name] == '10'" class="text-primary py-1">
                                        {{ lang('All') }}
                                    </span>
                                </div>
                                <div class="d-flex flex-row align-items-center justify-content-end" v-if="filter?.name == 'Traffic'">
                                    <span v-if="selectedRanges[filter?.name] != '0'" class="py-1">
                                        {{ selectedRanges[filter?.name] }}
                                    </span>
                                    <span v-if="selectedRanges[filter?.name] != '0'" class="ps-1">TB</span>
                                    <span v-if="onlyUnlimitedTrafficCheckbox && selectedRanges[filter?.name] == '0'" class="text-primary py-1">Unlimited</span>
                                    <span v-if="!onlyUnlimitedTrafficCheckbox && selectedRanges[filter?.name] == '0'" class="text-primary py-1">
                                        {{ lang('All') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </label>
                    <input type="range"
                        class="form-range" 
                        :style="'--val:'+val[filter?.name]"
                        :min="filter?.terms[0].name != 0 ? filter?.terms[0].name : 0" 
                        :max="filter?.terms[filter?.terms.length - 1].name" 
                        :step="filter?.name == 'Disk'? 10 : 1" 
                        :id="filter?.name" 
                        v-model="selectedRanges[filter?.name]" 
                        :disabled="plansAreLoading"
                        @input="ColorizeRange($event, filter?.name)"
                        @click="setSelectedRange(filter?.name, selectedRanges[filter?.name])"
                    >
                    <!-- <div v-if="filter?.name == 'Traffic'" class="float-end mb-5">
                        <input class="form-check-input border-primary" type="checkbox" id="unlimit_traffic" v-model="onlyUnlimitedTrafficCheckbox">
                        <label class="form-check-label small text-primary" for="unlimit_traffic">
                            Only Unlimit Traffic
                        </label>
                    </div> -->
                </div>
                <!-- Others -->
                 <div v-if="['Country', 'CPU Type', 'Disk Type', 'IP version', 'VM Type'].includes(filter?.name)" class="accordion px-1" :class="filter?.name == 'Country' ? 'mt-5' : '' ">
                    <div class="accordion-item border-0">
                        <p class="accordion-header">
                            <button class="accordion-button collapsed rounded-2 py-2 mt-1" type="button" style="box-shadow: none; background-color: #d4e4ff; border-radius:0px"
                                data-bs-toggle="collapse"
                                :data-bs-target="'#panelsStayOpen-collapse' + index" aria-expanded="true"
                                :aria-controls="'panelsStayOpen-collapse' + index"
                                >
                                <span class="fw-medium text-primary h6 p-0 m-0 py-2">
                                    {{ lang(filter?.name) }}
                                </span>
                            </button>
                        </p>
                        <div :id="'panelsStayOpen-collapse' + index" class="accordion-collapse collapse show border-0">
                            <div class="accordion-body bg-primary rounded-bottom-3" style="--bs-bg-opacity: 0.05;">
                                <div v-for="(term, key) in filter?.terms" :key="key" class="form-check ms-1">
                                    <input class="form-check-input" type="checkbox" 
                                        :disabled="plansAreLoading"
                                        :id="'termid-' + term?.id + '-' + term?.name"
                                        :value="term?.id" @click="setSelectedCheckbox($event, filter?.name)" v-model="checkBoxesStatus[term?.id]">
                                    <label class="form-check-label" :for="'termid-' + term?.id + '-' + term?.name">
                                        {{ lang(term?.name) }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>