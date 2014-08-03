<?
/**
 * User: ed8
 * Date: 7/27/14
 */
?>
<?php require TPL_PATH . '/header.php'; ?>

<div class="container">
    <h2><?= i18n($this, 'dashboard') ?></h2>

    <div class="container-fluid">

        <div class="panel-group" id="accordion">
            <?php
                $list = $this->shell->execute("/usr/sbin/mast-utils list-hosts");
                foreach ($list as $key => $tunnel):
                    $rawOutput = trim(strip_tags($tunnel));
                    $output = preg_split('/[\s\t]+/', $rawOutput);
                    $tunnelName = $output[0];
                    $tunnelHost = $output[1];
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                <?= $tunnel ?>
                            </a>
                            <ul class="service nav nav-pills pull-right">
                                <?php foreach ($this->config->item('SERVICE_ACTIONS') as $action => $props): ?>
                                    <li>
                                        <button type="button" id="<?= $action ?>"
                                                class="btn btn-<?= $props['class'] ?> btn-xs btn-action">
                                            <i class="glyphicon glyphicon-<?= $props['icon'] ?>"></i>
                                            <span><?= ucfirst(i18n($this, $action)) ?></span>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                                <li>
                                    <button type="button" class="btn btn-default btn-xs btn-clear">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span><?= i18n($this, 'clear') ?></span>
                                    </button>
                                </li>
                            </ul>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body channels">
                            <ul class="service nav nav-stack">
                                <?php foreach ($this->shell->list_channels($tunnelName) as $k => $host): ?>
                                    <li><?=$host?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="bg-danger">The Kraken <strong>eat them all!</strong></p>
        <ul class="nav nav-tabs" role="tablist" id="dashboard-panes">
            <li><a href="#tunnels" role="tab" data-toggle="tab">Tunnels</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane" id="tunnels">
                <ul class="nav nav-pills">
                    <?php foreach ($this->config->item('SERVICE_HELPERS') as $helper => $props): ?>
                        <li>
                            <button type="button" id="<?= $helper ?>"
                                    class="btn btn-<?= $props['class'] ?> btn-sm btn-helper">
                                <i class="glyphicon glyphicon-<?= $props['icon'] ?>"></i>
                                <?= ucfirst(i18n($this, $helper)) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <button type="button" class="btn btn-default btn-sm btn-clear">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <?= i18n($this, 'clear') ?>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <pre class="stdout"><?= $this->shell->run("/etc/init.d/mast status"); ?></pre>
</div>
</div>

<?php require TPL_PATH . '/footer.php'; ?>
