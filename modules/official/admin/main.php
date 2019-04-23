<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 03:14:58 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

//change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);

    if (!$id) die('NO');

    $query = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id;
    $result = $db->query($query);
    $numrows = $result->rowCount();
    if ($numrows > 0) {
        $active = 1;
        foreach ($result as $row) {
            if ($row['status'] == 1) {
                $active = 0;
            } else {
                $active = 1;
            }
        }
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET
				status=' . $db->quote($active) . '
				WHERE id=' . $id;
        $db->query($query);
    }
    $nv_Cache->delMod($module_name);
    Header('Location:' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    exit();
}

if ($nv_Request->isset_request('ajax_action', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $new_vid = $nv_Request->get_int('new_vid', 'post', 0);
    $content = 'NO_' . $id;
    if ($new_vid > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id!=' . $id . ' ORDER BY status ASC';
        $result = $db->query($sql);
        $status = 0;
        while ($row = $result->fetch()) {
            ++$status;
            if ($status == $new_vid) ++$status;
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET status=' . $status . ' WHERE id=' . $row['id'];
            $db->query($sql);
        }
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET status=' . $new_vid . ' WHERE id=' . $id;
        $db->query($sql);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        nv_delete_rows($id);
        $nv_Cache->delMod($module_name);
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);

    if (!empty($array_id)) {
        foreach ($array_id as $id) {
            nv_delete_rows($id);
        }
        $nv_Cache->delMod($module_name);
        die('OK');
    }
    die('NO');
}

$row = array();
$error = array();
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

$array_search = array(
    'q' => $nv_Request->get_title('q', 'post,get'),
    'part_id' => $nv_Request->get_int('part_id', 'post,get', 0)
);

$per_page = $array_config['per_page'];
$where = '';
$page = $nv_Request->get_int('page', 'post,get', 1);

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (lastname LIKE "%' . $array_search['q'] . '%"
        OR firstname LIKE "%' . $array_search['q'] . '%"
        OR unionist_code LIKE "%' . $array_search['q'] . '%"
        OR resident LIKE "%' . $array_search['q'] . '%"
        OR temporarily LIKE "%' . $array_search['q'] . '%"
        OR nation LIKE "%' . $array_search['q'] . '%"
        OR religion LIKE "%' . $array_search['q'] . '%"
        OR education LIKE "%' . $array_search['q'] . '%"
    )';
}

if (!empty($array_search['part_id'])) {
    $base_url .= '&part_id=' . $array_search['part_id'];
    $where .= 'part_id=' . $array_search['part_id'];
}

$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
    ->where('1=1' . $where);

$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('*')
    ->order('weight ASC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());
$sth->execute();

$array_part = array();
$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_part WHERE status=1');
while ($_row = $result->fetch()) {
    $array_part[$_row['id']] = $_row;
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('BASE_URL', $base_url);
$xtpl->assign('ADD_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content');
$xtpl->assign('IMPORT_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=import');

$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}

while ($view = $sth->fetch()) {
    if ($view['status'] == 1) {
        $check = 'checked';
    } else {
        $check = '';
    }
    $xtpl->assign('CHECK', $check);
    $view['birthday'] = (empty($view['birthday'])) ? '' : nv_date('d/m/Y', $view['birthday']);
    $view['gender'] = $array_gender[$view['gender']];
    $view['part_id'] = $array_part[$view['part_id']]['title'];
    $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $view['id'];
    $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
    $xtpl->assign('VIEW', $view);
    $xtpl->parse('main.loop');
}

if (!empty($array_part)) {
    foreach ($array_part as $part_id => $value) {
        $value['space'] = '';
        if ($value['lev'] > 0) {
            for ($i = 1; $i <= $value['lev']; $i++) {
                $value['space'] .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }
        $value['selected'] = $part_id == $array_search['part_id'] ? ' selected="selected"' : '';

        $xtpl->assign('PART', $value);
        $xtpl->parse('main.part_id');
    }
}

$array_action = array(
    'delete_list_id' => $lang_global['delete']
);
foreach ($array_action as $key => $value) {
    $xtpl->assign('ACTION', array(
        'key' => $key,
        'value' => $value
    ));
    $xtpl->parse('main.action_top');
    $xtpl->parse('main.action_bottom');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['main'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';