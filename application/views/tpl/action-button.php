<li>
    <a href="#" role="button"
            class="btn btn-xs <?= $props['class'] ?>"
            data-name="<?= $tunnel ?>"
            data-action="<?= $action ?>"
            data-target="#modal-<?= $action ?>"

            title="<?= ucfirst(i18n($this, $action)) ?>"
            data-placement="bottom"
            data-toggle="tooltip"
            data-trigger="hover"
            data-html="true"
        >
        <i class="<?= $props['icon'] ?>"></i>
    </a>
</li>