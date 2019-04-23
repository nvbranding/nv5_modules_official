<!-- BEGIN: main -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<colgroup>
			<col width="50" />
		</colgroup>
		<thead>
			<tr>
				<th class="text-center">{LANG.number}</th>
				<th>{LANG.lastname}</th>
				<th>{LANG.firstname}</th>
				<th>{LANG.part}</th>
				<th>{LANG.jobtitle}</th>
				<th>{LANG.phone}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">{DATA.number}</td>
				<td>{DATA.lastname}</td>
				<td><a href="{DATA.official_url}" title="{DATA.firstname}">{DATA.firstname}</a></td>
				<td><a href="{DATA.part_url}" title="{DATA.part}">{DATA.part}</a></td>
				<td>{DATA.jobtitle}</td>
				<td>{DATA.phone}</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: main -->