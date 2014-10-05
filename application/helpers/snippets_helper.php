<?php
function action_button($this=null, $action=null, $props, $redirect = true)
{
    $props['name'] = isset($props['name']) ? $props['name']: '';
    $props['text-content'] = isset($props['text-content']) ? $props['text-content']: '';

    require TPL_PATH . "action-button.php";
    unset($props['text-content']);
    return;
}

function action_form($this=null, $action=null, $fields) {
    require TPL_PATH . "action-form.php";
    return;
}