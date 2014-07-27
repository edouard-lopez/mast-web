<?
/**
 * User: ed8
 * Date: 7/27/14
 */
?>
<?php require TPL_PATH.'/header.php'; ?>

<div class="container">
    <h2><?=i18n($this,'dashboard')?></h2>
    <div class="container-fluid">

        <ul class="nav nav-tabs" role="tablist" id="dashboard-panes">
            <li class="active"><a href="#service" role="tab" data-toggle="tab">Service</a></li>
            <li><a href="#tunnels" role="tab" data-toggle="tab">Tunnels</a></li>
            <li><a href="#settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="service">
                <ul class="nav nav-pills">
                <?php foreach ($this->config->item('SERVICE_ACTIONS') as $action => $props): ?>
                    <li>
                        <button type="button" id="<?=$action?>" class="btn btn-<?=$props['class']?> btn-sm btn-action">
                            <i class="glyphicon glyphicon-<?=$props['icon']?>"></i>
                            <?= ucfirst(i18n($this,$action))?>
                        </button>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>

            <div class="tab-pane" id="tunnels">
                <ul class="nav nav-pills">
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
            <div class="tab-pane" id="settings">
                <p class="bg-danger">The Kraken <strong>eat them all!</strong></p>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid">
        <pre class="stdout"><?= $this->shell->run("/etc/init.d/mast status"); ?></pre>
    </div>
</div>

<?php require TPL_PATH.'/footer.php'; ?>
