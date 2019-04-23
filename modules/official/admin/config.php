<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$page_title = $lang_module['config'];

$data = array();
if ($nv_Request->isset_request('savesetting', 'post')) {
    $data['per_page'] = $nv_Request->get_int('per_page', 'post', 20);
    $data['detail_style'] = $nv_Request->get_int('dstyle', 'post', 1);
    $data['home_data'] = $nv_Request->get_int('home_data', 'post', 1);
    $data['home_view'] = $nv_Request->get_title('home_view', 'post', 'viewlist');
    $data['order_by'] = $nv_Request->get_title('order_by', 'post', 'firstname');
    $data['order_type'] = $nv_Request->get_title('order_type', 'post', 'asc');

    $sth = $db->prepare("UPDATE " . NV_PREFIXLANG . '_' . $module_data . "_config SET config_value = :config_value WHERE config_name = :config_name");
    foreach ($data as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['config'], "Config", $admin_info['userid']);
    $nv_Cache->delMod($module_name);

    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . '=' . $op);
    die();
}

$xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('DATA', $array_config);

$array_detail_style = array(
    1 => $lang_module['config_detail_style_1'],
    2 => $lang_module['config_detail_style_2']
);
foreach ($array_detail_style as $index => $value) {
    $sl = $index == $array_config['detail_style'] ? 'selected="selected"' : '';
    $xtpl->assign('DSTYLE', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.dstyle');
}

$array_home_data = array(
    1 => $lang_module['config_home_data_1'],
    2 => $lang_module['config_home_data_2']
);
foreach ($array_home_data as $index => $value) {
    $sl = $index == $array_config['home_data'] ? 'selected="selected"' : '';
    $xtpl->assign('HOME_DATA', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.home_data');
}

$array_home_view = array(
    'viewlist' => $lang_module['config_home_viewlist'],
    //'viewgrid' => $lang_module['config_home_viewgrid']
);
foreach ($array_home_view as $index => $value) {
    $sl = $index == $array_config['home_view'] ? 'selected="selected"' : '';
    $xtpl->assign('HOME_VIEW', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.home_view');
}

$array_order_by = array(
    'firstname' => $lang_module['config_order_by_firstname'],
    'lastname' => $lang_module['config_order_by_lastname'],
    'addtime' => $lang_module['config_order_by_addtime']
);
foreach ($array_order_by as $index => $value) {
    $sl = $index == $array_config['order_by'] ? 'selected="selected"' : '';
    $xtpl->assign('ORDER_BY', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.order_by');
}

$array_order_type = array(
    'asc' => $lang_module['config_order_type_asc'],
    'desc' => $lang_module['config_order_type_desc']
);
foreach ($array_order_type as $index => $value) {
    $sl = $index == $array_config['order_type'] ? 'selected="selected"' : '';
    $xtpl->assign('ORDER_TYPE', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.order_type');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';