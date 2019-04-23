<!-- BEGIN: main -->
<form action="{BASE_URL_SITE}" method="get">
	<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
	<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
	<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP_NAME}" />

	<div class="form-group">
		<label>{LANG.search_keywods}</label>
		<input type="text" class="form-control" name="q" value="{SEARCH.q}" />
	</div>
	<div class="form-group">
		<label>{LANG.part}</label>
		<select class="form-control" name="part_id">
			<option value="0">---{LANG.part_c}---</option>
			<!-- BEGIN: loop -->
			<option value="{PART.id}" {PART.selected}>{PART.title}</option>
			<!-- END: loop -->
		</select>
	</div>
	<div class="text-center">
		<input type="submit" class="btn btn-primary" value="{LANG.search}" />
	</div>
</form>
<!-- END: main -->