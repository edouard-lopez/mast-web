<?php require TPL_PATH . '/header.php'; ?>

<div id="dangerous-area">
    <div class="child jumbotron alert-danger">
        <h1>
            <i class="glyphicon glyphicon-exclamation-sign"></i>
            <br/>
            <?= i18n($this, 'dangerous-area') ?>
        </h1>

        <p>
            <?= i18n($this, 'dangerous-area.explain') ?>
        </p>
        <button id="accept-danger" class="btn btn-success"><i
                class="glyphicon glyphicon-ok"></i> <?= i18n($this, 'dangerous-area.accept') ?></button>
    </div>
</div>

<div class="container">
    <h3 id="dashboard" class="anchor">
        <?=i18n($this, 'dashboard')?>
        <small><a href="#dashboard" class="text-muted">#dashboard</a></small>
    </h3>

    <?php
        $action = 'add-channel';
        require TPL_PATH . "action-form.php";?>
    <?php
        $action = 'add-host';
        require TPL_PATH . "action-form.php";?>

    <div class="container-fluid">
        <div class="panel-group" id="accordion" data-configs='<?= json_encode($configs) ?>'>
            <?php foreach ($configs as $tunnel => $tunnelConfig) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
<!--                            <button type="button"-->
<!--                                    class="remoteHost glyphicon glyphicon-repeat btn btn-xs btn-default pull-left"-->
<!--                                    data-rm='--><?//= json_encode($tunnelConfig) ?><!--'>-->
<!--                            </button>-->
                            <a data-toggle="collapse" data-parent="#accordion"
                               href="#collapse-<?= $tunnel; ?>"> <?= $tunnel . ' - ' . $tunnelConfig['remoteHost'] ?></a>
                            <ul class="service nav nav-pills pull-right">
                                <?php
                                $host_actions = array(
                                    'remove-host' => $this->config->item('SERVICE_ACTIONS')['remove-host'],
                                    'add-channel' => $this->config->item('SERVICE_HELPERS')['add-channel'],
                                );
                                foreach ($host_actions as $action => $props):?>
                                    <li>
                                        <button type="button" id="<?= $action ?>"
                                                class="btn btn-xs <?= $props['class'] ?>">
                                            <i class="glyphicon <?= $props['icon'] ?>"></i>
                                            <span><?= ucfirst(i18n($this, $action)) ?></span>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </h4>
                    </div>
                    <div id="collapse-<?= $tunnel; ?>" class="panel-collapse collapse in">
                        <div class="panel-body channels">
                            <ul class="service nav nav-stack">
                                <?php
                                // var_export($siteConfig['channels']);
                                foreach ($tunnelConfig['channels'] as $channel) {
                                    ?>
                                    <li>
<!--                                      <span>-->
<!--                                          <button type='button' class='remoteHost glyphicon glyphicon-repeat btn btn-xs btn-default pull-left'-->
<!--                                                  data-rm='--><?//= json_encode($channel) ?><!--'>-->
<!--                                          </button>-->
<!--                                          <span class='glyphicon glyphicon-print' ></span>-->
<!--                                      </span>-->
                                        <span>
                                            <a href='http://<?= $channel['remoteHost'] ?>/'><?= $channel['remoteHost'] ?></a> by port <?= $channel['localPort'] ?>
                                        </span>
<!--                                        <ul class="service nav nav-pills pull-right">
                                            <?php /*foreach ($this->config->item('SERVICE_CH_HELPERS') as $action => $props): */?>
                                                <li>
                                                    <button id="<?/*= $action */?>" class="btn btn-xs <?/*= $props['class'] */?>
                                                glyphicon <?/*= $props['icon'] */?>"
                                                            data-script='<?/*= json_encode(array(
                                                                'site' => $tunnel,
                                                                'vps' => $_SERVER['HTTP_HOST'],
                                                                'port' => $channel['localPort'],
                                                                'imp' => $channel['remoteHost'],
                                                                'comment' => $channel['comment']
                                                            )) */?>'>
                                                        <span><?/*= ucfirst(i18n($this, $action)) */?></span>
                                                    </button>
                                                </li>
                                            <?php /*endforeach; */?>
                                        </ul>-->
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
        <!--         <ul class="nav nav-tabs" role="tablist" id="dashboard-panes">
                    <li><a href="#tunnels" role="tab" data-toggle="tab">Tunnels</a></li>
                </ul> -->

        <!-- Tab panes -->
        <!-- <div class="tab-content"> -->
        <h3 id="cnc" class="anchor">
            <?=i18n($this, 'command-and-control')?>
            <small><a href="#cnc" class="text-muted">#cnc</a></small>
        </h3>
        <div class="tab-pane" id="tunnels">
            <ul class="nav nav-pills">
                <?php foreach ($this->config->item('SERVICE_HELPERS') as $helper => $props): ?>
                    <li>
                        <button type="button" id="<?= $helper ?>"
                                class="btn btn-sm <?= $props['class'] ?> btn-helper">
                            <i class="glyphicon <?= $props['icon'] ?>"></i>
                            <?= ucfirst(i18n($this, $helper)) ?>
                        </button>
                    </li>
                <?php endforeach; ?>
                <li>
                    <button type="button" class="btn btn-default btn-sm btn-clear glyphicon glyphicon-ban-circle">
                        <?= i18n($this, 'clear') ?>
                    </button>
                </li>
            </ul>
            <!-- </div> -->
        </div>
    </div>
</div>
<br/>
<div class="container-fluid">
    <pre class="stdout"><?= $this->shell->run("/etc/init.d/mast status"); ?></pre>
</div>
</div>

<?php require TPL_PATH . '/footer.php'; ?>
