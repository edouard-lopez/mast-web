<?
/**
 * User: ed8
 * Date: 7/27/14
 */
?>
<?php require TPL_PATH . '/header.php'; ?>

<style type="text/css">
    .layerFull{
        width: 100%;
        height: 100%;
        opacity: 0.7;
        background-color: #eee;
        position: absolute;
    }

    #parent {
        z-index: 1000;
        width: 100%;
        height: 100%;
        position: fixed;
        display: table;
        top: 0;
        left: 0;
    }

    .child {
        z-index: 1001;
        opacity: 0.99;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
    }
</style>

<div id="parent" onclick="javascript:$(this).hide();">
    <div class="layerFull"></div>
    <div class="child">
        <h2 class="bg-danger">----------------<br/>
            <strong>WARNING :</strong> Vous etes sur une interface d'administration,<br/>
            <strong> manipuler avec precaution!</strong><br/>----------------
        </h2>
    </div>
</div>

<div class="container">
    <h2><?= i18n($this, 'dashboard') ?></h2>
    <div class="container-fluid">
        <div class="panel-group" id="accordion" data-obj='<?=json_encode($obj)?>'>
            <?php foreach ($obj as $site => $siteConfig) {?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <button style='padding:4px 5px;margin:-4px 10px 0 -2px;' type="button" class="remoteHost glyphicon glyphicon-repeat btn btn-xs btn-default pull-left" data-rm='<?=json_encode($siteConfig)?>'>
                            </button>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> <?= $site.' - '.$siteConfig['remoteHost'] ?></a>
                            <ul class="service nav nav-pills pull-right">
                                <?php foreach ($this->config->item('SERVICE_ACTIONS') as $action => $props): ?>
                                    <li>
                                        <button type="button" id="<?= $action ?>" class="btn btn-xs <?= $props['class'] ?> glyphicon <?= $props['icon'] ?>">
                                            <span><?= ucfirst(i18n($this, $action)) ?></span>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body channels">
                            <ul class="service nav nav-stack">
                                <?php
                                // var_export($siteConfig['channels']);
                                foreach ($siteConfig['channels'] as $channel) {
                                ?>
                                    <li>
                                      <span>
                                          <button style='padding:2px 3px;margin:-6px 20px 0 0;' type='button' class='remoteHost glyphicon glyphicon-repeat btn btn-xs btn-default pull-leftx'
                                          data-rm='<?=json_encode($channel)?>'>
                                          </button>
                                          <span class='glyphicon glyphicon-print' style='margin:0 10px 0 0;'></span>

                                    <a href='http://".$channel['remoteHost']."/'><?=$channel['remoteHost']?></a> by port <?=$channel['listenPort']?></span>
                                    <ul class="service nav nav-pills pull-right">
                                        <?php foreach ($this->config->item('SERVICE_CH_HELPERS') as $action => $props): ?>
                                            <li>
                                                <button type="button" id="<?= $action ?>" class="btn btn-xs <?= $props['class'] ?> glyphicon <?= $props['icon'] ?>"
                                                        data-script='<?=json_encode(array('site'=>$site,'vps'=>$_SERVER['HTTP_HOST'],'port'=>$channel['listenPort'], 'channelComment'=>'Commemtaire HP'))?>'>
                                                    <span><?= ucfirst(i18n($this, $action)) ?></span>
                                                </button>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
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
            <div class="tab-pane" id="tunnels">
                <ul class="nav nav-pills">
                    <?php foreach ($this->config->item('SERVICE_HELPERS') as $helper => $props): ?>
                        <li>
                            <button type="button" id="<?= $helper ?>"
                                    class="btn btn-sm <?= $props['class'] ?> btn-helper glyphicon <?= $props['icon'] ?>">
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
