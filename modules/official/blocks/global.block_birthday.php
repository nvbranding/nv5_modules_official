<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

if (!nv_function_exists('nv_official_birthday')) {

    function nv_block_config_official_birthday($module, $data_block, $lang_block)
    {
        $array_type = array(
            1 => $lang_block['type_1'],
            2 => $lang_block['type_2'],
            3 => $lang_block['type_3'],
            4 => $lang_block['type_4']
        );

        $html = '';
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['type'] . '</td>';
        $html .= '<td>';
        $html .= "<select name=\"config_type\" class=\"form-control w200\">\n";
        foreach ($array_type as $index => $value) {
            $html .= "<option value=\"" . $index . "\" " . (($data_block['type'] == $index) ? " selected=\"selected\"" : "") . ">" . $value . "</option>\n";
        }
        $html .= "</select>\n";
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>' . $lang_block['marquee'] . '</td>';
        $html .= '<td>';
        $html .= "<select name=\"config_marquee\" class=\"form-control w200\">\n";
        for ($i = 0; $i <= 15; $i++) {
            $html .= "<option value=\"" . $i . "\" " . (($data_block['marquee'] == $i) ? " selected=\"selected\"" : "") . ">" . $i . "</option>\n";
        }
        $html .= "</select><span class=\"help-block\">" . $lang_block['marquee_note'] . "</span>";
        $html .= '</td>';
        $html .= '</tr>';

        return $html;
    }

    function nv_block_config_official_birthday_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['type'] = $nv_Request->get_int('config_type', 'post', 1);
        $return['config']['marquee'] = $nv_Request->get_int('config_marquee', 'post', 0);
        return $return;
    }

    function nv_official_birthday($block_config)
    {
        global $db, $module_info, $lang_module, $global_config, $module_data, $site_mods, $array_part;

        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_upload = $site_mods[$module]['module_upload'];

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/official/block_birthday.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $where = '';
        if ($block_config['type'] == 1) {
            $where .= ' AND birthday_day=' . date('d', NV_CURRENTTIME) . ' AND birthday_month=' . date('m', NV_CURRENTTIME);
        } elseif ($block_config['type'] == 2 or $block_config['type'] == 3) {
            if ($block_config['type'] == 2) {
                $firstday = date('d', strtotime('monday this week'));
                $lastday = date('d', strtotime('sunday this week'));
            } else {
                $firstday = date('d', strtotime('first day of this month'));
                $lastday = date('d', strtotime('last day of this month'));
            }
            $where .= ' AND birthday_month=' . intval(date('m')) . ' AND birthday_day >= ' . intval($firstday) . ' AND birthday_day <= ' . intval($lastday);
        } elseif ($block_config['type'] == 4) {
            $_where = array();
            for ($i = 1; $i <= 7; $i++) {
                $date = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + " . $i . " day");
                $_where[] = '(birthday_day=' . intval(date('d', $date)) . ' AND birthday_month=' . intval(date('m', $date)) . ')';
            }
            $where .= ' AND (' . implode(' OR ', $_where) . ')';
        }

        $array_data = array();
        $result = $db->query('SELECT id, lastname, firstname, birthday, image, part_id FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_rows WHERE status=1' . $where . ' ORDER BY birthday');
        while ($row = $result->fetch()) {
            $array_data[$row['id']] = $row;
        }

        if (empty($array_data)) return '';

        $xtpl = new XTemplate('block_birthday.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/official');
        $xtpl->assign('TEMPLATE', $block_theme);

        foreach ($array_data as $data) {
            $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $array_part[$data['part_id']]['alias'] . '/' . change_alias($data['lastname'] . ' ' . $data['firstname']) . '-' . $data['id'];
            $data['fullname'] = nv_show_name_user($data['firstname'], $data['lastname']);
            $data['birthday'] = nv_date('d/m/Y', $data['birthday']);

            if (!empty($data['image'])) {
                if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $mod_upload . '/' . $data['image'])) {
                    $data['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $mod_upload . '/' . $data['image'];
                } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $data['image'])) {
                    $data['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $data['image'];
                } else {
                    $data['image'] = '';
                }
            }

            $xtpl->assign('DATA', $data);

            if (!empty($data['image'])) {
                $xtpl->parse('main.loop.image');
            }

            $xtpl->parse('main.loop');
        }

        if ($block_config['marquee'] > 0 and sizeof($array_data) >= $block_config['marquee']) {
            $xtpl->parse('main.marquee');
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $module_name, $nv_Cache, $array_part;

    $module = $block_config['module'];

    if (isset($site_mods[$module])) {
        if ($module != $module_name) {
            $_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_part WHERE status=1';
            $array_part = $nv_Cache->db($_sql, 'id', $module);
        }
        $content = nv_official_birthday($block_config);
    }
}
