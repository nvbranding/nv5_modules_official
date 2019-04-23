<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2014 mynukeviet. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 13-08-2017 15:49
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

function nv_users_field_check($custom_fields, $check = 1)
{
    global $db, $global_config, $lang_module, $module_data;

    $query_field = $array_error = array();
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
        $array_field_config[$row_field['field']] = $row_field;
    }

    foreach ($array_field_config as $row_f) {
        $value = (isset($custom_fields[$row_f['field']])) ? $custom_fields[$row_f['field']] : '';
        $field_input_name = empty($row_f['system']) ? 'custom_fields[' . $row_f['field'] . ']' : $row_f['field'];
        if ($value != '') {
            if ($row_f['field_type'] == 'number') {
                $number_type = $row_f['field_choices']['number_type'];
                $pattern = ($number_type == 1) ? '/^[0-9]+$/' : '/^[0-9\.]+$/';

                if (!preg_match($pattern, $value)) {
                    $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                } else {
                    $value = ($number_type == 1) ? intval($value) : floatval($value);

                    if ($value < $row_f['min_length'] or $value > $row_f['max_length']) {
                        $array_error[] = sprintf($lang_module['field_min_max_value'], $row_f['title'], $row_f['min_length'], $row_f['max_length']);
                    }
                }
            } elseif ($row_f['field_type'] == 'date') {
                if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $value, $m)) {
                    $m[1] = intval($m[1]);
                    $m[2] = intval($m[2]);
                    $m[3] = intval($m[3]);
                    $value = mktime(0, 0, 0, $m[2], $m[1], $m[3]);

                    if ($row_f['min_length'] > 0 and ($value < $row_f['min_length'] or $value > $row_f['max_length'])) {
                        $array_error[] = sprintf($lang_module['field_min_max_value'], $row_f['title'], date('d/m/Y', $row_f['min_length']), date('d/m/Y', $row_f['max_length']));
                    } elseif ($row_f['field'] == 'birthday' and !empty($global_users_config['min_old_user']) and ($m[3] > (date('Y') - $global_users_config['min_old_user']) or ($m[3] == (date('Y') - $global_users_config['min_old_user']) and ($m[2] > date('n') or ($m[2] == date('n') and $m[1] > date('j')))))) {
                        $array_error[] = sprintf($lang_module['old_min_user_error'], $global_users_config['min_old_user']);
                    }
                } else {
                    $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                }
            } elseif ($row_f['field_type'] == 'textbox') {
                if ($row_f['match_type'] == 'alphanumeric') {
                    if (!preg_match('/^[a-zA-Z0-9\_]+$/', $value)) {
                        $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                    }
                } elseif ($row_f['match_type'] == 'email') {
                    if (($error = nv_check_valid_email($value)) != '') {
                        $array_error[] = $error;
                    }
                } elseif ($row_f['match_type'] == 'url') {
                    if (!nv_is_url($value)) {
                        $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                    }
                } elseif ($row_f['match_type'] == 'regex') {
                    if (!preg_match('/' . $row_f['match_regex'] . '/', $value)) {
                        $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                    }
                } elseif ($row_f['match_type'] == 'callback') {
                    if (function_exists($row_f['func_callback'])) {
                        if (!call_user_func($row_f['func_callback'], $value)) {
                            $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                        }
                    } else {
                        $array_error[] = 'error function not exists ' . $row_f['func_callback'];
                    }
                } else {
                    $value = nv_htmlspecialchars($value);
                }

                $strlen = nv_strlen($value);

                if ($strlen < $row_f['min_length'] or $strlen > $row_f['max_length']) {
                    $array_error[] = sprintf($lang_module['field_min_max_error'], $row_f['title'], $row_f['min_length'], $row_f['max_length']);
                }
            } elseif ($row_f['field_type'] == 'textarea' or $row_f['field_type'] == 'editor') {
                $allowed_html_tags = array_map('trim', explode(',', NV_ALLOWED_HTML_TAGS));
                $allowed_html_tags = '<' . implode('><', $allowed_html_tags) . '>';
                $value = strip_tags($value, $allowed_html_tags);
                if ($row_f['match_type'] == 'regex') {
                    if (!preg_match('/' . $row_f['match_regex'] . '/', $value)) {
                        $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                    }
                } elseif ($row_f['match_type'] == 'callback') {
                    if (function_exists($row_f['func_callback'])) {
                        if (!call_user_func($row_f['func_callback'], $value)) {
                            $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                        }
                    } else {
                        $array_error[] = 'error function not exists ' . $row_f['func_callback'];
                    }
                }

                $value = ($row_f['field_type'] == 'textarea') ? nv_nl2br($value, '<br />') : $value;
                $strlen = nv_strlen($value);

                if ($strlen < $row_f['min_length'] or $strlen > $row_f['max_length']) {
                    $array_error[] = sprintf($lang_module['field_min_max_error'], $row_f['title'], $row_f['min_length'], $row_f['max_length']);
                }
            } elseif ($row_f['field_type'] == 'checkbox' or $row_f['field_type'] == 'multiselect') {
                $temp_value = array();
                foreach ($value as $value_i) {
                    if (isset($row_f['field_choices'][$value_i])) {
                        $temp_value[] = $value_i;
                    }
                }

                $value = implode(',', $temp_value);
            } elseif ($row_f['field_type'] == 'select' or $row_f['field_type'] == 'radio') {
                if (!isset($row_f['field_choices'][$value])) {
                    $array_error[] = sprintf($lang_module['field_match_type_error'], $row_f['title']);
                }
            }

            $custom_fields[$row_f['field']] = $value;
        }

        if (empty($value) and $row_f['required']) {
            $array_error[] = sprintf($lang_module['field_match_type_required'], $row_f['title']);
        }

        if (empty($row_f['system'])) {
            if (!empty($userid)) {
                $query_field[] = $row_f['field'] . '=' . $db->quote($value);
            } else {
                $query_field[$row_f['field']] = $db->quote($value);
            }
        }
    }
    if ($check) {
        return $array_error;
    }
    return $query_field;
}

