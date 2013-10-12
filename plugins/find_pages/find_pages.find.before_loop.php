<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.before_loop
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('extrafields');
require_once cot_incfile('page', 'module');

$page_ids = array();
foreach ($items as $item) if ($item['node_reftype'] == 'page') $page_ids[] = $item['node_refid'];if (count($page_ids))
{
	$res = $db->query("SELECT * FROM $db_pages WHERE page_id IN (".implode(',', $page_ids).")");
	$page_rows = $res->fetchAll();
	foreach ($page_rows as $k => $v)
	{		$page_rows[$v['page_id']] = $v;
		unset($page_rows[$k]);	}
	foreach ($items as $k => $item) if ($item['node_reftype'] == 'page' && isset($page_rows[$item['node_refid']])) $items[$k]['data'] = $page_rows[$item['node_refid']];}