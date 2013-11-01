<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */
(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

require_once cot_incfile('find', 'module');
require_once cot_langfile('find', 'module');

$t = new XTemplate(cot_tplfile('find.admin', 'module'));

$adminpath[] = array(cot_url('admin', 'm=other'), $L['Other']);
$adminpath[] = array(cot_url('admin', 'm=find'), $L['Search']);
$adminhelp = $L['adm_help_find'];

if ($a == 'indexall')
{
	$reftypes = cot_import('reftypes', 'G', 'TXT');
	if (empty($reftypes)) $reftypes = '';

	$start_row = cot_import('start_row', 'G', 'INT');
	if (empty($start_row) || !$start_row) $start_row = 0;

	$qcount = cot_import('qcount', 'G', 'INT');
	if (empty($qcount) || !$qcount) $qcount = 0;

	$start = cot_import('start', 'G', 'NUM');
	if (empty($start) || !$start) $start = microtime(true);

	$qcount = find_index_all($reftypes, $start_row, $qcount, $start);
	if (COT_AJAX) exit();
	$time = cot_build_timegap($start, microtime(true), 2);
	$t->assign(array(
		'QUERY_COUNT' => $qcount,
		'EXECUTION_TIME' => $time,
		'EXECUTED' => cot_rc($L['indexer_executed'], array('queries' => $qcount, 'time' => $time))
	));
	$t->parse('MAIN.INDEXING_DONE');
}

$nodes = $db->query("SELECT COUNT(node_id) AS count FROM {$db_x}indexer_nodes")->fetch();
$words = $db->query("SELECT COUNT(word_id) AS count FROM {$db_x}indexer_words")->fetch();
$occurrences = $db->query("SELECT COUNT(node_id) AS count FROM {$db_x}indexer_occurrences")->fetch();

$top5 = $db->query("
	SELECT w.word_value AS word, SUM(o.occurrences) AS count
	FROM {$db_x}indexer_occurrences AS o
	INNER JOIN {$db_x}indexer_words AS w ON w.word_id = o.word_id
	GROUP BY o.word_id ORDER BY count DESC LIMIT 5");
while ($row = $top5->fetch())
{
	$t->assign(array(
		'WORD' => $row['word'],
		'COUNT' => $row['count']
	));
	$t->parse('MAIN.TOP5');
}

$t->assign(array(
	'INDEXALL_URL' => cot_url('admin', 'm=find&a=indexall'),
	'NODES_COUNT' => $nodes['count'],
	'WORDS_COUNT' => $words['count'],
	'OCCURRENCES_COUNT' => $occurrences['count']
));

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
