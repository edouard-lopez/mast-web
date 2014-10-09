<?php
function action_button($this=null, $action=null, $props)
{
    $props['name'] = isset($props['name']) ? $props['name']: '';
    $props['id'] = isset($props['id']) ? $props['id']: null;
    $props['redirect'] = isset($props['redirect']) ? (string)$props['redirect']: 'true';
    $props['class'] .= isset($props['text-content']) ? null: ' hide-btn-content';
    $props['text-content'] = isset($props['text-content']) ? $props['text-content']: i18n($this, $action);

    require TPL_PATH . "action-button.php";
    unset($props['text-content']);
    unset($props['redirect']);
    return;
}

function action_form($this=null, $action=null, $fields) {
    require TPL_PATH . "action-form.php";
    return;
}