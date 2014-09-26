<li>
    <a href="#" role="button"
            data-name="<?= $tunnel ?>"
            data-action="<?= $action ?>"
            class="btn btn-xs <?= $props['class'] ?>"
            data-target="#modal-<?= $action ?>"
        >
        <i class="<?= $props['icon'] ?>"></i>
        <span><?= ucfirst(i18n($this, $action)) ?></span>
    </a>
</li>