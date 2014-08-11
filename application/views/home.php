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
        <button id="accept-danger" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i> <?= i18n($this, 'dangerous-area.accept') ?></button>
    </div>
</div>

<div class="container">
    <h2><?= i18n($this, 'dashboard') ?></h2>
    <div class="container-fluid">
        <div class="panel-group" id="accordion" data-configs='<?=json_encode($configs)?>'>
            <?php foreach ($configs as $tunnel => $tunnelConfig) {?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <button style='padding:4px 5px;margin:-4px 10px 0 -2px;' type="button" class="remoteHost glyphicon glyphicon-repeat btn btn-xs btn-default pull-left"
                                    data-rm='<?=json_encode($tunnelConfig)?>'>
                            </button>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> <?= $tunnel.' - '.$tunnelConfig['remoteHost'] ?></a>
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
                                foreach ($tunnelConfig['channels'] as $channel) {
                                ?>
                                    <li>
                                      <span>
                                          <button style='padding:2px 3px;margin:-6px 20px 0 0;' type='button' class='remoteHost glyphicon glyphicon-repeat btn btn-xs btn-default pull-leftx'
                                          data-rm='<?=json_encode($channel)?>'>
                                          </button>
                                          <span class='glyphicon glyphicon-print' style='margin:0 10px 0 0;'></span>

                                    <a href='http://<?=$channel['remoteHost']?>/'><?=$channel['remoteHost']?></a> by port <?=$channel['localPort']?></span>
                                    <ul class="service nav nav-pills pull-right">
                                        <?php foreach ($this->config->item('SERVICE_CH_HELPERS') as $action => $props): ?>
                                            <li>
                                                <button type="button" id="<?= $action ?>" class="btn btn-xs <?= $props['class'] ?> glyphicon <?= $props['icon'] ?>"
                                                        data-script='<?=json_encode(array(
                                                            'site'=>$tunnel,
                                                            'vps'=>$_SERVER['HTTP_HOST'],
                                                            'port'=>$channel['localPort'],
                                                            'imp'=>$channel['remoteHost'],
                                                            'comment'=>$channel['comment']
                                                        ))?>'>
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
<script type="text/javascript">
// afichage en blanc sur fond noir
var BAT_install_code = "\
# DOS – Batch XP+\
# Creaton du port GZ\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\prnport.vbs -a -o raw -h %vps% -r \"GZ_%vps%_%port%\" -n %port%\
# Creaton du port de secour en direct\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\prnport.vbs -a -o raw -h %imp% -r \"DIRECT_%imp%_%port%\"\
# Install du driver\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prndrvr.vbs -a -m \"MS Publisher Color Printer\"\
# Creation de l’objet imprimante\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prnmngr.vbs -a -p \"%name%\" -r \"GZ_%vps%_%port%\" -m \"MS Publisher Color Printer\"\
# ajout des infos : emplacement et commentaire\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prncnfg.vbs -t -p \"%name%\" -l \"%site%\" -m \"GZ par tunnel SSH (%UTC%)`n%imp% par le canal %port%\"\
";

function BAT(){

}

// affichage en blanc sur fond bleu foncé
var PS1_install_code = "\
# Powershell V4+ Windows 2012R2\
# Creaton du port\
Add-PrinterPort -Name \"GZ_%vps%_%port%\" -PrinterHostAddress \"%vps%\" -PortNumber %port%\
# Creaton du port de secour en direct\
Add-PrinterPort -Name \"DIRECT_%imp%_%port%\" -PrinterHostAddress \"%imp%\"\
# Install du driver\
if (Get-PrinterDriver -Name \"MS Publisher Color Printer\") {\
    Write-Host \"Pilote Generique deja present\"\
} else {\
    Write-Host \"Installation du pilote generique : MS Publisher Color Printer\"\
    Add-PrinterDriver \"MS Publisher Color Printer\"\
}\
# Creation de l’objet imprimante\
Add-Printer -name \"%name%\" -PortName \"GZ_%vps%_%port%\" -Location \"%site%\" -Comment \"GZ par tunnel SSH (%UTC%)\"  -DriverName \"MS Publisher Color Printer\"\
";

function PS1(){

}
</script>
<?php require TPL_PATH . '/footer.php'; ?>
