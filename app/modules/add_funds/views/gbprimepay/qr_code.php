<div class="modal fade show" id="qr_code_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" style="display: block;" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $image_qr_code; ?>" style="display: block; max-width: 100%; margin-left: auto; margin-right: auto;" class="img-responsive">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal"><?=lang("Close")?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".modal .btn-close", function(){
        $('#qr_code_modal').removeClass('show');
        location.reload();
    });
</script>