function nv_get_field()
{
    global $db, $module_data, $lang_module;

    // trường dữ liệu mặc định
    $array_field = array(
        'lastname' => array(
            'field' => 'lastname',
            'text' => $lang_module['lastname'],
            'required' => 1
        ),
        'firstname' => array(
            'field' => 'firstname',
            'text' => $lang_module['firstname'],
            'required' => 1
        ),
        'email' => array(
            'field' => 'email',
            'text' => $lang_module['email'],
            'required' => 0
        ),
        'phone' => array(
            'field' => 'phone',
            'text' => $lang_module['phone'],
            'required' => 0
        ),
        'resident' => array(
            'field' => 'resident',
            'text' => $lang_module['resident'],
            'required' => 0
        ),
        'temporarily' => array(
            'field' => 'temporarily',
            'text' => $lang_module['temporarily'],
            'required' => 0
        ),
        'birthday' => array(
            'field' => 'birthday',
            'text' => $lang_module['birthday'],
            'required' => 1
        ),
        'gender' => array(
            'field' => 'gender',
            'text' => $lang_module['gender'],
            'required' => 0
        ),
        'nation' => array(
            'field' => 'nation',
            'text' => $lang_module['nation'],
            'required' => 0
        ),
        'religion' => array(
            'field' => 'religion',
            'text' => $lang_module['religion'],
            'required' => 0
        ),
        'image' => array(
            'field' => 'image',
            'text' => $lang_module['image'],
            'required' => 0
        ),
        'part_id' => array(
            'field' => 'part_id',
            'text' => $lang_module['part'],
            'required' => 1,
            'comment' => $lang_module['part_note']
        ),
        'jobtitle_id' => array(
            'field' => 'jobtitle_id',
            'text' => $lang_module['jobtitle'],
            'required' => 1,
            'comment' => $lang_module['jobtitle_note']
        ),
        'unionist_date' => array(
            'field' => 'unionist_date',
            'text' => $lang_module['unionist_date'],
            'required' => 0
        ),
        'unionist_code' => array(
            'field' => 'unionist_code',
            'text' => $lang_module['unionist_code'],
            'required' => 0
        ),
        'party_date_tmp' => array(
            'field' => 'party_date_tmp',
            'text' => $lang_module['party_date_tmp'],
            'required' => 0
        ),
        'party_date' => array(
            'field' => 'party_date',
            'text' => $lang_module['party_date'],
            'required' => 0
        ),
        'party_date_code' => array(
            'field' => 'party_date_code',
            'text' => $lang_module['party_date_code'],
            'required' => 0
        ),
        'education' => array(
            'field' => 'education',
            'text' => $lang_module['education'],
            'required' => 0
        ),
        'idspecialize' => array(
            'field' => 'idspecialize',
            'text' => $lang_module['specialize'],
            'required' => 0
        ),
        'idpolitic' => array(
            'field' => 'idpolitic',
            'text' => $lang_module['politic'],
            'required' => 0
        ),
        'idlanguage' => array(
            'field' => 'idlanguage',
            'text' => $lang_module['language'],
            'required' => 0
        ),
        'prior' => array(
            'field' => 'prior',
            'text' => $lang_module['prior'],
            'required' => 0
        )
    );

    // trường dữ liệu tùy biến
    $array_allow_field = array(
        'number',
        'date',
        'textbox',
        'textarea',
        'editor',
        'select',
        'radio'
    );

    $result_field = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_field ORDER BY weight ASC');
    while ($row_field = $result_field->fetch()) {
        if (in_array($row_field['field_type'], $array_allow_field)) {
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

            $comment = '';
            if (!empty($row_field['system'])) {
                if ($row_field['field'] == 'birthday') {
                    $comment .= 'dd/mm/YYYY';
                } elseif ($row_field['field'] == 'sig') {
                    $comment = sprintf($lang_module['comment_sig'], $row_field['min_length'], $row_field['max_length']);
                }
                if ($row_field['required']) {
                    //
                }
                if ($row_field['description']) {
                    //
                }
                if ($row_field['field'] == 'gender') {
                    //
                }
            } else {
                if ($row_field['required']) {
                    //
                }
                if ($row_field['description']) {
                    //
                }
                if ($row_field['field_type'] == 'textbox' or $row_field['field_type'] == 'number') {} elseif ($row_field['field_type'] == 'date') {
                    //
                } elseif ($row_field['field_type'] == 'textarea') {
                    //
                } elseif ($row_field['field_type'] == 'editor') {
                    //
                } elseif ($row_field['field_type'] == 'select') {
                    //
                } elseif ($row_field['field_type'] == 'radio') {
                    //
                }
            }

            $array_field[$row_field['field']] = array(
                'field' => $row_field['field'],
                'text' => $row_field['title'],
                'required' => $row_field['required'],
                'comment' => $comment
            );
        }
    }

    return $array_field;
}

