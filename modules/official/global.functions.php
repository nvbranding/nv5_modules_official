<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

$array_config = array();
$_sql = 'SELECT config_name, config_value FROM ' . NV_PREFIXLANG . '_' . $module_data . '_config';
$_query = $db->query($_sql);
while (list ($config_name, $config_value) = $_query->fetch(3)) {
    $array_config[$config_name] = $config_value;
}

$array_gender = array(
    '1' => $lang_module['gender_1'],
    '0' => $lang_module['gender_0'],
    '2' => $lang_module['gender_2']
);

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_part WHERE status=1 ORDER BY weight';
$array_part = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_jobtitle WHERE status=1 ORDER BY weight';
$array_jobtitle = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_language WHERE status=1 ORDER BY weight';
$array_language = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_specialize WHERE status=1 ORDER BY weight';
$array_specialize = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_politic WHERE status=1 ORDER BY weight';
$array_politic = $nv_Cache->db($_sql, 'id', $module_name);

/**
 * nv_getcatid_inparent()
 *
 * @param mixed $catid
 * @return
 *
 */
function nv_getcatid_inparent($catid)
{
    global $array_part;

    $_array_cat = array();
    $_array_cat[] = $catid;
    $subcatid = explode(',', $array_part[$catid]['subid']);

    if (!empty($subcatid)) {
        foreach ($subcatid as $id) {
            if ($id > 0) {
                if ($array_part[$id]['numsub'] == 0) {
                    $_array_cat[] = intval($id);
                } else {
                    $array_part_temp = GetCatidInParent($id);
                    foreach ($array_part_temp as $catid_i) {
                        $_array_cat[] = intval($catid_i);
                    }
                }
            }
        }
    }
    return array_unique($_array_cat);
}