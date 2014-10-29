<?php
/**
 * User: ed8
 * Date: 7/27/14
 */


define('MAST_SERVICE', '/etc/init.d/mast');
define('MAST_UTILS', '/usr/sbin/mast-utils');

define('TPL_PATH', APPPATH . '/views/tpl/');

define('REGEX_IP_ADRESS', '25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}');
define('REGEX_NAME', '[a-zA-Z0-9_:\-\s]+');
define('REGEX_HOST', '((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$');
define('REGEX_DESC', '.*');

$config['cheat-code'] = '#im=smart';

/**
 * Whitelist service actions
 * @param :{string} class HTML class for the button
 * @param :{string} icon glyphicon class
 * @param :{array} form-fields list of expected fields. Each field must have a validating pattern
 */
$config['SERVICE_ACTIONS'] = array(
    'start' => array(
        'class' => 'btn-success btn-action',
        'icon' => 'glyphicon glyphicon-play',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
        )

    ),
    'stop' => array(
        'class' => 'btn-danger btn-action',
        'icon' => 'glyphicon glyphicon-stop',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
        )

    ),
    'restart' => array(
        'class' => 'btn-warning btn-action restart',
        'icon' => 'glyphicon glyphicon-refresh',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
        )

    ),
    'status' => array(
        'class' => 'btn-info btn-action',
        'icon' => 'glyphicon glyphicon-info-sign',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
        )

    ),
);


$config['SERVICE_HELPERS'] = array(
    'list-hosts' => array(
        'class' => 'btn-info btn-action',
        'icon' => 'glyphicon glyphicon-list',
    ),

    'add-host' => array(
        'class' => 'btn-success btn-action',
        'icon' => 'glyphicon glyphicon-plus',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
            'REMOTE_HOST' => array('pattern' => REGEX_HOST),
        )
    ),
    'remove-host' => array(
        'class' => 'btn-danger-disabled btn-action',
        'icon' => 'glyphicon glyphicon-trash',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
        )
    ),

    'list-channels' => array(
        'class' => 'btn-info btn-action',
        'icon' => 'glyphicon glyphicon-random',
    ),
    'add-channel' => array(
        'class' => 'btn-success btn-action',
        'icon' => 'glyphicon glyphicon-plus-sign glyphicon-print',
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
            'PRINTER' => array('pattern' => REGEX_HOST),
            'DESC' => array('pattern' => REGEX_DESC),
        )
    ),
    'remove-channel' => array(
        'class' => 'btn-danger-disabled btn-action',
        'icon' => 'glyphicon glyphicon-trash',
        'form-fields' => array(
            'ID' => array(),
            'NAME' => array('pattern' => REGEX_NAME),
        )
    ),
    'link' => array(
        'class' => 'btn-default btn-action',
        'icon' => 'glyphicon glyphicon-comment',
        'redirect' => "./home/getScript/PORTS/",
        'form-fields' => array(
            'NAME' => array('pattern' => REGEX_NAME),
        )
    ),
    'list-logs' => array(
        'class' => 'btn-info btn-action',
        'icon' => 'glyphicon glyphicon-info',
    ),
    'cp-logs' => array(
        'class' => 'btn-info btn-action',
        'icon' => 'glyphicon glyphicon-floppy-save',
    ),
);


# todo: what is SERVICE_CH_HELPERS?
$config['SERVICE_CH_HELPERS'] = array(
    'deploy-code_BAT' => array(
        'class' => 'batCode btn-default',
        'icon' => 'glyphicon glyphicon-comment',
    ),
    'deploy-code_PS1' => array(
        'class' => 'ps1Code btn-primary',
        'icon' => 'glyphicon glyphicon-comment',
    ),
    'remove-channel' => array(
        'class' => 'btn-danger',
        'icon' => 'glyphicon glyphicon-remove',
        'form-fields' => array(
            'ID' => array(),
            'NAME' => array('pattern' => REGEX_NAME),
        )
    ),
);
$config['PROJECT'] = 'Mast web';
$config['PROJECT.html'] = '<abbr title="Multiple Auto-SSH Tunnels web" class="initialism">MAST</abbr>-web';
