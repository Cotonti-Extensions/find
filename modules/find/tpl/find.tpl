<!-- BEGIN: MAIN -->
<div class="col25 top bottom last">
	<h2>{PHP.L.find_title}</h2>
	<form action="{FORM_ACTION}" method="GET">
	<div id="find_form">
		<input type="text" name="q" value="{PHP.query}" />
		<button type="submit">{PHP.L.Search}</button>
	</div>
	<div id="find_sources">
		<h3>{PHP.L.find_in}</h3>
		<ul>
			<!-- BEGIN: SOURCES -->
			<li>
				<a href="{URL}"{CLASS}>{TITLE}</a>{INPUT}
				<!-- BEGIN: FIELDS -->
				<ul>
					<!-- BEGIN: FIELD -->
					<li>{CHECKBOX}</li>
					<!-- END: FIELD -->
				</ul>
				<!-- END: FIELDS -->
			</li>
			<!-- END: SOURCES -->
		</ul>
	</div>
	</form>
	<p class="sidebar_hint">{PHP.L.find_hint}</p>
</div>
<div class="col75 top bottom">
	<!-- BEGIN: RESULTS -->
	<div id="find_paging" class="pagination">{PAGE_PREV}{PAGE_NAV}{PAGE_NEXT}</div>
	<div id="find_results">
		<h3>{PHP.q|htmlspecialchars($this)}</h3>
		<small>{RESULTS_TEXT}</small>
		<!-- BEGIN: ITEMS -->
		<div>
			<b>{TYPE_NAME}:</b> <a href="{FIND_URL}">{FIND_SHORTTITLE}</a> <small>{FIND_DATE_STAMP|cot_date('date_text', $this)}</small>
			<p>{EXTRACT}...</p>
		</div>
		<!-- END: ITEMS -->
	</div>
	<div id="find_paging" class="pagination">{PAGE_PREV}{PAGE_NAV}{PAGE_NEXT}</div>
	<!-- END: RESULTS -->
	<!-- BEGIN: NORESULTS -->
	<p>{PHP.L.find_no_resultst}</p>
	<!-- END: NORESULTS -->
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$('#find_form input').focus();
});
//]]>
</script>
<!-- END: MAIN -->