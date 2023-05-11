<!-- BEGIN: MAIN -->
<div class="block">
<h2>{PHP.L.indexer_title}</h2>
	<div class="wrapper">
		<!-- BEGIN: INDEXING_DONE -->
		<div class="done">
			<h4>{PHP.L.indexer_complete}</h4>
			<p>{EXECUTED}</p>
		</div>
		<!-- END: INDEXING_DONE -->

		<div id="reindexall">
			&raquo; <a href="{INDEXALL_URL}" class="ajax" rel="get-reindexall">{PHP.L.indexer_reindex_all}</a> ({PHP.L.indexer_reindex_all_note})
		</div>
	</div>
</div>

<div class="block">
	<h2>{PHP.L.indexer_statistics}</h2>
	<div class="wrapper">
		<div class="col4-2">
			<h3>{PHP.L.find_adm_counts}</h3>
			<table class="cells">
				<tr>
					<td>{PHP.L.indexer_nodes}: </td>
					<td>{NODES_COUNT|cot_build_number($this)}</td>
				</tr>
				<tr>
					<td>{PHP.L.indexer_words}:</td>
					<td>{WORDS_COUNT|cot_build_number($this)}</td>
				</tr>
				<tr>
					<td>{PHP.L.indexer_occurrences}</td>
					<td>{OCCURRENCES_COUNT|cot_build_number($this)}</td>
				</tr>
			</table>
		</div>
		<div class="col4-2">
			<h3>{PHP.L.find_top5}</h3>
			<ol>
				<!-- BEGIN: TOP5 -->
				<li><strong>{WORD}</strong> ({COUNT|cot_build_number($this)})</li>
				<!-- END: TOP5 -->
			</ol>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- END: MAIN -->