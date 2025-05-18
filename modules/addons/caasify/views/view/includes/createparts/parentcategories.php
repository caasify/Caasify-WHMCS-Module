<!-- Data Centers -->
<div class="row">
    <div v-for="Category in parentCategories" class="col-12 col-md-3 col-lg-3 m-0 p-0 mb-2">
        <div class="d-flex flex-row align-items-center border border-2 mx-1 rounded-4 p-3" 
        style="--bs-bg-opacity: 0.5 !important;"
        :style="isCategory(Category) ?  'cursor: pointer' : 'color: #a2a2a2'"
        :class="isCategory(Category) ? 'shadow-sm border border-2 border-secondary' : ''"
        @click="selectCategory(Category)">
            <div class="m-0 p-0">
                <img :src="Category.icon" class="img-fluid rounded-top" :alt="Category.name" style="width:40px;">
            </div>
            <div class="text-start ps-3 pt-2" :style="Category.enabled ? 'color:#383636' : '' ">
                <p v-if="Category" class="h6 m-0 p-0">
                    {{ lang(Category.name) }}
                </p>
                <p class="fs-6 m-0 p-0">
                    <i v-if="!Category.enabled" class="bi bi-lock pe-1"></i>
                    <span>
                        {{ lang(Category.msg) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div id="RegionsPoint"></div>