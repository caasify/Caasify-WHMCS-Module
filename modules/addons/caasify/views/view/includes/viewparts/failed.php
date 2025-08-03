<div class="modal fade" id="deleteModal" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog">  
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="actionModalLabel">
                    {{ lang('Something was wrong!') }}
                </h1>
            </div>
            <div class="modal-body">
                <p class="h5 pt-3">
                    {{  lang('The order could not created successfully') }}
                </p>
                <p class="h5 pt-3">
                    {{ lang('Would you like to delete it?') }}
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" @click="openTicketPage" class="btn btn-text">
                    {{ lang('Open Ticket') }}
                </button>

                <button v-if="isDeleting" type="button" disabled class="btn btn-primary">
                    {{ lang('Deleting') }}
                </button>
                <button v-else type="button" @click="deleteOrder" class="btn btn-primary">
                    {{ lang('Delete') }}
                </button>
            </div>
        </div>
    </div>
</div>