<?php
/**
 * User: ed8
 * Date: 7/27/14
 */

/**
* Whitelist service actions
* @param :{string} class HTML class for the button
* @param :{string} icon glyphicon class
*/
$config['SERVICE_ACTIONS'] = array(
//    'start' => array(
//        'class' => 'btn-success',
//        'icon' => 'glyphicon-play',
//    ),
//    'stop' => array(
//        'class' => 'btn-danger',
//        'icon' => 'glyphicon-stop',
//    ),
//    'restart' => array(
//        'class' => 'btn-warning',
//        'icon' => 'glyphicon-refresh',
//    ),
    'remove-host' => array(
        'class' => 'btn-danger',
        'icon' => 'glyphicon-remove-sign',
    ),
    'add-chanel' => array(
        'class' => 'btn-success',
        'icon' => 'glyphicon-print',
    ),
//    'status' => array(
//        'class' => 'btn-info',
//        'icon' => 'glyphicon-search',
//    ),
);
$config['SERVICE_HELPERS'] = array(
    'add-host' => array(
        'class' => 'btn-success',
        'icon' => 'glyphicon-plus-sign',
    ),
    'remove-host' => array(
        'class' => 'btn-danger',
        'icon' => 'glyphicon-remove-sign',
    ),
    'list-channels' => array(
        'class' => 'btn-info',
        'icon' => 'glyphicon-random',
    ),
    'list-hosts' => array(
        'class' => 'btn-info',
        'icon' => 'glyphicon-list',
    ),
    'list-logs' => array(
        'class' => 'btn-info',
        'icon' => 'glyphicon-info-sign',
    ),
    'cp-logs' => array(
        'class' => 'btn-info',
        'icon' => 'glyphicon-floppy-save',
    ),
);
$config['SERVICE_CH_HELPERS'] = array(
    'deploy-code_dos' => array(
       'class' => 'btn-default',
       'icon' => 'glyphicon-comment',
    ),
    'deploy-code_PS1' => array(
       'class' => 'btn-primary',
       'icon' => 'glyphicon-comment',
    ),
    'remove-channel' => array(
       'class' => 'btn-danger',
       'icon' => 'glyphicon-remove-sign',
    ),
);
$config['PROJECT'] = 'Mast web';
$config['PROJECT.html'] = '<abbr title="Multiple Auto-SSH Tunnels web" class="initialism">MAST</abbr>-web';

define('MAST_SERVICE', '/etc/init.d/mast');
define('MAST_UTILS', '/usr/sbin/mast-utils');