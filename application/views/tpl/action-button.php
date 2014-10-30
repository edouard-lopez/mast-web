<button role="button"
        class="btn btn-xs <?= $props['class'] ?>"
        <?php if (isset($props['id'])): ?>
            data-id="<?= $props['id']?>"
        <?php endif ?>
        data-name="<?= $props['name']?>"
        data-action="<?= $action ?>"
        data-redirect="<?= $props['redirect'] ?>"
        data-href="<?= $props['href'] ?>"
        data-target="#modal-<?= $action ?>"

        title="<?= ucfirst(i18n($this, $action)) ?>"
        data-placement="left"
        data-toggle="tooltip"
        data-trigger="hover"
        data-html="true"
    >
    <i class="<?= $props['icon'] ?>"></i>
    <span class="btn-content"><?= $props['text-content'] ?></span>
</button>
