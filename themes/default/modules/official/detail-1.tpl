<!-- BEGIN: main -->
<div id="viewdetail" class="detail-1 <!-- BEGIN: isprint1 -->isprint<!-- END: isprint1 -->">
    <h1 class="m-bottom pull-left">{LANG.info}: {DATA.fullname}</h1>
    <button class="pull-right btn btn-default btn-xs hidden-print" onclick="nv_print_page('{URL}');">
        <em class="fa fa-print fa-lg">&nbsp;</em>{LANG.print}
    </button>
    <div class="clearfix"></div>
    <div class="panel panel-default">
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <td colspan="3" class="text-center"><img src="{DATA.image}" alt="{DATA.fullname}" class="img-thumbnail pointer" style="max-width: 200px" id="openImageModal" /></td>
            </tr>
            <tr>
                <th width="250">{LANG.fullname}</th>
                <td>{DATA.fullname}</td>
            </tr>
            <tr>
                <th>{LANG.part}</th>
                <td><a href="{DATA.part_url}" title="{DATA.part}">{DATA.part}</a></td>
            </tr>
            <tr>
                <th>{LANG.birthday}</th>
                <td>{DATA.birthday}</td>
            </tr>
            <tr>
                <th>{LANG.gender}</th>
                <td colspan="2">{DATA.gender}</td>
            </tr>
            <!-- BEGIN: email -->
            <tr>
                <th>{LANG.email}</th>
                <td colspan="2"><a href="mailto:{DATA.email}" title="Mail to: {DATA.email}">{DATA.email}</a></td>
            </tr>
            <!-- END: email -->
            <!-- BEGIN: phone -->
            <tr>
                <th>{LANG.phone}</th>
                <td colspan="2">{DATA.phone}</td>
            </tr>
            <!-- END: phone -->
            <!-- BEGIN: unionist_date -->
            <tr>
                <th>{LANG.unionist_date}</th>
                <td colspan="2">{DATA.unionist_date}</td>
            </tr>
            <!-- END: unionist_date -->
            <!-- BEGIN: unionist_code -->
            <tr>
                <th>{LANG.unionist_code}</th>
                <td colspan="2">{DATA.unionist_code}</td>
            </tr>
            <!-- END: unionist_code -->
            <!-- BEGIN: party_date_tmp -->
            <tr>
                <th>{LANG.party_date_tmp}</th>
                <td colspan="2">{DATA.party_date_tmp}</td>
            </tr>
            <!-- END: party_date_tmp -->
            <!-- BEGIN: party_date -->
            <tr>
                <th>{LANG.party_date}</th>
                <td colspan="2">{DATA.party_date}</td>
            </tr>
            <!-- END: party_date -->
            <!-- BEGIN: party_date_code -->
            <tr>
                <th>{LANG.party_date_code}</th>
                <td colspan="2">{DATA.party_date_code}</td>
            </tr>
            <!-- END: party_date_code -->
            <!-- BEGIN: resident -->
            <tr>
                <th>{LANG.resident}</th>
                <td colspan="2">{DATA.resident}</td>
            </tr>
            <!-- END: resident -->
            <!-- BEGIN: temporarily -->
            <tr>
                <th>{LANG.temporarily}</th>
                <td colspan="2">{DATA.temporarily}</td>
            </tr>
            <!-- END: temporarily -->
            <!-- BEGIN: nation -->
            <tr>
                <th>{LANG.nation}</th>
                <td colspan="2">{DATA.nation}</td>
            </tr>
            <!-- END: nation -->
            <!-- BEGIN: religion -->
            <tr>
                <th>{LANG.religion}</th>
                <td colspan="2">{DATA.religion}</td>
            </tr>
            <!-- END: religion -->
            <!-- BEGIN: education -->
            <tr>
                <th>{LANG.education}</th>
                <td colspan="2">{DATA.education}</td>
            </tr>
            <!-- END: education -->
            <!-- BEGIN: idspecialize -->
            <tr>
                <th>{LANG.specialize}</th>
                <td colspan="2">{DATA.specialize}</td>
            </tr>
            <!-- END: idspecialize -->
            <!-- BEGIN: idpolitic -->
            <tr>
                <th>{LANG.politic}</th>
                <td colspan="2">{DATA.politic}</td>
            </tr>
            <!-- END: idpolitic -->
            <!-- BEGIN: idlanguage -->
            <tr>
                <th>{LANG.language}</th>
                <td colspan="2">{DATA.language}</td>
            </tr>
            <!-- END: idlanguage -->
        </table>
    </div>
</div>
<!-- BEGIN: field -->
<!-- BEGIN: loop -->
<div class="panel panel-default">
    <div class="panel-heading">{FIELD.title}</div>
    <div class="panel-body">{FIELD.value}</div>
</div>
<!-- END: loop -->
<!-- END: field -->
<!-- BEGIN: isprint -->
<script type="text/javascript">
    $(document).ready(function() {
        window.print();
    });
</script>
<!-- END: isprint -->
<!-- END: main -->