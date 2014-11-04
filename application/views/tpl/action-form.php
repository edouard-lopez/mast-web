<div class="modal fade" id="modal-<?= $action ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only"><?= i18n($this, 'close') ?></span></button>
                <h4 class="modal-title"><strong class="name">replaced-with-js</strong> › <?= i18n($this, $action) ?>
                </h4>
            </div>
            <form id="form-<?= $action ?>" action="/api/<?= $action ?>" method="post" class="form-inline" role="form">
                <div class="modal-body">
                    <?php foreach ($fields as $field => $field_args): ?>
                        <?php $fid = $action . '-' . $field; ?>
                        <div class="form-group">
                            <label for="<?= $fid ?>" class="control-label">
                                <?= i18n($this, $field . ':label') ?>
                            </label>
                            <div>
                                <input type="text" class="<?=$field=='NAME'?'name': '' ;?> form-control input-sm"
                                       id="<?= $fid ?>"
                                       name="<?= $field ?>"
                                       placeholder="<?= i18n($this, $field . ':placeholder') ?>"
                                       pattern="<?= @$field_args['pattern'] ?>"
                                       required
                                    <?php if ($action == 'add-channel' && $field == 'NAME'): ?>
                                        value="replaced-with-js"
                                        readonly
                                    <?php elseif($action == 'add-host' && $field == 'CURRENT_IP'): ?>

                                    <?php endif ?>
                                    >
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?= i18n($this, 'close') ?></button>
                    <input type="submit" class="btn btn-primary btn-sm" value="<?= i18n($this,
                        'add') ?>">
                </div>
            </form>
        </div>
    </div>
</div>