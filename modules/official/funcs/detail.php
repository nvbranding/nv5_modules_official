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
$isprint = $nv_Request->isset_request('print', 'get');

$array_data = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status=1 AND id=' . $official_id)->fetch();
if (empty($array_data)) {
    Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    die();
}
$array_data['jobtitle'] = array();
$result = $db->query('SELECT jobtitle_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_jobtitle WHERE rows_id=' . $array_data['id']);
while (list ($jobtitle_id) = $result->fetch(3)) {
    $array_data['jobtitle'][] = $jobtitle_id;
}

$array_field_config = array();
$result_field = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_field WHERE show_profile=1 ORDER BY weight ASC');
while ($row_field = $result_field->fetch()) {
    $language = unserialize($row_field['language']);
    $row_field['title'] = (isset($language[NV_LANG_DATA])) ? $language[NV_LANG_DATA][0] : $row['field'];
    $row_field['description'] = (isset($language[NV_LANG_DATA])) ? nv_htmlspecialchars($language[NV_LANG_DATA][1]) : '';
    if (!empty($row_field['field_choices'])) {
        $row_field['field_choices'] = unserialize($row_field['field_choices']);
    } elseif (!empty($row_field['sql_choices'])) {
        $row_field['sql_choices'] = explode('|', $row_field['sql_choices']);
        $query = 'SELECT ' . $row_field['sql_choices'][2] . ', ' . $row_field['sql_choices'][3] . ' FROM ' . $row_field['sql_choices'][1];
        $result = $db->query($query);
        $weight = 0;
        while (list ($key, $val) = $result->fetch(3)) {
            $row_field['field_choices'][$key] = $val;
        }
    }
    $array_field_config[] = $row_field;
}

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info WHERE rows_id=' . $official_id;
$result = $db->query($sql);
$custom_fields = $result->fetch();

if ($array_data['idspecialize'] > 0) {
    $array_data['specialize'] = $array_specialize[$array_data['idspecialize']]['title'];
}

if ($array_data['idpolitic'] > 0) {
    $array_data['politic'] = $array_politic[$array_data['idpolitic']]['title'];
}

if ($array_data['idlanguage'] > 0) {
    $array_data['language'] = $array_language[$array_data['idlanguage']]['title'];
}

$contents = nv_theme_official_detail($array_data, $array_field_config, $custom_fields, $isprint);
$page_title = $array_data['lastname'] . ' ' . $array_data['firstname'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents, !$isprint);
include NV_ROOTDIR . '/includes/footer.php';