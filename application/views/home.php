<?php require TPL_PATH.'/header.php'; ?>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Mast web</h2>

	</div>
</div>
                    <?php foreach ($this->config->item('SERVICE_ACTIONS') as $action): ?>
                        <li>
                            <a href="#/api/<?=$action?>" id="<?=$action?>" class="btn btn-default btn-action">
                                <?= ucfirst(i18n($this,$action))?>
                            </a>
                        </li>
                    <?php endforeach; ?>

    <div>
        <pre class="stdout"><?= $this->shell->run("/etc/init.d/mast status"); ?></pre>
    </div>

<?php require TPL_PATH.'/footer.php'; ?>
