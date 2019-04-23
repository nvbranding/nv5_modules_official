<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

if (!defined('NV_IS_MOD_OFFICIAL')) die('Stop!!!');

/**
 * nv_theme_official_main()
 *
 * @param mixed $part_info
 * @param mixed $array_data
 * @param mixed $generate_page
 * @return
 */
function nv_theme_official_main($array_data, $home_data, $home_view, $generate_page = '')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_part;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);

    if (function_exists('nv_theme_official_' . $home_view)) {
        if ($home_data == 1) {
            $xtpl->assign('DATA', call_user_func('nv_theme_official_' . $home_view, $array_data));
            if (!empty($generate_page)) {
                $xtpl->assign('PAGE', $generate_page);
                $xtpl->parse('main.all.page');
            }
            $xtpl->parse('main.all');
        } elseif ($home_data == 2) {
            foreach ($array_data as $index => $data) {
                $xtpl->assign('PART', $data);
                if (!empty($data['data'])) {
                    $xtpl->assign('DATA', call_user_func('nv_theme_official_' . $home_view, $data['data']));
                    $xtpl->parse('main.part');
                }
            }
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_official_viewpart()
 *
 * @param mixed $part_info
 * @param mixed $array_data
 * @param mixed $generate_page
 * @return
 */
function nv_theme_official_viewpart($part_info, $array_data, $home_view, $generate_page = '')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('PART', $part_info);

    if (function_exists('nv_theme_official_' . $home_view)) {
        $xtpl->assign('DATA', call_user_func('nv_theme_official_' . $home_view, $array_data));
    }

    foreach ($part_info as $index => $value) {
        if (!empty($value)) {
            $xtpl->parse('main.' . $index);
        }
    }

    if (!empty($generate_page)) {
        $xtpl->assign('PAGE', $generate_page);
        $xtpl->parse('main.page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_official_viewlist()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_official_viewlist($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_part, $array_jobtitle;

    $xtpl = new XTemplate('viewlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);

    if (!empty($array_data)) {
        foreach ($array_data as $data) {
            $data['part'] = $array_part[$data['part_id']]['title'];
            $data['part_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_part[$data['part_id']]['alias'];
            $data['official_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_part[$data['part_id']]['alias'] . '/' . change_alias($data['lastname'] . ' ' . $data['firstname']) . '-' . $data['id'];

            $jobtitle_title = array();
            if (!empty($data['jobtitle'])) {
                foreach ($data['jobtitle'] as $jobtitle_id) {
                    $jobtitle_title[] = $array_jobtitle[$jobtitle_id]['title'];
                }
            }
            $data['jobtitle'] = !empty($jobtitle_title) ? implode(', ', $jobtitle_title) : '';
            $xtpl->assign('DATA', $data);
            $xtpl->parse('main.loop');
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_official_detail()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_official_detail($array_data, $array_field_config, $custom_fields, $isprint)
{
    global $global_config, $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $op, $array_gender, $array_part, $array_jobtitle, $array_jobstatus, $client_info, $array_config;

    if (!empty($array_data['image'])) {
        $array_data['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_data['image'];
    } else {
        $array_data['image'] = NV_BASE_SITEURL . 'themes/default/images/users/no_avatar.png';
    }
    $array_data['fullname'] = $array_data['lastname'] . ' ' . $array_data['firstname'];
    $array_data['birthday'] = !empty($array_data['birthday']) ? nv_date('d/m/Y', $array_data['birthday']) : '';
    $array_data['unionist_date'] = !empty($array_data['unionist_date']) ? nv_date('d/m/Y', $array_data['unionist_date']) : '';
    $array_data['party_date_tmp'] = !empty($array_data['party_date_tmp']) ? nv_date('d/m/Y', $array_data['party_date_tmp']) : '';
    $array_data['party_date'] = !empty($array_data['party_date']) ? nv_date('d/m/Y', $array_data['party_date']) : '';
    $array_data['gender'] = $array_gender[$array_data['gender']];
    $array_data['part'] = $array_part[$array_data['part_id']]['title'];
    $array_data['part_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_part[$array_data['part_id']]['alias'];

    $jobtitle_title = array();
    if (!empty($array_data['jobtitle'])) {
        foreach ($array_data['jobtitle'] as $jobtitle_id) {
            $jobtitle_title[] = $array_jobtitle[$jobtitle_id]['title'];
        }
    }
    $array_data['jobtitle'] = !empty($jobtitle_title) ? implode(', ', $jobtitle_title) : '';

    $xtpl = new XTemplate('detail-' . $array_config['detail_style'] . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $array_data);
    $xtpl->assign('URL', $client_info['selfurl']);

    foreach ($array_data as $key => $value) {
        if (!empty($value)) {
            $xtpl->parse('main.' . $key);
        }
    }

    // Parse custom fields
    if (!empty($array_field_config)) {
        foreach ($array_field_config as $row) {
            if ($row['show_profile']) {
                $question_type = $row['field_type'];
                if ($question_type == 'checkbox') {
                    $result = explode(',', $custom_fields[$row['field']]);
                    $value = '';
                    foreach ($result as $item) {
                        $value .= $row['field_choices'][$item] . '<br />';
                    }
                } elseif ($question_type == 'multiselect' or $question_type == 'select' or $question_type == 'radio') {
                    $value = $row['field_choices'][$custom_fields[$row['field']]];
                } else {
                    $value = $custom_fields[$row['field']];
                }
                if (empty($value)) continue;
                $xtpl->assign('FIELD', array(
                    'title' => $row['title'],
                    'value' => $value
                ));
                $xtpl->parse('main.field.loop');
            }
        }
        $xtpl->parse('main.field');
    }

    if ($isprint) {
        $xtpl->parse('main.isprint');
        $xtpl->parse('main.isprint1');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_official_search()
 *
 * @param mixed $array_data
 * @param mixed $generate_page
 * @return
 */
function nv_theme_official_search($array_data, $home_view, $generate_page = '')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);

    if (function_exists('nv_theme_official_' . $home_view)) {
        $xtpl->assign('DATA', call_user_func('nv_theme_official_' . $home_view, $array_data));
    }

    if (!empty($generate_page)) {
        $xtpl->assign('PAGE', $generate_page);
        $xtpl->parse('main.page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}