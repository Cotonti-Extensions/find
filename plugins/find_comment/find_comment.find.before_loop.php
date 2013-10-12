<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.before_loop
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('extrafields');
require_once cot_incfile('page', 'module');
require_once cot_incfile('comments', 'plug');

$com_ids = array();
foreach ($items as $item) if ($item['node_reftype'] == 'comment') $com_ids[] = $item['node_refid'];
if (count($com_ids))
{
	$res = $db->query("SELECT c.*, p.* FROM $db_com AS c LEFT JOIN $db_pages AS p ON p.page_id = c.com_code AND c.com_area = 'page' WHERE c.com_id IN (".implode(',', $com_ids).") AND c.com_area = 'page'");
	$page_rows = $res->fetchAll();
	foreach ($page_rows as $k => $v)
	{
		$page_rows[$v['com_id']] = $v;
		unset($page_rows[$k]);
	}
	foreach ($items as $k => $item) if ($item['node_reftype'] == 'comment' && isset($page_rows[$item['node_refid']])) $items[$k]['data'] = $page_rows[$item['node_refid']];
}