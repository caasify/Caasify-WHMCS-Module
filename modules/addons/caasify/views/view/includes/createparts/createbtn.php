<div v-if="SelectedPlan != null" class="d-flex flex-row justify-content-end m-0 p-0">
    <div class="m-0 p-0">
        <a class="btn px-4 bg-secondary" style="--bs-bg-opacity: 0.3;" data-bs-dismiss="modal">{{ lang('cancel') }}</a>
        <a class="btn btn-primary mx-3" @click="create" data-bs-toggle="modal"
            data-bs-target="#createModal">{{ lang('Create Machine') }}</a>
    </div>
</div>