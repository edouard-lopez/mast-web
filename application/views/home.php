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
        <?= i18n($this, 'dashboard') ?>
        <small><a href="#dashboard" class="text-muted">#dashboard</a></small>
    </h3>

    <?php
    $action = 'add-host';
    $props = $this->config->item('SERVICE_HELPERS')[$action];
    $text_content = i18n($this, $action);
    require TPL_PATH . "action-form.php";
    require TPL_PATH . "action-button.php";
    ?>
    <div class="container-fluid">
        <div class="panel-group" id="accordion"
             data-configs='<?= json_encode($configs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
            <?php foreach ($configs as $tunnel => $tunnelConfig) { ?>
                <div id="tunnel_<?= md5($tunnel) ?>" class="panel panel-default tunnel"
                     data-tunnel='<?= json_encode($tunnelConfig, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                    <div class="panel-heading">
                        <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $tunnel ?>">
                            <i id="x<?= md5($tunnelConfig['remoteHost'] . ':' . $tunnelConfig['remotePort']) ?>"
                               class='hide'
                               data-html="true" data-toggle="tooltip" data-placement="top"
                               title="Host Unreachable!"> </i>
                            <span class="tunnel-name"> <?= $tunnel ?> </span>
                            <span class="divider"> – </span>
                            <span class="tunnel-fqdn"> <?= $tunnelConfig['remoteHost'] ?> </span>
                        </h4>
                        <ul class="nav nav-pills nav-action pull-right">
                                    <?php
                                    $host_actions = array(
                                        'status' => $this->config->item('SERVICE_ACTIONS')['status'],
                                        'add-channel' => $this->config->item('SERVICE_HELPERS')['add-channel'],
                                    );
                                    foreach ($host_actions as $action => $props):
                                        $name = $tunnel;
                                        $text_content = null;
                                    ?>
                                        <li>
                                            <?php require TPL_PATH . "action-button.php"; ?>
                                        </li>
                                    <?php endforeach ?>
                            <li class="divider"></li>
                            <?php
                            $host_actions = array(
                                'restart' => $this->config->item('SERVICE_ACTIONS')['restart'],
                                'start' => $this->config->item('SERVICE_ACTIONS')['start'],
                                'stop' => $this->config->item('SERVICE_ACTIONS')['stop'],
                            );
                            ?>
                            <?php foreach ($host_actions as $action => $props):?>
                            <li>
                                <?php require TPL_PATH . "action-button.php"; ?>
                            </li>
                            <?php endforeach; ?>
                            <li class="divider"></li>
                            <li>
                            <?php
                                $action = 'remove-host';
                                $props = $this->config->item('SERVICE_HELPERS')[$action];
                                require TPL_PATH . "action-button.php";
                            ?>
                            </li>
                        </ul>

                    </div>
                    <div id="collapse-<?= $tunnel ?>" class="panel-collapse collapse in">
                        <div class="panel-body channels">
                            <ul class="service nav nav-stack list-striped">
                                <?php foreach ($tunnelConfig['channels'] as $channel) {
                                    require TPL_PATH . 'channel-row.php';
                                } ?>
                            </ul>
                            <div>
                                <?php
                                $action = 'add-channel';
                                $props = $this->config->item('SERVICE_HELPERS')[$action];
                                $text_content = i18n($this, $action);
                                require TPL_PATH . "action-button.php";
                                require TPL_PATH . "action-form.php"
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>

        <!-- Tab panes -->
        <!-- <div class="tab-content"> -->
        <h3 id="cnc" class="anchor">
            <?= i18n($this, 'command-and-control') ?>
            <small><a href="#cnc" class="text-muted">#cnc</a></small>
        </h3>
        <div class="tab-pane" id="tunnels">
            <ul class="cnc nav nav-pills">
                <?php
                $buttons = array(
                    'list-channels' => $this->config->item('SERVICE_HELPERS')['list-channels'],
                    'list-hosts' => $this->config->item('SERVICE_HELPERS')['list-hosts'],
                );
                ?>
                <?php foreach ($buttons as $helper => $props): ?>
                    <li>
                        <a role="button" id="<?= $helper ?>"
                           class="btn btn-default btn-xs <?= $props['class'] ?> btn-helper">
                            <i class="<?= $props['icon'] ?>"></i>
                            <?= ucfirst(i18n($this, $helper)) ?>
                        </a>
                    </li>
                <?php endforeach ?>
                <li>
                    <a href="#" role="button" class="btn btn-default btn-xs btn-clear">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <?= i18n($this, 'clear') ?>
                    </a>
                </li>
            </ul>
            <!-- </div> -->
        </div>
    </div>
</div>
<br/>
<div class="container-fluid">
    <pre class="stdout">
        <?php
            require_once APPPATH . "/controllers/action.php";
            $console = new Action();
            $console->invoke("status");
        ?>
    </pre>
</div>
</div>

<?php require TPL_PATH . '/footer.php' ?>
