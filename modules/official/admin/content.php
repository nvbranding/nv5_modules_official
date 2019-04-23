<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 03:15:12 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$array_field_config = array();
$result_field = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_field ORDER BY weight ASC');
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

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);

if ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }

    // jobtitle
    $row['jobtitle_id'] = array();
    $result = $db->query('SELECT jobtitle_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_jobtitle WHERE rows_id=' . $row['id']);
    while (list ($jobtitle_id) = $result->fetch(3)) {
        $row['jobtitle_id'][] = $jobtitle_id;
    }
    $row['jobtitle_id_old'] = $row['jobtitle_id'];
    $lang_module['official_add'] = $lang_module['official_edit'];

    // field
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info WHERE rows_id=' . $row['id'];
    $result = $db->query($sql);
    $custom_fields = $result->fetch();
} else {
    $custom_field = array();
    $row['id'] = 0;
    $row['lastname'] = '';
    $row['firstname'] = '';
    $row['birthday'] = 0;
    $row['gender'] = 1;
    $row['image'] = '';
    $row['email'] = '';
    $row['phone'] = '';
    $row['unionist_date'] = 0;
    $row['unionist_code'] = '';
    $row['party_date_tmp'] = 0;
    $row['party_date'] = 0;
    $row['party_date_code'] = '';
    $row['resident'] = '';
    $row['temporarily'] = '';
    $row['part_id'] = 0;
    $row['jobtitle_id'] = array();
    $row['jobtitle_id_old'] = array();
    $row['nation'] = '';
    $row['religion'] = '';
    $row['education'] = '';
    $row['idspecialize'] = 0;
    $row['idpolitic'] = 0;
    $row['idlanguage'] = 0;
    $row['prior'] = 0;
}

