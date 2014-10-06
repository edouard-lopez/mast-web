<?php
function action_button($this=null, $action=null, $props)
{
    $props['name'] = isset($props['name']) ? $props['name']: '';
    $props['redirect'] = isset($props['redirect']) ? (string)$props['redirect']: 'true';
    $props['text-content'] = isset($props['text-content']) ? $props['text-content']: '';

    require TPL_PATH . "action-button.php";
    unset($props['text-content']);
    unset($props['redirect']);
    return;
}

function action_form($this=null, $action=null, $fields) {
    require TPL_PATH . "action-form.php";
    return;
}