<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

if (!defined('NV_SYSTEM')) die('Stop!!!');

define('NV_IS_MOD_OFFICIAL', true);
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

$official_id = 0; // ID bài viết
$part_id = 0; // ID chủ đề
$alias = isset($array_op[0]) ? $array_op[0] : '';

foreach ($array_part as $part) {
    $array_part[$part['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $part['alias'];
    if ($alias == $part['alias']) {
        $part_id = $part['id'];
    }
}

$alias_url = ''; // alias bài viết
$page = 1; // Trang mặc định
$per_page = $array_config['per_page']; // Số lượng bản ghi trên một trang

if ($op == 'main') {
    if (empty($part_id)) {
        if (preg_match('/^page\-([0-9]+)$/', (isset($array_op[0]) ? $array_op[0] : ''), $m)) {
            $page = (int) $m[1];
        }
    } else {
        if (sizeof($array_op) == 2 and preg_match('/^([a-z0-9\-]+)\-([0-9]+)$/i', $array_op[1], $m1) and !preg_match('/^page\-([0-9]+)$/', $array_op[1], $m2)) {
            $op = 'detail';
            $alias_url = $m1[1];
            $official_id = $m1[2];
        } else {
            if (preg_match('/^page\-([0-9]+)$/', (isset($array_op[1]) ? $array_op[1] : ''), $m)) {
                $page = (int) $m[1];
            }
            $op = 'viewpart';
        }
    }
}

function nv_make_order()
{
    global $array_config;

    return 'prior DESC, ' . $array_config['order_by'] . ' ' . $array_config['order_type'];
}