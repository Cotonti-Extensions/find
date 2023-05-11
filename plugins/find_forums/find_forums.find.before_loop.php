<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.before_loop
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forums', 'module');

$topic_ids = array();
foreach ($items as $item) {
    if ($item['node_reftype'] == 'forums.topics') {
        $topic_ids[] = $item['node_refid'];
    }
}
if (count($topic_ids)) {
	$res = $db->query("SELECT * FROM $db_forum_topics WHERE ft_id IN (".implode(',', $topic_ids).")");
	$topic_rows = $res->fetchAll();
	foreach ($topic_rows as $k => $v)
	{
		$topic_rows[$v['ft_id']] = $v;
		unset($topic_rows[$k]);
	}
	foreach ($items as $k => $item) if ($item['node_reftype'] == 'forums.topics' && isset($topic_rows[$item['node_refid']])) $items[$k]['data'] = $topic_rows[$item['node_refid']];
}
$post_ids = array();
foreach ($items as $item) if ($item['node_reftype'] == 'forums.posts') $post_ids[] = $item['node_refid'];
if (count($post_ids))
{
	$res = $db->query("SELECT p.*, t.*, u.* FROM $db_forum_posts AS p LEFT JOIN $db_forum_topics AS t ON ft_id=fp_topicid LEFT JOIN $db_users AS u ON u.user_id=p.fp_posterid WHERE fp_id IN (".implode(',', $post_ids).")");
	$post_rows = $res->fetchAll();
	foreach ($post_rows as $k => $v)
	{
		$post_rows[$v['fp_id']] = $v;
		unset($post_rows[$k]);
	}
	foreach ($items as $k => $item) if ($item['node_reftype'] == 'forums.posts' && isset($post_rows[$item['node_refid']])) $items[$k]['data'] = $post_rows[$item['node_refid']];
}
