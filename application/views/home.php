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
            <?php
                $list = $this->shell->execute("/usr/sbin/mast-utils list-hosts");
                foreach ($list as $key => $tunnel){
                    preg_match(
                        '/^(.*\w)[\s\t]+(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3})(\:([0-9]{1,5}))?/',
                        trim(strip_tags($tunnel)),
                        $ConfSite);
                    $channels = $this->shell->list_channels($ConfSite[1]);
                    $ChannelsSite=array();
                    foreach ($channels as $key => $channel){
                        preg_match(
                            '/^(.*):([0-9]{1,5}):(.*):([0-9]{1,5})$/',
                            trim(strip_tags($channel)),
                            $ChannelSite);
                        $ChannelsSite[]=array(
                            'listenPort'=>$ChannelSite[2],
                            'remoteHost'=>$ChannelSite[3],
                            'remotePort'=>$ChannelSite[4]
                            );
                    }

                    $obj[$ConfSite[1]] = array(
                        // "nameSite" => $ConfSite[1];
                        'remoteHost' => $ConfSite[2],
                        'remotePort' => count($ConfSite)>=6?$ConfSite[6]:22,
                        'channels' => $ChannelsSite
                    );
                }
                // echo "<pre>";
                // var_export($obj);
            ?>

<div class="container">
    <h2><?= i18n($this, 'dashboard') ?></h2>
    <div class="container-fluid">
        <div class="panel-group" id="accordion" data-obj='<?=json_encode($obj)?>'>
            <?php foreach ($obj as $site => $siteConfig) {?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> <?= $site ?></a>
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
                            </ul>
                            <button type="button" class="remoteHost btn btn-xs btn-default pull-left" data-rm='<?=json_encode($siteConfig)?>'>
                                 <i class="glyphicon glyphicon-repeat"></i>
                            </button>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body channels">
                            <ul class="service nav nav-stack">
                                <?php
                                // var_export($siteConfig['channels']);
                                foreach ($siteConfig['channels'] as $channel){
                                    echo "<li>";
                                    echo "  <p>";
                                    echo "<button type='button' class='remoteHost btn btn-xs btn-default pull-leftx' data-rm='".json_encode($channel)."'>";
                                    echo "  <i class='glyphicon glyphicon-repeat'></i>";
                                    echo "</button>";
                                    echo "<a href='http://".$channel['remoteHost']."/'>".$channel['remoteHost']."</a> on port ".$channel['listenPort']."</p>";
                                    echo "</li>";
                                } ?>
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
