<div class="modal fade" id="usedDetailModal" tabindex="-1" aria-labelledby="usedDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usedDetailModalLabel">Used Detail : {{ promotionList.usedDetail.data.code }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table"  v-if="promotionList.usedDetail.isLoading == false">
                    <thead>
                        <th scope="col">Username</th>
                        <th scope="col">Number of uses</th>
                    </thead>
                    <tbody v-if="promotionList.usedDetail.data.list.length > 0">
                        <tr v-for="detailRow in promotionList.usedDetail.data.list">
                            <td>{{ detailRow.name }}</td>
                            <td>{{ detailRow.count }}</td>
                        </tr>
                    </tbody>
                    <tbody v-if="promotionList.usedDetail.data.list.length == 0">
                        <tr>
                            <td colspan="2" style="text-align: center;">No one has used it yet.</td>
                        </tr>
                    </tbody>
                </table>
                <p style="text-align: center;" v-if="promotionList.usedDetail.isLoading == true"> Loading ... </p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
