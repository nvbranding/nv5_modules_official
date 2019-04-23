<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) die('Stop!!!');

$allow_func = array(
    'main',
    'config',
    'part',
    'jobtitle',
    'content',
    'fields',
    'specialize',
    'politic',
    'language',
    'import',
);

define('NV_IS_FILE_ADMIN', true);
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

/**
 * nv_fix_order()
 *
 * @param integer $parentid
 * @param integer $order
 * @param integer $lev
 * @return
 */
function nv_fix_order($table_name, $parentid = 0, $sort = 0, $lev = 0)
{
    global $db, $db_config, $module_data;

    $sql = 'SELECT id, parentid FROM ' . $table_name . ' WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    $array_order = array();
    while ($row = $result->fetch()) {
        $array_order[] = $row['id'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++$lev;
    } else {
        $lev = 0;
    }
    foreach ($array_order as $order_i) {
        ++$sort;
        ++$weight;

        $sql = 'UPDATE ' . $table_name . ' SET weight=' . $weight . ', sort=' . $sort . ', lev=' . $lev . ' WHERE id=' . $order_i;
        $db->query($sql);

        $sort = nv_fix_order($table_name, $order_i, $sort, $lev);
    }

    $numsub = $weight;

    if ($parentid > 0) {
        $sql = "UPDATE " . $table_name . " SET numsub=" . $numsub;
        if ($numsub == 0) {
            $sql .= ",subid=''";
        } else {
            $sql .= ",subid='" . implode(",", $array_order) . "'";
        }
        $sql .= " WHERE id=" . intval($parentid);
        $db->query($sql);
    }
    return $sort;
}

function nv_delete_rows($id)
{
    global $db, $module_data;

    $status = 0;
    $sql = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id =' . $id;
    $result = $db->query($sql);
    list ($status) = $result->fetch(3);

    $result = $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows  WHERE id = ' . $id);
    if ($result) {
        if ($status > 0) {
            $sql = 'SELECT id, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status >' . $status;
            $result = $db->query($sql);
            while (list ($_id, $status) = $result->fetch(3)) {
                $status--;
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET status=' . $status . ' WHERE id=' . intval($_id));
            }
        }
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info WHERE rows_id=' . $id);
    }
}