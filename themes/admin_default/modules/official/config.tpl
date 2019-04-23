<!-- BEGIN: main -->
<form action="" method="post" class="form-horizontal">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-4 control-label">{LANG.config_per_page}</label>
                <div class="col-sm-20">
                    <div class="row">
                        <div class="col-xs-24 col-sm-12">
                            <select class="form-control" name="home_data">
                                <!-- BEGIN: home_data -->
                                <option value="{HOME_DATA.index}"{HOME_DATA.selected}>{HOME_DATA.value}</option>
                                <!-- END: home_data -->
                            </select>
                        </div>
                        <div class="col-xs-24 col-sm-12">
                            <select class="form-control" name="home_view">
                                <!-- BEGIN: home_view -->
                                <option value="{HOME_VIEW.index}"{HOME_VIEW.selected}>{HOME_VIEW.value}</option>
                                <!-- END: home_view -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">{LANG.config_order_by}</label>
                <div class="col-sm-20">
                    <div class="row">
                        <div class="col-xs-24 col-sm-12">
                            <select class="form-control" name="order_by">
                                <!-- BEGIN: order_by -->
                                <option value="{ORDER_BY.index}"{ORDER_BY.selected}>{ORDER_BY.value}</option>
                                <!-- END: order_by -->
                            </select>
                        </div>
                        <div class="col-xs-24 col-sm-12">
                            <select class="form-control" name="order_type">
                                <!-- BEGIN: order_type -->
                                <option value="{ORDER_TYPE.index}"{ORDER_TYPE.selected}>{ORDER_TYPE.value}</option>
                                <!-- END: order_type -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">{LANG.config_per_page}</label>
                <div class="col-sm-20">
                    <input type="number" name="per_page" value="{DATA.per_page}" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">{LANG.config_detail_style}</label>
                <div class="col-sm-20">
                    <select name="dstyle" class="form-control">
                        <!-- BEGIN: dstyle -->
                        <option value="{DSTYLE.index}"{DSTYLE.selected}>{DSTYLE.value}</option>
                        <!-- END: dstyle -->
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">&nbsp;</label>
                <div class="col-sm-20">
                    <input type="submit" class="btn btn-primary" value="{LANG.save}" name="savesetting" />
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $("#selectimg").click(function() {
        var area = "image";
        var path = "{NV_UPLOADS_DIR}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });
</script>
<!-- BEGIN: main -->