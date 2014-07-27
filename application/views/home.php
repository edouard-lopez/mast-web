<?
/**
 * User: ed8
 * Date: 7/27/14
 */
?>
<?php require TPL_PATH.'/header.php'; ?>

<div class="container">
    <h2><?=i18n($this,'dashboard')?></h2>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                <?php foreach ($this->config->item('SERVICE_ACTIONS') as $action => $props): ?>
                    <li>
                        <button type="button" id="<?=$action?>" class="btn btn-<?=$props['class']?> btn-sm btn-action">
                            <i class="glyphicon glyphicon-<?=$props['icon']?>"></i>
                            <?= ucfirst(i18n($this,$action))?>
                        </button>
                    </li>
                <?php endforeach; ?>
                </ul>

                <ul class="nav navbar-nav">
                <?php foreach ($this->config->item('SERVICE_HELPERS') as $helper => $props): ?>
                    <li>
                        <button type="button" id="<?=$helper?>" class="btn btn-<?=$props['class']?> btn-sm btn-helper">
                            <i class="glyphicon glyphicon-<?=$props['icon']?>"></i>
                            <?= ucfirst(i18n($this,$helper))?>
                        </button>
                    </li>
                <?php endforeach; ?>
                    <li>
                        <a href="/api/<?=$helper?>" id="<?=$helper?>" class="btn btn-default btn-action">
                            <?=i18n($this,'clear')?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div>
        <pre class="stdout"><?= $this->shell->run("/etc/init.d/mast status"); ?></pre>
    </div>
</div>

<?php require TPL_PATH.'/footer.php'; ?>
