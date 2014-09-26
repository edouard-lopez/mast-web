<?php
// $fields = $this->config->item('SERVICE_HELPERS')[$action]['form-fields'];
?>

<div class="modal fade" id="modal-<?= $action ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only"><?=i18n($this, 'close')?></span></button>
                <h4 class="modal-title"><strong>replaced-with-js</strong> › <?=i18n($this, $action)?></h4>
            </div>
            <div class="modal-body">
                <form id="form-<?= $action ?>" class="form-inline" role="form">
                    <?php foreach ($fields as $field => $field_args): ?>
                        <?php $fid = $action . '-' . strtolower(i18n($this, $field)); ?>
                        <div class="form-group">
                            <label for="<?= $fid ?>" class="control-label">
                                <?= i18n($this, $field . ':label') ?>
                            </label>

                            <div>
                                <input type="text" class="form-control input-sm"
                                       id="<?= $fid ?>"
                                       placeholder="<?= i18n($this, $field . ':placeholder') ?>"
                                       pattern="<?= @$field_args['pattern'] ?>"
                                       required
                                    >
                            </div>
                        </div>
                    <?php endforeach ?>
                    <input type="text" name="target-action" value="replaced-with-js" class="target-action">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=i18n($this, 'close')?></button>
                <button type="submit" class="btn btn-primary btn-sm action"> <?= i18n($this, 'add') ?> </button>
            </div>
        </div>
    </div>
</div>