if ($nv_Request->isset_request('guide', 'post')) {

    $array_field = nv_get_field();

    $xtpl = new XTemplate('import.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('URL_DOWNLOAD', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=import&download=1');

    foreach ($array_field as $data) {
        $data['required'] = $lang_module['required_' . $data['required']];
        $xtpl->assign('DATA', $data);
        $xtpl->parse('guide.loop');
    }

    $xtpl->parse('guide');
    $contents = $xtpl->text('guide');

    die($contents);
}

if ($nv_Request->isset_request('download', 'get')) {

    $array_field = nv_get_field();

    // xuất csv
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

    $output = fopen('php://output', 'w');

    $field = array();
    foreach ($array_field as $data) {
        $field[] = $data['text'];
    }
    fputcsv($output, $field);
    die();
}

if ($nv_Request->isset_request('upload', 'post')) {
    $array_field = nv_get_field();

    if (isset($_FILES['file']) and is_uploaded_file($_FILES['file']['tmp_name'])) {
        $filename = nv_string_to_filename($_FILES['file']['name']);
        $file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename;

        if (file_exists($file)) {
            unlink($file);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
            // đọc file csv theo dòng
            $file = new SplFileObject($file);

            $array_data = array();
            while (!$file->eof()) {
                $line = str_getcsv($file->fgets());
                if (implode($line) == null) continue;
                $line = array_combine(array_keys(nv_get_field()), $line);
                $array_data[] = $line;
            }

            // nếu số lượng các cột không giống nhau
            if (sizeof($array_data[0]) != sizeof($array_field)) {
                nv_jsonOutput(array(
                    'error' => 1,
                    'msg' => $lang_module['error_file_struct']
                ));
            }

            // xóa header
            unset($array_data[0]);

            nv_jsonOutput(array(
                'error' => 0,
                'filename' => $filename,
                'total' => sizeof($array_data),
                'data' => $array_data
            ));
        }
    }
    nv_jsonOutput(array(
        'error' => 1,
        'msg' => $lang_module['error_required_file']
    ));
}

