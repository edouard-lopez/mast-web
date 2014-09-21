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
        'form-fields' => array(
            'NAME',
        )
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
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
            'REMOTE_HOST' => array('pattern' => REGEX_HOST),
        )
    ),
    'remove-host' => array(
        'class' => 'btn-danger',
        'icon' => 'glyphicon-remove-sign',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
        )
    ),
    'list-channels' => array(
        'class' => 'btn-info',
        'icon' => 'glyphicon-random',
    ),
    'add-channel' => array(
        'class' => 'btn-success',
        'icon' => 'glyphicon-print',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
            'PRINTER' => array('pattern' => REGEX_HOST),
            'DESC' => array(),
        )
    ),
    'remove-channel' => array(
        'class' => 'btn-danger',
        'icon' => 'glyphicon-remove-sign',
        'form-fields' => array(
            'ID' => array(),
            'NAME' => array('pattern' => REGEX_NAME),
        )
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
    'deploy-code_BAT' => array(
       'class' => 'batCode btn-default',
       'icon' => 'glyphicon-comment',
    ),
    'deploy-code_PS1' => array(
       'class' => 'ps1Code btn-primary',
       'icon' => 'glyphicon-comment',
    ),
    'remove-channel' => array(
        'class' => 'btn-danger',
        'icon' => 'glyphicon-remove-sign',
        'form-fields' => array(
            'ID' => array(),
            'NAME' => array('pattern' => REGEX_NAME),
        )
    ),
);
$config['PROJECT'] = 'Mast web';
$config['PROJECT.html'] = '<abbr title="Multiple Auto-SSH Tunnels web" class="initialism">MAST</abbr>-web';

define('MAST_SERVICE', '/etc/init.d/mast');
define('MAST_UTILS', '/usr/sbin/mast-utils');
define('REGEX_IP_ADRESS', '25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}');
