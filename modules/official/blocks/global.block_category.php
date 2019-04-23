<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

if (!nv_function_exists('nv_official_category')) {

    function nv_block_config_official_category($module, $data_block, $lang_block)
    {
        global $site_mods;
        
        $html = '';
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['title_length'] . '</td>';
        $html .= '<td>';
        $html .= "<select name=\"config_title_length\" class=\"form-control w200\">\n";
        $html .= "<option value=\"\">" . $lang_block['title_length'] . "</option>\n";
        for ($i = 0; $i < 100; ++$i) {
            $html .= "<option value=\"" . $i . "\" " . (($data_block['title_length'] == $i) ? " selected=\"selected\"" : "") . ">" . $i . "</option>\n";
        }
        $html .= "</select>\n";
        $html .= '</td>';
        $html .= '</tr>';
        return $html;
    }

    function nv_block_config_official_category_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['title_length'] = $nv_Request->get_int('config_title_length', 'post', 0);
        return $return;
    }

    function nv_official_category($block_config)
    {
        global $module_array_cat, $module_info, $lang_module, $global_config;
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/official/block_category.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate('block_category.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/official');
        
        if (!empty($module_array_cat)) {
            $title_length = $block_config['title_length'];
            $xtpl->assign('LANG', $lang_module);
            $xtpl->assign('BLOCK_ID', $block_config['bid']);
            $xtpl->assign('TEMPLATE', $block_theme);
            $html = '';
            foreach ($module_array_cat as $cat) {
                $html .= "<li>\n";
                $html .= "<a title=\"" . $cat['title'] . "\" href=\"" . $cat['link'] . "\">" . nv_clean60($cat['title'], $title_length) . "</a>\n";
                if (!empty($cat['subid'])) {
                    $html .= "<span class=\"fa arrow expand\"></span>";
                    $html .= nv_official_sub_category($cat['subid'], $title_length);
                }
                $html .= "</li>\n";
            }
            $xtpl->assign('MENUID', $block_config['bid']);
            $xtpl->assign('HTML_CONTENT', $html);
            $xtpl->parse('main');
            return $xtpl->text('main');
        }
    }

    function nv_official_sub_category($list_sub, $title_length)
    {
        global $module_array_cat;
        
        if (empty($list_sub)) {
            return "";
        } else {
            $list = explode(',', $list_sub);
            $html = "<ul>\n";
            foreach ($list as $partid) {
                $html .= "<li>\n";
                $html .= "<a title=\"" . $module_array_cat[$partid]['title'] . "\" href=\"" . $module_array_cat[$partid]['link'] . "\">" . nv_clean60($module_array_cat[$partid]['title'], $title_length) . "</a>\n";
                if (!empty($module_array_cat[$partid]['subid'])) $html .= nv_official_sub_category($module_array_cat[$partid]['subid'], $title_length);
                $html .= "</li>\n";
            }
            $html .= "</ul>\n";
            return $html;
        }
    }

}

if (defined('NV_SYSTEM')) {
    global $site_mods, $module_name, $array_part, $module_array_cat, $nv_Cache;
    
    $module = $block_config['module'];
    
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $array_part;
            unset($module_array_cat[0]);
        } else {
            $module_array_cat = array();
            $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_part ORDER BY sort ASC";
            $list = $nv_Cache->db($sql, 'id', $module);
            foreach ($list as $l) {
                $module_array_cat[$l['id']] = $l;
                $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=" . $l['alias'];
            }
        }
        $content = nv_official_category($block_config);
    }
}