if ($nv_Request->isset_request('readline', 'post')) {
    $check = $nv_Request->get_int('check', 'post', 0);
    $current = $nv_Request->get_int('current', 'post', 0);
    $filename = $nv_Request->get_title('file_name', 'post', '');
    $file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename;

    if (!empty($current) and file_exists($file)) {
        // đọc file csv theo dòng
        $file = new SplFileObject($file);
        $file->seek($current);

        $array_error = array();

        $array_data = str_getcsv($file->current());
        $array_data = array_combine(array_keys(nv_get_field()), $array_data);
        $exit = $file->eof() ? 1 : 0;

        $array_data_tmp = $array_data;
        $custom_fields = $array_data_tmp;

        if ($check) {
            foreach ($array_data as $field => $value) {
                // nếu chế độ kiểm tra dữ liệu
                if ($field == 'part_id') {
                    if (!isset($array_part[$value])) {
                        $array_error[] = $lang_module['error_required_part_id'];
                    }
                }

                if ($field == 'lastname' and empty($value)) {
                    $array_error[] = $lang_module['error_required_lastname'];
                }

                if ($field == 'firstname' and empty($value)) {
                    $array_error[] = $lang_module['error_required_firstname'];
                }

                if ($field == 'birthday') {
                    if (!preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $value, $m)) {
                        $array_error[] = $lang_module['error_required_birthday'];
                    }
                }

                if ($field == 'jobtitle_id' and empty($value)) {
                    $array_error[] = $lang_module['error_required_jobtitle_id'];
                }

                if ($field == 'email' and !empty($value) and (($error_email = nv_check_valid_email($value)) != '')) {
                    $array_error[] = $error_email;
                }
            }
            $array_error = $array_error + nv_users_field_check($custom_fields);
        } else {
            if (is_numeric($array_data['jobtitle_id'])) {
                $array_data['jobtitle_id'] = array(
                    $array_data['jobtitle_id']
                );
            } else {
                $array_data['jobtitle_id'] = explode(',', $array_data['jobtitle_id']);
            }

            if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $array_data['birthday'], $m)) {
                $array_data['birthday'] = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
            } else {
                $array_data['birthday'] = 0;
            }

            if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $array_data['unionist_date'], $m)) {
                $array_data['unionist_date'] = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
            } else {
                $array_data['unionist_date'] = 0;
            }

            if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $array_data['party_date_tmp'], $m)) {
                $array_data['party_date_tmp'] = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
            } else {
                $array_data['party_date_tmp'] = 0;
            }

            if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $array_data['party_date'], $m)) {
                $array_data['party_date'] = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
            } else {
                $array_data['party_date'] = 0;
            }

            $array_data['birthday_day'] = date('d', $array_data['birthday']);
            $array_data['birthday_month'] = date('m', $array_data['birthday']);
            $array_data['birthday_year'] = date('Y', $array_data['birthday']);

            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows (lastname, firstname, birthday, birthday_day, birthday_month, birthday_year, gender, image, email, phone, unionist_date, unionist_code, party_date_tmp, party_date, party_date_code, resident, temporarily, part_id, nation, religion, education, idspecialize, idpolitic, idlanguage, addtime, edittime, prior, status) VALUES (:lastname, :firstname, :birthday, :birthday_day, :birthday_month, :birthday_year, :gender, :image, :email, :phone, :unionist_date, :unionist_code, :party_date_tmp, :party_date, :party_date_code, :resident, :temporarily, :part_id, :nation, :religion, :education, :idspecialize, :idpolitic, :idlanguage, ' . NV_CURRENTTIME . ', 0, :prior, 1)';
            $data_insert = array();
            $data_insert['lastname'] = $array_data['lastname'];
            $data_insert['firstname'] = $array_data['firstname'];
            $data_insert['birthday'] = $array_data['birthday'];
            $data_insert['birthday_day'] = $array_data['birthday_day'];
            $data_insert['birthday_month'] = $array_data['birthday_month'];
            $data_insert['birthday_year'] = $array_data['birthday_year'];
            $data_insert['gender'] = $array_data['gender'];
            $data_insert['image'] = $array_data['image'];
            $data_insert['email'] = $array_data['email'];
            $data_insert['phone'] = $array_data['phone'];
            $data_insert['unionist_date'] = $array_data['unionist_date'];
            $data_insert['unionist_code'] = $array_data['unionist_code'];
            $data_insert['party_date_tmp'] = $array_data['party_date_tmp'];
            $data_insert['party_date'] = $array_data['party_date'];
            $data_insert['party_date_code'] = $array_data['party_date_code'];
            $data_insert['resident'] = $array_data['resident'];
            $data_insert['temporarily'] = $array_data['temporarily'];
            $data_insert['part_id'] = $array_data['part_id'];
            $data_insert['nation'] = $array_data['nation'];
            $data_insert['religion'] = $array_data['religion'];
            $data_insert['education'] = $array_data['education'];
            $data_insert['idspecialize'] = $array_data['idspecialize'];
            $data_insert['idpolitic'] = $array_data['idpolitic'];
            $data_insert['idlanguage'] = $array_data['idlanguage'];
            $data_insert['prior'] = $array_data['prior'];
            $new_id = $db->insert_id($sql, 'id', $data_insert);

            if ($new_id > 0) {
                $query_field['rows_id'] = $new_id;
                $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_info (' . implode(', ', array_keys($query_field)) . ') VALUES (' . implode(', ', array_values($query_field)) . ')');

                $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows_jobtitle (rows_id, jobtitle_id) VALUES( :rows_id, :jobtitle_id )');
                foreach ($array_data['jobtitle_id'] as $jobtitle_id) {
                    $sth->bindParam(':rows_id', $new_id, PDO::PARAM_INT);
                    $sth->bindParam(':jobtitle_id', $jobtitle_id, PDO::PARAM_INT);
                    $sth->execute();
                }

                nv_jsonOutput(array(
                    'error' => 0,
                    'msg' => $lang_module['import_success'],
                    'exit' => $exit
                ));
            } else {
                nv_jsonOutput(array(
                    'error' => 1,
                    'msg' => $lang_module['import_error'],
                    'exit' => $exit
                ));
            }

        }

        $notify = '';
        if ($exit) {
            $notify = sprintf($lang_module['checking'], $array_data['firstname']);
        }

        if (!empty($array_error)) {
            nv_jsonOutput(array(
                'error' => 1,
                'firstname' => $array_data['firstname'],
                'msg' => implode(', ', $array_error),
                'current' => $current,
                'notify' => $notify,
                'exit' => $exit
            ));
        }

        nv_jsonOutput(array(
            'error' => 0,
            'current' => $current,
            'notify' => $notify,
            'filename' => $filename,
            'exit' => $exit
        ));
    }
    nv_jsonOutput(array(
        'error' => 0,
        'current' => $current,
        'exit' => 1
    ));
}

if ($nv_Request->isset_request('step2', 'post')) {
    if (isset($_FILES['file']) and is_uploaded_file($_FILES['file']['tmp_name'])) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . basename($_FILES['file']['tmp_name']))) {
            nv_jsonOutput(array(
                'error' => 0
            ));
        }
    }

    nv_jsonOutput(array(
        'error' => 1,
        'msg' => $lang_module['error_required_file']
    ));
}

$page_title = $lang_module['import'];

$xtpl = new XTemplate('import.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('URL_DOWNLOAD', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=import&download=1');

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
