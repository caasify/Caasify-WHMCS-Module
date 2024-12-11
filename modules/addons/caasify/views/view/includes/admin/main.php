
<div class="row">
    <div class="">
        <ul class="nav nav-tabs" id="adminoutput" role="tablist" style="margin-top: 1em;">
            <li class="nav-item" role="presentation">
                <button class="nav-link" :class=" { active : activeTab == 'transactions'} " id="recentinvoices-tab" data-bs-toggle="tab" data-bs-target="#recentinvoices" type="button" role="tab" aria-controls="recentinvoices" aria-selected="true">
                    <span class="h5">
                        Recent invoices List
                    </span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="autoupdate-tab" data-bs-toggle="tab" data-bs-target="#autoupdate" type="button" role="tab" aria-controls="autoupdate" aria-selected="false">
                    <span class="h5">
                        Auto Update
                    </span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" :class=" { active : activeTab == 'promotion'} " id="promosion-page-tab" data-bs-toggle="tab" data-bs-target="#promosion-page" type="button" role="tab" aria-controls="promosion-page" aria-selected="false">
                    <span class="h5">
                        Promotions
                    </span>
                </button>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="adminoutputContent" style="margin-bottom: 5em;">
        <div class="tab-pane fade" :class=" { active : activeTab == 'transactions' ,  show : activeTab == 'transactions'} " id="recentinvoices" role="tabpanel" aria-labelledby="recentinvoices-tab">
            <?php include './includes/admin/adminparts/maintransactions.php'; ?>
        </div>
        <div class="tab-pane fade" id="autoupdate" role="tabpanel" aria-labelledby="autoupdate-tab">
            <?php include ($systemUrl .'/caasifyupdatepage.php'); ?>
            <?php 
                echo($systemUrl) 
            ?>
        </div>
        <div class="tab-pane fade" :class=" { active : activeTab == 'promotion' ,  show : activeTab == 'promotion'} " id="promosion-page" role="tabpanel" aria-labelledby="promosion-page-tab">
            <?php include './includes/admin/adminparts/mainpromotion.php'; ?>
        </div>
    </div>
</div>

