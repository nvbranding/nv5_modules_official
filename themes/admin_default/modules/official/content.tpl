<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->

<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">{LANG.info}</div>
        <div class="panel-body">
            <input type="hidden" name="id" value="{ROW.id}" />
            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.lastname}</strong> <span class="red">(*)</span></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="lastname" value="{ROW.lastname}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.firstname}</strong> <span class="red">(*)</span></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="firstname" value="{ROW.firstname}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.email}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="email" name="email" value="{ROW.email}" oninvalid="setCustomValidity( nv_email )" oninput="setCustomValidity('')" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.phone}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="phone" value="{ROW.phone}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.resident}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="resident" value="{ROW.resident}" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.temporarily}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="temporarily" value="{ROW.temporarily}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.birthday}</strong> <span class="red">(*)</span></label>
                        <div class="col-xs-18">
                            <div class="input-group">
                                <input class="form-control" type="text" name="birthday" value="{ROW.birthday}" id="birthday" pattern="^[0-9]{2,2}\/[0-9]{2,2}\/[0-9]{1,4}$" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" /> <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="birthday-btn">
                                        <em class="fa fa-calendar fa-fix"> </em>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 text-right"><strong>{LANG.gender}</strong></label>
                        <div class="col-xs-18">
                            <!-- BEGIN: gender -->
                            <label><input class="form-control" type="radio" name="gender" value="{GENDER.key}" {GENDER.checked} />{GENDER.value}</label>&nbsp;&nbsp;&nbsp;
                            <!-- END: gender -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.nation}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="nation" value="{ROW.nation}" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.religion}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="religion" value="{ROW.religion}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-24 col-sm-24">
                    <div class="form-group">
                        <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.image}</strong></label>
                        <div class="col-sm-19 col-md-21">
                            <div class="input-group">
                                <input class="form-control" type="text" name="image" value="{ROW.image}" id="id_image" /> <span class="input-group-btn">
                                    <button class="btn btn-default selectfile" type="button">
                                        <em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">{LANG.info_specialize}</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.part_id}</strong> <span class="red">(*)</span></label>
                        <div class="col-xs-18">
                            <select class="form-control" name="part_id">
                                <option value="">---{LANG.part_id_c}---</option>
                                <!-- BEGIN: part_id -->
                                <option value="{PART.id}"{PART.selected}>{PART.space}{PART.title}</option>
                                <!-- END: part_id -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.jobtitle}</strong> <span class="red">(*)</span></label>
                        <div class="col-xs-18">
                            <select class="form-control" name="jobtitle_id[]" id="jobtitle_id" multiple="multiple">
                                <option value="">---{LANG.jobtitle_c}---</option>
                                <!-- BEGIN: jobtitle -->
                                <option value="{JOBTITLE.id}"{JOBTITLE.selected}>{JOBTITLE.title}</option>
                                <!-- END: jobtitle -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.unionist_date}</strong></label>
                        <div class="col-xs-18">
                            <div class="input-group">
                                <input class="form-control" type="text" name="unionist_date" value="{ROW.unionist_date}" id="unionist_date" pattern="^[0-9]{2,2}\/[0-9]{2,2}\/[0-9]{1,4}$" /> <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="unionist_date-btn">
                                        <em class="fa fa-calendar fa-fix"> </em>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.unionist_code}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="unionist_code" value="{ROW.unionist_code}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.party_date_tmp}</strong></label>
                        <div class="col-xs-18">
                            <div class="input-group">
                                <input class="form-control datepicker" type="text" name="party_date_tmp" value="{ROW.party_date_tmp}" pattern="^[0-9]{2,2}\/[0-9]{2,2}\/[0-9]{1,4}$" /> <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <em class="fa fa-calendar fa-fix"> </em>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.party_date}</strong></label>
                        <div class="col-xs-18">
                            <div class="input-group">
                                <input class="form-control datepicker" type="text" name="party_date" value="{ROW.party_date}" pattern="^[0-9]{2,2}\/[0-9]{2,2}\/[0-9]{1,4}$" /> <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="unionist_date-btn">
                                        <em class="fa fa-calendar fa-fix"> </em>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.party_date_code}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="party_date_code" value="{ROW.party_date_code}" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.education}</strong></label>
                        <div class="col-xs-18">
                            <input class="form-control" type="text" name="education" value="{ROW.education}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.specialize}</strong></label>
                        <div class="col-xs-18">
                            <select name="idspecialize" class="form-control">
                                <option value="0">---{LANG.specialize_c}---</option>
                                <!-- BEGIN: specialize -->
                                <option value="{SPECIALIZE.id}"{SPECIALIZE.selected}>{SPECIALIZE.title}</option>
                                <!-- END: specialize -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.politic}</strong></label>
                        <div class="col-xs-18">
                            <select name="idpolitic" class="form-control">
                                <option value="0">---{LANG.politic_c}---</option>
                                <!-- BEGIN: politic -->
                                <option value="{POLITIC.id}"{POLITIC.selected}>{POLITIC.title}</option>
                                <!-- END: politic -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.language}</strong></label>
                        <div class="col-xs-18">
                            <select name="idlanguage" class="form-control">
                                <option value="0">---{LANG.language_c}---</option>
                                <!-- BEGIN: language -->
                                <option value="{LANGUAGE.id}"{LANGUAGE.selected}>{LANGUAGE.title}</option>
                                <!-- END: language -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-12">
                    <div class="form-group">
                        <label class="col-xs-6 control-label"><strong>{LANG.prior}</strong></label>
                        <div class="col-xs-18">
                            <select name="prior" class="form-control">
                                <!-- BEGIN: prior -->
                                <option value="{PRIOR.index}"{PRIOR.selected}>{PRIOR.index}</option>
                                <!-- END: prior -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: field -->
    <div class="panel panel-default">
        <div class="panel-heading">{LANG.fields}</div>
        <div class="panel-body">
            <!-- BEGIN: loop -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"> <strong>{FIELD.title}</strong> <!-- BEGIN: required --> <span class="red">(*)</span> <!-- END: required -->
                </label>
                <div class="col-sm-19 col-md-20">
                    <!-- BEGIN: textbox -->
                    <input class="form-control {FIELD.required}" type="text" name="custom_fields[{FIELD.field}]" value="{FIELD.value}" />
                    <!-- END: textbox -->
                    <!-- BEGIN: date -->
                    <div class="input-group">
                        <input class="form-control datepicker {FIELD.required}" type="text" name="custom_fields[{FIELD.field}]" value="{FIELD.value}" pattern="^[0-9]{2,2}\/[0-9]{2,2}\/[0-9]{1,4}$" /> <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <em class="fa fa-calendar fa-fix"> </em>
                            </button>
                        </span>
                    </div>
                    <!-- END: date -->
                    <!-- BEGIN: textarea -->
                    <textarea rows="5" cols="70" class="form-control" name="custom_fields[{FIELD.field}]">{FIELD.value}</textarea>
                    <!-- END: textarea -->
                    <!-- BEGIN: editor -->
                    {EDITOR}
                    <!-- END: editor -->
                    <!-- BEGIN: select -->
                    <select class="form-control" name="custom_fields[{FIELD.field}]">
                        <!-- BEGIN: loop -->
                        <option value="{FIELD_CHOICES.key}"{FIELD_CHOICES.selected}>{FIELD_CHOICES.value}</option>
                        <!-- END: loop -->
                    </select>
                    <!-- END: loopselect -->
                    <!-- BEGIN: radio -->
                    <label for="lb_{FIELD_CHOICES.id}"> <input type="radio" name="custom_fields[{FIELD.field}]" value="{FIELD_CHOICES.key}" id="lb_{FIELD_CHOICES.id}"{FIELD_CHOICES.checked}> {FIELD_CHOICES.value}
                    </label>
                    <!-- END: radio -->
                    <!-- BEGIN: checkbox -->
                    <label for="lb_{FIELD_CHOICES.id}"> <input type="checkbox" name="custom_fields[{FIELD.field}][]" value="{FIELD_CHOICES.key}" id="lb_{FIELD_CHOICES.id}"{FIELD_CHOICES.checked}> {FIELD_CHOICES.value}
                    </label>
                    <!-- END: checkbox -->
                    <!-- BEGIN: multiselect -->
                    <select class="form-control" name="custom_fields[{FIELD.field}][]" multiple="multiple">
                        <!-- BEGIN: loop -->
                        <option value="{FIELD_CHOICES.key}"{FIELD_CHOICES.selected}>{FIELD_CHOICES.value}</option>
                        <!-- END: loop -->
                    </select>
                    <!-- END: multiselect -->
                    <small class="help-block"><em>{FIELD.description}</em></small>
                </div>
            </div>
            <!-- END: loop -->
        </div>
    </div>
    <!-- END: field -->
    <div class="form-group" style="text-align: center">
        <input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
    </div>
</form>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function() {
        $("#jobtitle_id").select2();
    });
    
    $("#birthday,#unionist_date,#party_date,.datepicker").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth : !0,
        changeYear : !0,
        showOtherMonths : !0,
        showOn : "focus",
        yearRange : "-90:+0"
    });
    
    $(".selectfile").click(function() {
        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    //]]>
</script>
<!-- END: main -->