<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 10 Dec 2011 06:46:54 GMT
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

if (!nv_function_exists('nv_block_search')) {

    function nv_block_search($block_config)
    {
        global $module_info, $lang_module, $module_name, $site_mods, $module_config, $global_config, $db, $array_part, $nv_Request;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $mod_file . '/block_search.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        if ($module != $module_name) {
            if (file_exists(NV_ROOTDIR . NV_BASE_SITEURL . 'modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php')) {
                require_once NV_ROOTDIR . NV_BASE_SITEURL . 'modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
            }
        }
        
        $array_search = array(
            'q' => $nv_Request->get_title('q', 'get', ''),
            'part_id' => $nv_Request->get_int('part_id', 'get', 0)
        );
        
        $array_part_list = array();
        if (!empty($array_part)) {
            foreach ($array_part as $part) {
                $xtitle_i = '';
                if ($part['lev'] > 0) {
                    $xtitle_i .= '&nbsp;';
                    for ($i = 1; $i <= $part['lev']; $i++) {
                        $xtitle_i .= '---';
                    }
                }
                $xtitle_i .= $part['title'];
                $array_part_list[] = array(
                    'id' => $part['id'],
                    'title' => $xtitle_i
                );
            }
        }
        
        $xtpl = new XTemplate('block_search.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('BASE_URL_SITE', NV_BASE_SITEURL . 'index.php');
        $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
        $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
        $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
        $xtpl->assign('MODULE_NAME', $module);
        $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
        $xtpl->assign('OP_NAME', 'search');
        $xtpl->assign('SEARCH', $array_search);
        
        if (!empty($array_part_list)) {
            foreach ($array_part_list as $part) {
                $part['selected'] = $part['id'] == $array_search['part_id'] ? 'selected="selected"' : '';
                $xtpl->assign('PART', $part);
                $xtpl->parse('main.loop');
            }
        }
        unset($array_part_list);
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}
if (defined('NV_SYSTEM')) {
    global $site_mods, $module_name, $array_part, $nv_Cache;
    
    $module = $block_config['module'];
    
    if ($module != $module_name) {
        $_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_part WHERE status=1';
        $array_part = $nv_Cache->db($_sql, 'id', $module);
    }
    
    $content = nv_block_search($block_config);
}
