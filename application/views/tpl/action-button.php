<li>
    <a href="#" role="button"
            class="btn btn-xs <?= $props['class'] ?>"
            <?php if (isset($name)):?>
                data-name="<?= $name ?>"
            <?php endif ?>
            data-action="<?= $action ?>"
            data-target="#modal-<?= $action ?>"

            title="<?= ucfirst(i18n($this, $action)) ?>"
            data-placement="bottom"
            data-toggle="tooltip"
            data-trigger="hover"
            data-html="true"
        >
        <?php if (isset($text_content)): ?>
            <?= $text_content ?>
        <?php endif ?>
        <i class="<?= $props['icon'] ?>"></i>
    </a>
</li>
