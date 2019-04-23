<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

if (!defined('NV_IS_MOD_OFFICIAL')) die('Stop!!!');

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$contents = '';
$array_data = array();

if ($array_config['home_data'] == 1) {
    $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
        ->where('status=1');

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

    $generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
    $contents = nv_theme_official_main($array_data, $array_config['home_data'], $array_config['home_view'], $generate_page);
} elseif ($array_config['home_data'] == 2) {
    if (!empty($array_part)) {
        foreach ($array_part as $index => $part) {
            $data = array();
            if ($part['parentid'] == 0) {
                $listid = nv_getcatid_inparent($part['id']);
                $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status=1 AND part_id IN (' . implode(',', $listid) . ')');
                $i = 1;
                while ($row = $result->fetch()) {
                    $row['number'] = $i++;

                    $row['jobtitle'] = array();
                    $_result = $db->query('SELECT jobtitle_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_jobtitle WHERE rows_id=' . $row['id']);
                    while (list ($jobtitle_id) = $_result->fetch(3)) {
                        $row['jobtitle'][] = $jobtitle_id;
                    }

                    $data[$row['id']] = $row;
                }
                if(!empty($data)){
                    $array_data[$index] = array(
                        'title' => $part['title'],
                        'data' => $data
                    );
                }
            }
        }
    }
    $contents = nv_theme_official_main($array_data, $array_config['home_data'], $array_config['home_view']);
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';