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
    'start' => array(
        'class' => 'success',
        'icon' => 'play',
    ),
    'stop' => array(
        'class' => 'danger',
        'icon' => 'stop',
    ),
    'restart' => array(
        'class' => 'warning',
        'icon' => 'refresh',
    ),
    'list' => array(
        'class' => 'info',
        'icon' => 'list',
    ),
    'list-log' => array(
        'class' => 'info',
        'icon' => 'info-sign',
    ),
);
$config['SERVICE_HELPERS'] = array(
    'add-host' => array(
        'class' => 'success',
        'icon' => 'plus-sign',
    ),
    'remove-host' => array(
        'class' => 'danger',
        'icon' => 'remove-sign',
    ),
);
$config['PROJECT'] = 'Mast web';
$config['PROJECT.html'] = '<abbr title="Multiple Auto-SSH Tunnels web" class="initialism">MAST</abbr>-web';