if ($nv_Request->isset_request('submit', 'post')) {
    $row['lastname'] = $nv_Request->get_title('lastname', 'post', '');
    $row['firstname'] = $nv_Request->get_title('firstname', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('birthday', 'post'), $m)) {
        $_hour = 0;
        $_min = 0;
        $row['birthday'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
    } else {
        $row['birthday'] = 0;
    }
    $row['gender'] = $nv_Request->get_int('gender', 'post', 0);
    $row['image'] = $nv_Request->get_title('image', 'post', '');
    if (is_file(NV_DOCUMENT_ROOT . $row['image'])) {
        $row['image'] = substr($row['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
    } else {
        $row['image'] = '';
    }
    $row['email'] = $nv_Request->get_title('email', 'post', '');
    $row['phone'] = $nv_Request->get_title('phone', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('unionist_date', 'post'), $m)) {
        $_hour = 0;
        $_min = 0;
        $row['unionist_date'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
    } else {
        $row['unionist_date'] = 0;
    }
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('party_date_tmp', 'post'), $m)) {
        $_hour = 0;
        $_min = 0;
        $row['party_date_tmp'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
    } else {
        $row['party_date_tmp'] = 0;
    }
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('party_date', 'post'), $m)) {
        $_hour = 0;
        $_min = 0;
        $row['party_date'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
    } else {
        $row['party_date'] = 0;
    }
    $row['unionist_code'] = $nv_Request->get_title('unionist_code', 'post', '');
    $row['party_date_code'] = $nv_Request->get_title('party_date_code', 'post', '');
    $row['resident'] = $nv_Request->get_title('resident', 'post', '');
    $row['temporarily'] = $nv_Request->get_title('temporarily', 'post', '');
    $row['part_id'] = $nv_Request->get_int('part_id', 'post', 0);
    $row['jobtitle_id'] = $nv_Request->get_typed_array('jobtitle_id', 'post', 'int', array());
    $row['nation'] = $nv_Request->get_title('nation', 'post', '');
    $row['religion'] = $nv_Request->get_title('religion', 'post', '');
    $row['education'] = $nv_Request->get_title('education', 'post', '');
    $row['idspecialize'] = $nv_Request->get_int('idspecialize', 'post', 0);
    $row['idpolitic'] = $nv_Request->get_int('idpolitic', 'post', 0);
    $row['idlanguage'] = $nv_Request->get_int('idlanguage', 'post', 0);
    $row['prior'] = $nv_Request->get_int('prior', 'post', 0);

    if (empty($row['lastname'])) {
        $error[] = $lang_module['error_required_lastname'];
    } elseif (empty($row['firstname'])) {
        $error[] = $lang_module['error_required_firstname'];
    } elseif (empty($row['birthday'])) {
        $error[] = $lang_module['error_required_birthday'];
    } elseif (empty($row['jobtitle_id'])) {
        $error[] = $lang_module['error_required_jobtitle_id'];
    } elseif (empty($row['part_id'])) {
        $error[] = $lang_module['error_required_part_id'];
    } elseif (!empty($row['email']) and ($error_email = nv_check_valid_email($row['email'])) != '') {
        $error[] = $error_email;
    }

    // field
    $custom_fields = $nv_Request->get_array('custom_fields', 'post');
    if (!empty($array_field_config)) {
        require NV_ROOTDIR . '/modules/' . $module_file . '/fields.check.php';
    }

    if (empty($error)) {
        try {
            $row['birthday_day'] = date('d', $row['birthday']);
            $row['birthday_month'] = date('m', $row['birthday']);
            $row['birthday_year'] = date('Y', $row['birthday']);

            if (empty($row['id'])) {
                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows (lastname, firstname, birthday, birthday_day, birthday_month, birthday_year, gender, image, email, phone, unionist_date, unionist_code, party_date_tmp, party_date, party_date_code, resident, temporarily, part_id, nation, religion, education, idspecialize, idpolitic, idlanguage, addtime, edittime, prior, status) VALUES (:lastname, :firstname, :birthday, :birthday_day, :birthday_month, :birthday_year, :gender, :image, :email, :phone, :unionist_date, :unionist_code, :party_date_tmp, :party_date, :party_date_code, :resident, :temporarily, :part_id, :nation, :religion, :education, :idspecialize, :idpolitic, :idlanguage, ' . NV_CURRENTTIME . ', 0, :prior, 1)';
                $data_insert = array();
                $data_insert['lastname'] = $row['lastname'];
                $data_insert['firstname'] = $row['firstname'];
                $data_insert['birthday'] = $row['birthday'];
                $data_insert['birthday_day'] = $row['birthday_day'];
                $data_insert['birthday_month'] = $row['birthday_month'];
                $data_insert['birthday_year'] = $row['birthday_year'];
                $data_insert['gender'] = $row['gender'];
                $data_insert['image'] = $row['image'];
                $data_insert['email'] = $row['email'];
                $data_insert['phone'] = $row['phone'];
                $data_insert['unionist_date'] = $row['unionist_date'];
                $data_insert['unionist_code'] = $row['unionist_code'];
                $data_insert['party_date_tmp'] = $row['party_date_tmp'];
                $data_insert['party_date'] = $row['party_date'];
                $data_insert['party_date_code'] = $row['party_date_code'];
                $data_insert['resident'] = $row['resident'];
                $data_insert['temporarily'] = $row['temporarily'];
                $data_insert['part_id'] = $row['part_id'];
                $data_insert['nation'] = $row['nation'];
                $data_insert['religion'] = $row['religion'];
                $data_insert['education'] = $row['education'];
                $data_insert['idspecialize'] = $row['idspecialize'];
                $data_insert['idpolitic'] = $row['idpolitic'];
                $data_insert['idlanguage'] = $row['idlanguage'];
                $data_insert['prior'] = $row['prior'];
                $new_id = $db->insert_id($sql, 'id', $data_insert);
            } else {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET lastname = :lastname, firstname = :firstname, birthday = :birthday, birthday_day = :birthday_day, birthday_month = :birthday_month, birthday_year = :birthday_year, gender = :gender, image = :image, email = :email, phone = :phone, unionist_date = :unionist_date, unionist_code = :unionist_code, party_date_tmp = :party_date_tmp, party_date = :party_date, party_date_code = :party_date_code, resident = :resident, temporarily = :temporarily, part_id = :part_id, nation = :nation, religion = :religion, education = :education, idspecialize = :idspecialize, idpolitic = :idpolitic, idlanguage = :idlanguage, edittime = ' . NV_CURRENTTIME . ', prior = :prior WHERE id=' . $row['id']);
                $stmt->bindParam(':lastname', $row['lastname'], PDO::PARAM_STR);
                $stmt->bindParam(':firstname', $row['firstname'], PDO::PARAM_STR);
                $stmt->bindParam(':birthday', $row['birthday'], PDO::PARAM_INT);
                $stmt->bindParam(':birthday_day', $row['birthday_day'], PDO::PARAM_STR);
                $stmt->bindParam(':birthday_month', $row['birthday_month'], PDO::PARAM_STR);
                $stmt->bindParam(':birthday_year', $row['birthday_year'], PDO::PARAM_STR);
                $stmt->bindParam(':gender', $row['gender'], PDO::PARAM_INT);
                $stmt->bindParam(':image', $row['image'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $row['email'], PDO::PARAM_STR);
                $stmt->bindParam(':phone', $row['phone'], PDO::PARAM_STR);
                $stmt->bindParam(':unionist_date', $row['unionist_date'], PDO::PARAM_INT);
                $stmt->bindParam(':unionist_code', $row['unionist_code'], PDO::PARAM_STR);
                $stmt->bindParam(':party_date_tmp', $row['party_date_tmp'], PDO::PARAM_INT);
                $stmt->bindParam(':party_date', $row['party_date'], PDO::PARAM_INT);
                $stmt->bindParam(':party_date_code', $row['party_date_code'], PDO::PARAM_STR);
                $stmt->bindParam(':resident', $row['resident'], PDO::PARAM_STR);
                $stmt->bindParam(':temporarily', $row['temporarily'], PDO::PARAM_STR);
                $stmt->bindParam(':part_id', $row['part_id'], PDO::PARAM_INT);
                $stmt->bindParam(':nation', $row['nation'], PDO::PARAM_STR);
                $stmt->bindParam(':religion', $row['religion'], PDO::PARAM_STR);
                $stmt->bindParam(':education', $row['education'], PDO::PARAM_STR);
                $stmt->bindParam(':idspecialize', $row['idspecialize'], PDO::PARAM_INT);
                $stmt->bindParam(':idpolitic', $row['idpolitic'], PDO::PARAM_INT);
                $stmt->bindParam(':idlanguage', $row['idlanguage'], PDO::PARAM_INT);
                $stmt->bindParam(':prior', $row['prior'], PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $new_id = $row['id'];
                }
            }

            if ($new_id > 0) {
                if ($row['id'] > 0) {
                    if (!empty($array_field_config)) {
                        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_info SET ' . implode(', ', $query_field) . ' WHERE rows_id=' . $new_id);
                    }
                } else {
                    $query_field['rows_id'] = $new_id;
                    $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_info (' . implode(', ', array_keys($query_field)) . ') VALUES (' . implode(', ', array_values($query_field)) . ')');
                }

                if ($row['jobtitle_id'] != $row['jobtitle_id_old']) {
                    $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows_jobtitle (rows_id, jobtitle_id) VALUES( :rows_id, :jobtitle_id )');
                    foreach ($row['jobtitle_id'] as $jobtitle_id) {
                        if (!in_array($jobtitle_id, $row['jobtitle_id_old'])) {
                            $sth->bindParam(':rows_id', $new_id, PDO::PARAM_INT);
                            $sth->bindParam(':jobtitle_id', $jobtitle_id, PDO::PARAM_INT);
                            $sth->execute();
                        }
                    }

                    foreach ($row['jobtitle_id_old'] as $jobtitle_id_old) {
                        if (!in_array($jobtitle_id_old, $row['jobtitle_id'])) {
                            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_jobtitle WHERE rows_id = ' . $new_id . ' AND jobtitle_id=' . $jobtitle_id_old);
                        }
                    }
                }
                $nv_Cache->delMod($module_name);
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
                die();
            }
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
        }
    }
}

if (empty($row['birthday'])) {
    $row['birthday'] = '';
} else {
    $row['birthday'] = date('d/m/Y', $row['birthday']);
}

if (empty($row['unionist_date'])) {
    $row['unionist_date'] = '';
} else {
    $row['unionist_date'] = date('d/m/Y', $row['unionist_date']);
}

if (empty($row['party_date_tmp'])) {
    $row['party_date_tmp'] = '';
} else {
    $row['party_date_tmp'] = date('d/m/Y', $row['party_date_tmp']);
}

if (empty($row['party_date'])) {
    $row['party_date'] = '';
} else {
    $row['party_date'] = date('d/m/Y', $row['party_date']);
}

if (!empty($row['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['image'])) {
    $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'];
}

$array_part = array();
$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_part WHERE status=1');
while ($_row = $result->fetch()) {
    $array_part[$_row['id']] = $_row;
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

foreach ($array_gender as $key => $value) {
    $ck = $row['gender'] == $key ? 'checked="checked"' : '';
    $xtpl->assign('GENDER', array(
        'key' => $key,
        'value' => $value,
        'checked' => $ck
    ));
    $xtpl->parse('main.gender');
}

if (!empty($array_part)) {
    foreach ($array_part as $part_id => $value) {
        $value['space'] = '';
        if ($value['lev'] > 0) {
            for ($i = 1; $i <= $value['lev']; $i++) {
                $value['space'] .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }
        $value['selected'] = $part_id == $row['part_id'] ? ' selected="selected"' : '';

        $xtpl->assign('PART', $value);
        $xtpl->parse('main.part_id');
    }
}

if (!empty($array_jobtitle)) {
    foreach ($array_jobtitle as $jobtitle) {
        $jobtitle['selected'] = in_array($jobtitle['id'], $row['jobtitle_id']) ? 'selected="selected"' : '';
        $xtpl->assign('JOBTITLE', $jobtitle);
        $xtpl->parse('main.jobtitle');
    }
}

if (!empty($array_specialize)) {
    foreach ($array_specialize as $specialize) {
        $specialize['selected'] = $specialize['id'] == $row['idspecialize'] ? 'selected="selected"' : '';
        $xtpl->assign('SPECIALIZE', $specialize);
        $xtpl->parse('main.specialize');
    }
}

if (!empty($array_politic)) {
    foreach ($array_politic as $politic) {
        $politic['selected'] = $politic['id'] == $row['idpolitic'] ? 'selected="selected"' : '';
        $xtpl->assign('POLITIC', $politic);
        $xtpl->parse('main.politic');
    }
}

if (!empty($array_language)) {
    foreach ($array_language as $language) {
        $language['selected'] = $language['id'] == $row['idlanguage'] ? 'selected="selected"' : '';
        $xtpl->assign('LANGUAGE', $language);
        $xtpl->parse('main.language');
    }
}

if (!empty($array_field_config)) {
    foreach ($array_field_config as $_row) {
        if ($row['id'] == 0 and empty($custom_fields)) {
            if (!empty($_row['field_choices'])) {
                if ($_row['field_type'] == 'date') {
                    $_row['value'] = ($_row['field_choices']['current_date']) ? NV_CURRENTTIME : $_row['default_value'];
                } elseif ($_row['field_type'] == 'number') {
                    $_row['value'] = $_row['default_value'];
                } else {
                    $temp = array_keys($_row['field_choices']);
                    $tempkey = intval($_row['default_value']) - 1;
                    $_row['value'] = (isset($temp[$tempkey])) ? $temp[$tempkey] : '';
                }
            } else {
                $_row['value'] = $_row['default_value'];
            }
        } else {
            $_row['value'] = (isset($custom_fields[$_row['field']])) ? $custom_fields[$_row['field']] : $_row['default_value'];
        }
        $_row['required'] = ($_row['required']) ? 'required' : '';

        $xtpl->assign('FIELD', $_row);
        if ($_row['required']) {
            $xtpl->parse('main.field.loop.required');
        }
        if ($_row['field_type'] == 'textbox' or $_row['field_type'] == 'number') {
            $xtpl->parse('main.field.loop.textbox');
        } elseif ($_row['field_type'] == 'date') {
            $_row['value'] = (empty($_row['value'])) ? '' : date('d/m/Y', $_row['value']);
            $xtpl->assign('FIELD', $_row);
            $xtpl->parse('main.field.loop.date');
        } elseif ($_row['field_type'] == 'textarea') {
            $_row['value'] = nv_htmlspecialchars(nv_br2nl($_row['value']));
            $xtpl->assign('FIELD', $_row);
            $xtpl->parse('main.field.loop.textarea');
        } elseif ($_row['field_type'] == 'editor') {
            if (defined('NV_EDITOR')) {
                require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
            }
            $_row['value'] = htmlspecialchars(nv_editor_br2nl($_row['value']));
            if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
                $array_tmp = explode('@', $_row['class']);
                $edits = nv_aleditor('custom_fields[' . $_row['field'] . ']', $array_tmp[0], $array_tmp[1], $_row['value']);
                $xtpl->assign('EDITOR', $edits);
                $xtpl->parse('main.field.loop.editor');
            } else {
                $_row['class'] = '';
                $xtpl->assign('FIELD', $_row);
                $xtpl->parse('main.field.loop.textarea');
            }
        } elseif ($_row['field_type'] == 'select') {
            foreach ($_row['field_choices'] as $key => $value) {
                $xtpl->assign('FIELD_CHOICES', array(
                    'key' => $key,
                    'selected' => ($key == $_row['value']) ? ' selected="selected"' : '',
                    'value' => $value
                ));
                $xtpl->parse('main.field.loop.select.loop');
            }
            $xtpl->parse('main.field.loop.select');
        } elseif ($_row['field_type'] == 'radio') {
            $number = 0;
            foreach ($_row['field_choices'] as $key => $value) {
                $xtpl->assign('FIELD_CHOICES', array(
                    'id' => $_row['fid'] . '_' . $number++,
                    'key' => $key,
                    'checked' => ($key == $_row['value']) ? ' checked="checked"' : '',
                    'value' => $value
                ));
                $xtpl->parse('main.field.loop.radio');
            }
        } elseif ($_row['field_type'] == 'checkbox') {
            $number = 0;
            $valuecheckbox = (!empty($_row['value'])) ? explode(',', $_row['value']) : array();
            foreach ($_row['field_choices'] as $key => $value) {
                $xtpl->assign('FIELD_CHOICES', array(
                    'id' => $_row['fid'] . '_' . $number++,
                    'key' => $key,
                    'checked' => (in_array($key, $valuecheckbox)) ? ' checked="checked"' : '',
                    'value' => $value
                ));
                $xtpl->parse('main.field.loop.checkbox');
            }
        } elseif ($_row['field_type'] == 'multiselect') {
            foreach ($_row['field_choices'] as $key => $value) {
                $xtpl->assign('FIELD_CHOICES', array(
                    'key' => $key,
                    'selected' => ($key == $_row['value']) ? ' selected="selected"' : '',
                    'value' => $value
                ));
                $xtpl->parse('main.field.loop.multiselect.loop');
            }
            $xtpl->parse('main.field.loop.multiselect');
        }
        $xtpl->parse('main.field.loop');
    }
    $xtpl->parse('main.field');
}

for ($i = 0; $i <= 10; $i++) {
    $xtpl->assign('PRIOR', array('index' => $i, 'selected' => $i == $row['prior'] ? 'selected="selected"' : ''));
    $xtpl->parse('main.prior');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['official_add'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';