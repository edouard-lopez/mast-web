<button role="button"
        class="btn btn-xs <?= $props['class'] ?>"
        <?php if (isset($name)):?>
            data-name="<?= $name ?>"
        <?php endif ?>
        data-action="<?= $action ?>"
        data-redirect="<?= $props['redirect'] ?>"
        data-target="#modal-<?= $action ?>"

        title="<?= ucfirst(i18n($this, $action)) ?>"
        data-placement="left"
        data-toggle="tooltip"
        data-trigger="hover"
        data-html="true"
    >
    <i class="<?= $props['icon'] ?>"></i>
    <?= $props['text-content'] ?>
</button>
