<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

if (!defined('NV_IS_MOD_OFFICIAL')) die('Stop!!!');

$page_title = $module_info['funcs']['search']['func_site_title'];
$key_words = $module_info['keywords'];

$array_data = array();
$base_url_rewrite = $request_uri = urldecode($_SERVER['REQUEST_URI']);

$where = '';
$array_search = array(
    'q' => $nv_Request->get_title('q', 'get', ''),
    'part_id' => $nv_Request->get_int('part_id', 'get', 0)
);

if (!empty($array_search['q'])) {
    $where .= ' AND (lastname LIKE "%' . $array_search['q'] . '%"
    	OR firstname LIKE "%' . $array_search['q'] . '%"
    	OR resident LIKE "%' . $array_search['q'] . '%"
    	OR temporarily LIKE "%' . $array_search['q'] . '%"
    	OR email LIKE "%' . $array_search['q'] . '%"
    	OR phone LIKE "%' . $array_search['q'] . '%"
    	OR party_date_code LIKE "%' . $array_search['q'] . '%"
    	OR nation LIKE "%' . $array_search['q'] . '%"
    	OR religion LIKE "%' . $array_search['q'] . '%"
    	OR education LIKE "%' . $array_search['q'] . '%"
    )';
}

if (empty($array_search['part_id'])) {
    $base_url_rewrite = str_replace('&part_id=' . $array_search['part_id'], '', $base_url_rewrite);
} else {
    $where .= ' AND part_id=' . $array_search['part_id'];
}

if (empty($where)) {
    $contents .= '<div class="alert alert-danger text-center">' . $lang_module['empty_data_search'] . '</div>';
} else {
    $base_url_rewrite = nv_url_rewrite($base_url_rewrite, true);

    if ($request_uri != $base_url_rewrite and NV_MAIN_DOMAIN . $request_uri != $base_url_rewrite) {
        header('Location: ' . $base_url_rewrite);
        die();
    }

    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
        ->where('status=1 ' . $where);

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

    $generate_page = '';
    //$generate_page = nv_generate_page( $base_url_rewrite, $all_page, $per_page, $page );

    if (empty($array_data)) {
        $contents .= '<div class="alert alert-info text-center">' . $lang_module['empty_search'] . '</div>';
    } else {
        $contents = nv_theme_official_search($array_data, $array_config['home_view'], $generate_page);
    }
}

$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
