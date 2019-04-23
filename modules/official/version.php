<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

$module_version = array(
    'name' => 'Official',
    'modfuncs' => 'main,detail,search,viewpart',
    'submenu' => 'main,search',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '1.0.02',
    'date' => 'Sun, 16 Aug 2015 01:05:44 GMT',
    'author' => 'Ứng dụng NukeViet (contact@mynukeviet.net)',
    'uploads_dir' => array(
        $module_upload
    ),
    'note' => ''
);