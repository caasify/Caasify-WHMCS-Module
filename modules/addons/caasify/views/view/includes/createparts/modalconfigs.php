<!-- Config modal -->
<div class="modal fade modal-lg" id="configModal" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="configModalLabel" aria-hidden="false" ref="configModal">
    <div class="modal-dialog modal-dialog-top" style="max-width: 650px !important; padding-top: 150px">
        <!-- vps -->
        <div v-if="SelectedPlan?.type == 'vps'" class="modal-content border-0">
            <?php  include('./includes/createparts/vpsconfig.php');    ?>
        </div>
        <!-- vpn -->
        <div v-if="SelectedPlan?.type == 'vpn'" class="modal-content border-0">
            <?php  include('./includes/createparts/vpncreatemodal.php');    ?>
        </div>
    </div>
</div>