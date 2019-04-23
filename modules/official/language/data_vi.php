<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC.
 * All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */

if (!defined('NV_ADMIN')) {
    die('Stop!!!');
}

/**
 * Note:
 * - Module var is: $lang, $module_file, $module_data, $module_upload, $module_theme, $module_name
 * - Accept global var: $db, $db_config, $global_config
 */

// Bo phan
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('12', '0', 'Văn phòng HDTQ', 'Van-phong-HDTQ', '', '', '0', '2', '15,16', '1', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('15', '12', 'Tổ nghiệp vụ I', 'To-nghiep-vu-I', '', '', '1', '0', '', '2', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('16', '12', 'Tổ nghiệp vụ II', 'To-nghiep-vu-II', '', '', '1', '0', '', '3', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('11', '0', 'Nhà Biểu Diễn NTCT', 'Nha-Bieu-Dien-NTCT', '', '', '0', '2', '23,24', '4', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('23', '11', 'Tổ I', 'To-I', '', '', '1', '0', '', '5', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('24', '11', 'Tổ II', 'To-II', '', '', '1', '0', '', '6', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('10', '0', 'Đội Tuyên Truyền Lưu Động', 'Doi-Tuyen-Truyen-Luu-Dong', '', '', '0', '0', '', '7', '3', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('9', '0', 'Tổ chuyên trách Làng gốm', 'To-chuyen-trach-Lang-gom', '', '', '0', '0', '', '8', '4', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('8', '0', 'Tổ quản lý các Đề án', 'To-quan-ly-cac-De-an', '', '', '0', '0', '', '9', '5', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('7', '0', 'Tổ nghiệp vụ TDTT', 'To-nghiep-vu-TDTT', '', '', '0', '0', '', '10', '6', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('6', '0', 'Tổ nghiệp vụ VHQC', 'To-nghiep-vu-VHQC', '', '', '0', '0', '', '11', '7', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('5', '0', 'Tổ sự kiện', 'To-su-kien', '', '', '0', '0', '', '12', '8', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('4', '0', 'Ban điều hành QTSH', 'Ban-dieu-hanh-QTSH', '', '', '0', '1', '25', '13', '9', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('25', '4', 'Bảo vệ - Tạp vụ', 'Bao-ve-Tap-vu', '', '', '1', '0', '', '14', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('2', '0', 'Văn phòng Trung tâm', 'Van-phong-Trung-tam', '', '', '0', '2', '14,13', '15', '10', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('14', '2', 'Kế toán - Hành chính', 'Ke-toan-Hanh-chinh', '', '', '1', '0', '', '16', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('13', '2', 'Văn thư - Tổng hợp', 'Van-thu-Tong-hop', '', '', '1', '0', '', '17', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part (id, parentid, title, alias, email, note, lev, numsub, subid, sort, weight, status) VALUES('1', '0', 'Ban Giám đốc', 'Ban-Giam-doc', '', '', '0', '0', '', '18', '11', '1')");

// Chuc vu
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('1', 'Giám đốc', '', '1', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('2', 'Phó giám đốc', '', '2', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('3', 'Trưởng VPTT', '', '3', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('4', 'Phó VPTT', '', '4', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('5', 'Trưởng VPHDTQ', '', '5', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('6', 'Phó VPHDTQ', '', '6', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('7', 'Tổ trưởng', '', '7', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('8', 'Tổ phó', '', '8', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('9', 'Đội trưởng', '', '9', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('10', 'Đội phó', '', '10', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('11', 'Chủ nhiệm NBD', '', '11', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('12', 'Phó chủ nhiệm NBD', '', '12', '1');");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle (id, title, note, weight, status) VALUES('13', 'Nhân viên', '', '13', '1');");

// Trinh do chuyen mon
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize (id, title, note, weight, status) VALUES('1', 'Phổ thông cơ sỡ', '', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize (id, title, note, weight, status) VALUES('2', 'Phổ thông trung học', '', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize (id, title, note, weight, status) VALUES('3', 'Trung cấp', '', '3', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize (id, title, note, weight, status) VALUES('4', 'Cao đẳng', '', '4', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize (id, title, note, weight, status) VALUES('5', 'Đại học', '', '5', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize (id, title, note, weight, status) VALUES('6', 'Thạc sỹ', '', '6', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize (id, title, note, weight, status) VALUES('7', 'Tiến sỹ', '', '7', '1')");

// Trinh do chinh tri
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_politic (id, title, note, weight, status) VALUES('1', '6 bài lý luận', '', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_politic (id, title, note, weight, status) VALUES('2', 'Sơ cấp', '', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_politic (id, title, note, weight, status) VALUES('3', 'Trung cấp', '', '3', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_politic (id, title, note, weight, status) VALUES('4', 'Cao cấp', '', '4', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_politic (id, title, note, weight, status) VALUES('5', 'Cử nhân', '', '5', '1')");

// Trinh do ngoai ngu
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_language (id, title, note, weight, status) VALUES('1', 'Anh', '', '1', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_language (id, title, note, weight, status) VALUES('2', 'Pháp', '', '2', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_language (id, title, note, weight, status) VALUES('3', 'Nga', '', '3', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_language (id, title, note, weight, status) VALUES('4', 'Nhật', '', '4', '1')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_language (id, title, note, weight, status) VALUES('5', 'Hàn', '', '5', '1')");

// Can bo
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (id, lastname, firstname, birthday, gender, image, email, phone, unionist_date, unionist_code, party_date_tmp, party_date, party_date_code, resident, temporarily, part_id, nation, religion, education, idspecialize, idpolitic, idlanguage, addtime, edittime, weight, status) VALUES('2', 'Nguyễn Văn', 'An', '331837200', '1', '', 'nguyenvanan@gmail.com', '01692777913', '1089133200', '', '1278435600', '1289322000', '', 'Quảng Trị', 'Đà Nẵng', '12', 'Kinh', 'Không', '12/12', '7', '4', '2', '1469693123', '0', '0', '1')");