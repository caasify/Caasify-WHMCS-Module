<!-- Data Centers -->
<div class="row">
    <div v-for="Category in parentCategories" class="col-12 col-md-6 col-lg-3 m-0 p-0 mb-2">
        <div class="d-flex flex-row align-items-center border border-2 mx-1 rounded-4 p-3" 
        style="--bs-bg-opacity: 0.5 !important;"
        :style="isCategory(Category) ?  'cursor: pointer' : 'color: #a2a2a2'"
        :class="isCategory(Category) ? 'shadow-sm border border-2 border-secondary' : ''"
        @click="selectCategory(Category)">
            <div class="m-0 p-0">
                <img :src="Category.icon" class="img-fluid rounded-top" alt=""/ style="width:40px;">
            </div>
            <div class="text-start ps-3 pt-2">
                <p v-if="Category" class="h6 m-0 p-0">
                    {{ Category.name }}
                </p>
                <p class="fs-6 m-0 p-0">
                    <span v-if="!isCategory(Category)">
                        <i class="bi bi-lock pe-1 h5"></i>
                        <span>
                            {{ lang('Coming soon') }} ...
                        </span>
                    </span>
                    <span v-if="isCategory(Category)">
                        <span>
                            3650 products
                        </span>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div id="RegionsPoint"></div>