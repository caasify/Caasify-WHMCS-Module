
<div class="">
    <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 3em;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="promotions-tab" data-bs-toggle="tab" data-bs-target="#promotions" type="button" role="tab" aria-controls="promotions" aria-selected="false">
                Report Promotion
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="add-promotion-tab" data-bs-toggle="tab" data-bs-target="#add-promotion" type="button" role="tab" aria-controls="add-promotion" aria-selected="false">
                Add New Promotion
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent" style="margin-bottom: 5em;">
        <div class="tab-pane active show" id="promotions" role="tabpanel" aria-labelledby="promotions-tab">
            <?php include './includes/admin/adminparts/promotions/promotions.php'; ?>
        </div>
        <div class="tab-pane fade" id="add-promotion" role="tabpanel" aria-labelledby="add-promotion-tab">
            <?php include './includes/admin/adminparts/promotions/add_promotion.php'; ?>
        </div>
    </div>
</div>

