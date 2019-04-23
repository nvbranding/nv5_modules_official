<!-- BEGIN: main -->
<div class="marquee">
	<ul class="birthday">
		<!-- BEGIN: loop -->
		<li class="clearfix">
			<!-- BEGIN: image -->
			<div class="image pull-left">
				<a href="{DATA.link}" title="{DATA.fullname}"><img src="{DATA.image}" alt="{DATA.fullname}" class="img-thumbnail" width="70"></a>
			</div> <!-- END: image -->
			<h3>
				<a href="{DATA.link}" title="{DATA.fullname}">{DATA.fullname}</a>
			</h3> <span class="help-block">{DATA.birthday}</span>
		</li>
		<!-- END: loop -->
	</ul>
</div>
<!-- BEGIN: marquee -->
<script type='text/javascript' src='{NV_BASE_SITEURL}themes/{TEMPLATE}/js/official-jquery.marquee.min.js'></script>
<script>
	$('.marquee').marquee({
		direction: 'up',
		duplicated: true
	});
</script>
<!-- END: marquee -->
<!-- END: main -->