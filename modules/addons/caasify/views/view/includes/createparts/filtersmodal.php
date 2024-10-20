<!-- Modal -->
<div class="modal fade" id="filtersModal" tabindex="-1" aria-labelledby="filtersModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <?php  include('./includes/createparts/filterterms.php'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
            {{ lang('close') }}
        </button>
      </div>
    </div>
  </div>
</div>