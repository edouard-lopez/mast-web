<button role="button"
        class="btn btn-xs <?= $props['class'] ?>"
        <?= isset($props['id']) ? 'data-id="'.$props['id'].'"' : ''; ?>
        data-name="<?= $props['name'] ?>"
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
