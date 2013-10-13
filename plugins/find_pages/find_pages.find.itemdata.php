<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.itemdata
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

if ($item['node_reftype'] == 'page')
{
	$t->assign(cot_generate_pagetags($item['data'], 'FIND_', $cfg['page']['truncatetext'], $usr['isadmin']));
	$t->assign(cot_generate_usertags($item['data'], 'FIND_OWNER_'));
	$t->assign(array(
		'FIND_OWNER' => cot_build_user($item['data']['page_ownerid'], htmlspecialchars($item['data']['user_name'])),
		'FIND_ODDEVEN' => cot_build_oddeven($jj),
		'FIND_NUM' => $jj
	));
	$text = $item['data']['page_text'];
}