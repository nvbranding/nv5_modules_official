<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 04:18:25 GMT
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_language";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_politic";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows_jobtitle";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_field";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_info";
$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_jobtitle(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi chức vụ',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_language(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi chức vụ',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_specialize(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi chức vụ',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_politic(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi chức vụ',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_part(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(4) unsigned NOT NULL DEFAULT '0',
  title varchar(255) NOT NULL COMMENT 'Tên gọi bộ phận',
  alias varchar(255) NOT NULL DEFAULT '',
  office varchar(255) NOT NULL DEFAULT '',
  address varchar(255) NOT NULL DEFAULT '',
  phone varchar(20) NOT NULL DEFAULT '',
  fax varchar(20) NOT NULL DEFAULT '',
  website varchar(100) NOT NULL DEFAULT '',
  email varchar(255) NOT NULL DEFAULT '',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  lev smallint(4) unsigned NOT NULL DEFAULT '0',
  numsub smallint(4) unsigned NOT NULL DEFAULT '0',
  subid varchar(255) NOT NULL NULL DEFAULT '',
  sort smallint(4) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  lastname varchar(255) NOT NULL COMMENT 'Họ - tên đệm',
  firstname varchar(50) NOT NULL COMMENT 'Tên',
  birthday int(11) NOT NULL DEFAULT '0' COMMENT 'Ngày sinh',
  birthday_day tinyint(2) UNSIGNED NOT NULL,
  birthday_month tinyint(2) UNSIGNED NOT NULL,
  birthday_year smallint(4) UNSIGNED NOT NULL,
  gender tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Giới tính',
  image varchar(255) NOT NULL COMMENT 'Hình ảnh',
  email varchar(100) NOT NULL DEFAULT '',
  phone varchar(20) NOT NULL DEFAULT '',
  unionist_date int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Ngày vào đoàn',
  unionist_code varchar(50) NOT NULL COMMENT 'Số thẻ đoàn viên',
  party_date_tmp int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Ngày vào đảng dự bị',
  party_date int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Ngày vào đảng',
  party_date_code varchar(50) NOT NULL COMMENT 'Số thẻ đảng viên',
  resident varchar(255) NOT NULL COMMENT 'Địa chỉ thường trú',
  temporarily varchar(255) NOT NULL COMMENT 'Địa chỉ tạm trú',
  part_id smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT 'Thuộc bộ phận',
  nation varchar(50) NOT NULL COMMENT 'Dân tộc',
  religion varchar(100) NOT NULL COMMENT 'Tôn giáo',
  education varchar(255) NOT NULL COMMENT 'Trình độ học vấn',
  idspecialize smallint(4) unsigned NOT NULL COMMENT 'Trình độ chuyên môn',
  idpolitic smallint(4) unsigned NOT NULL COMMENT 'Trình độ lý luận chính trị',
  idlanguage smallint(4) unsigned NOT NULL COMMENT 'Trình độ ngoại ngữ',
  addtime int(11) unsigned NOT NULL DEFAULT '0',
  edittime int(11) unsigned NOT NULL DEFAULT '0',
  weight mediumint(8) unsigned NOT NULL DEFAULT '0',
  prior tinyint(2) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows_jobtitle(
  rows_id mediumint(8) unsigned NOT NULL,
  jobtitle_id smallint(4) unsigned NOT NULL,
  UNIQUE KEY rows_id (rows_id,jobtitle_id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_field (
	fid mediumint(8) NOT NULL AUTO_INCREMENT,
	field varchar(25) NOT NULL,
	weight int(10) unsigned NOT NULL DEFAULT '1',
	field_type enum('number','date','textbox','textarea','editor','select','radio','checkbox','multiselect') NOT NULL DEFAULT 'textbox',
	field_choices text NOT NULL,
	sql_choices text NOT NULL,
	match_type enum('none','alphanumeric','email','url','regex','callback') NOT NULL DEFAULT 'none',
	match_regex varchar(250) NOT NULL DEFAULT '',
	func_callback varchar(75) NOT NULL DEFAULT '',
	min_length int(11) NOT NULL DEFAULT '0',
	max_length bigint(20) unsigned NOT NULL DEFAULT '0',
	required tinyint(3) unsigned NOT NULL DEFAULT '0',
	show_profile tinyint(4) NOT NULL DEFAULT '1',
	class varchar(50) NOT NULL DEFAULT '',
	language text NOT NULL,
	default_value varchar(255) NOT NULL DEFAULT '',
	PRIMARY KEY (fid),
	UNIQUE KEY field (field)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_info (
	rows_id mediumint(8) unsigned NOT NULL,
	PRIMARY KEY (rows_id)
) ENGINE=MyISAM";

// Cau hinh module
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . '_' . $module_data . "_config (
 config_name varchar(30) NOT NULL,
 config_value varchar(255) NOT NULL,
 UNIQUE KEY config_name (config_name)
)ENGINE=MyISAM";

$data = array();
$data['per_page'] = 20;
$data['detail_style'] = 1;
$data['home_data'] = 1;
$data['home_view'] = 'viewlist';
$data['order_by'] = 'firstname';
$data['order_type'] = 'asc';

foreach ($data as $config_name => $config_value) {
    $sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config VALUES (" . $db->quote($config_name) . ", " . $db->quote($config_value) . " )";
}