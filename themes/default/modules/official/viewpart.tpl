<!-- BEGIN: main -->
<h1>{PART.title}</h1>
<hr />
<ul class="part-list-info">
    <!-- BEGIN: office -->
    <li><label><em class="fa fa-home">&nbsp;</em>{LANG.office}:</label> {PART.office}</li>
    <!-- END: office -->
    <!-- BEGIN: address -->
    <li><label><em class="fa fa-globe">&nbsp;</em>{LANG.address}:</label> {PART.address}</li>
    <!-- END: address -->
    <!-- BEGIN: phone -->
    <li><label><em class="fa fa-phone">&nbsp;</em>{LANG.phone}:</label> {PART.phone}</li>
    <!-- END: phone -->
    <!-- BEGIN: fax -->
    <li><label><em class="fa fa-fax">&nbsp;</em>Fax:</label> {PART.fax}</li>
    <!-- END: fax -->
    <!-- BEGIN: email -->
    <li><label><em class="fa fa-envelope-open-o">&nbsp;</em>Email:</label> {PART.email}</li>
    <!-- END: email -->
    <!-- BEGIN: website -->
    <li><label><em class="fa fa-fax">&nbsp;</em>Website:</label> <a href="{PART.website}" title="">{PART.website}</a></li>
    <!-- END: website -->
</ul>
<!-- BEGIN: note -->
<div class="panel panel-default">
    <div class="panel-body">{PART.note}</div>
</div>
<!-- END: note -->
{DATA}
<!-- END: main -->