<li id="channel_<?=md5($channel['remoteHost'].$channel['localPort'])?>" data-channel='<?= json_encode($channel,
    JSON_HEX_APOS | JSON_HEX_QUOT) ?>' class='channel'>
    <span>
        <i id="x<?=md5($channel['remoteHost'].':'.$channel['remotePort'].':'.$channel['localPort'])?>" class='hide'
           data-html="true" data-toggle="tooltip" data-placement="top"></i>
        <a href='http://<?= $channel['remoteHost'] ?>/' target="_blank"><?= $channel['remoteHost'] ?></a>
        <span> by port <?= $channel['localPort'] ?></span>
        <i class="text-muted"> – <?= $channel['comment'] ?></i>
    </span>
    <ul class="nav-action list-inline pull-right">
        <?php if ((int)$channel['remotePort']==9100): ?>
        <li>
        <?php
            $action = 'link';
            $props = $this->config->item('SERVICE_HELPERS')['link'];
            $props['name'] = $tunnel;
            $props['href']="./home/getScript/BAT/".
                                urlencode(
                                    base64_encode(
                                        json_encode(
                                            array(
                                                'site' => $tunnel,
                                                'vps' => $_SERVER['HTTP_HOST'],
                                                'port' => $channel['localPort'],
                                                'remotePort' => $channel['remotePort'],
                                                'imp' => $channel['remoteHost'],
                                                'channelComment' => $channel['comment']
                                            ))));
            action_button($this, $action, $props);
        ?>
       </li>
        <li class="divider"></li>
        <?php endif ?>
        <li>
            <?php
                $action = 'remove-channel';
                $props = $this->config->item('SERVICE_HELPERS')[$action];
                $props['id'] = $cid;
                $props['name'] = $tunnel;
                $props['redirect'] = false;
                action_button($this, $action, $props);
            ?>
        </li>
    </ul>
</li>
