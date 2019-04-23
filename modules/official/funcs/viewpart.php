<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

if (!defined('NV_IS_MOD_OFFICIAL')) die('Stop!!!');

$array_data = array();
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_part[$part_id]['alias'];

$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
    ->where('status=1 AND part_id=' . $part_id);

$all_page = $db->query($db->sql())
    ->fetchColumn();

$db->select('*')
    ->order(nv_make_order())
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$_query = $db->query($db->sql());
$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
while ($row = $_query->fetch()) {
    $row['number'] = $number++;

    $row['jobtitle'] = array();
    $result = $db->query('SELECT jobtitle_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_jobtitle WHERE rows_id=' . $row['id']);
    while (list ($jobtitle_id) = $result->fetch(3)) {
        $row['jobtitle'][] = $jobtitle_id;
    }

    $array_data[$row['id']] = $row;
}

$lang_module['part_title'] = sprintf($lang_module['part_title'], $array_part[$part_id]['title']);
$generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);

$part_info = $array_part[$part_id];
$page_title = $part_info['title'];
$array_mod_title[] = array(
    'title' => $page_title,
    'link' => $part_info['link']
);

$contents = nv_theme_official_viewpart($part_info, $array_data, $array_config['home_view'], $generate_page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';