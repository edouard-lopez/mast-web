<li id="channel_<?=md5($channel['remoteHost'])?>" data-channel='<?= json_encode($channel,
    JSON_HEX_APOS | JSON_HEX_QUOT) ?>' class='channel'>
    <span>
        <i id="x<?=md5($channel['remoteHost'].':'.$channel['remotePort'])?>" class='hide'
           data-html="true" data-toggle="tooltip" data-placement="top"></i>
        <a href='http://<?= $channel['remoteHost'] ?>/'><?= $channel['remoteHost'] ?></a>
        <span> by port <?= $channel['localPort'] ?></span>
        <i class="text-muted"> – <?= $channel['comment'] ?></i>
    </span>
    <ul class="nav-action list-inline pull-right">
        <li>
        <a id="" class="btn btn-xs btn-default glyphicon glyphicon-comment " href="./home/getScript/BAT/<?= urlencode(base64_encode(json_encode(array(
                'site' => $tunnel,
                'vps' => $_SERVER['HTTP_HOST'],
                'port' => $channel['localPort'],
                'imp' => $channel['remoteHost'],
                'channelComment' => $channel['comment']
            ))))?>" target="_blank">
        </a>
        </li>
        <li class="divider"></li>
        <li>
            <?php
                $action = 'remove-channel';
                $props = $this->config->item('SERVICE_HELPERS')[$action];
                $props['id'] = $cid;
                $props['name'] = $tunnel;
                action_button($this, $action, $props);
            ?>
        </li>
    </ul>

</li>
