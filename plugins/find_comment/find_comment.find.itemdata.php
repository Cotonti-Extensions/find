<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.itemdata
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

$t->assign(cot_generate_pagetags($item['data'], 'FIND_PAGE_', $cfg['page']['truncatetext'], $usr['isadmin']));
$t->assign(array(
	'FIND_PAGE_OWNER' => cot_build_user($item['data']['page_ownerid'], htmlspecialchars($itemg['data']['user_name'])),
	'FIND_PAGE_ODDEVEN' => cot_build_oddeven($jj),
	'FIND_NUM' => $jj
));
$t->assign(cot_generate_usertags($item['data'], 'FIND_PAGE_OWNER_'));

$t->assign(array(
	'FIND_URL' => cot_comments_link(
		'page',
		array(
			'c='.$item['data']['page_cat'].'&al='.$item['data']['page_alias'].'#c='.$item['data']['com_id'],
			'c='.$item['data']['page_cat'].'&id='.$item['data']['page_id'].'#c='.$item['data']['com_id']
		),
		'page',
		$item['data']['page_id'],
		$item['data']['page_cat']
	),
	'FIND_TITLE' => $item['data']['page_title']
));
$text = $item['data']['com_text'];