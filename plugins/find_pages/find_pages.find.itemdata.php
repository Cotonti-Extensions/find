<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.itemdata
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

$truncateText = cot::$cfg['page']['cat___default']['truncatetext'];

if ($item['node_reftype'] == 'page' && isset($item['data'])) {
    if (
        isset($item['data']['page_cat']) &&
        isset(cot::$cfg['page']['cat_'.$item['data']['page_cat']]) &&
        isset(cot::$cfg['page']['cat_'.$item['data']['page_cat']]['truncatetext'])
    ) {
        $truncateText = cot::$cfg['page']['cat_'.$item['data']['page_cat']]['truncatetext'];
    }

	$t->assign(cot_generate_pagetags($item['data'], 'FIND_', $truncateText, cot::$usr['isadmin']));
	$t->assign(cot_generate_usertags($item['data'], 'FIND_OWNER_'));
	$t->assign(array(
		'FIND_OWNER' => cot_build_user($item['data']['page_ownerid'], htmlspecialchars($item['data']['user_name'])),
		'FIND_ODDEVEN' => cot_build_oddeven($jj),
		'FIND_NUM' => $jj
	));
	$text = $item['data']['page_text'];
	/* === Hook === */
	foreach (cot_getextplugins('find.itemdata.page') as $pl) {
		include $pl;
	}
	/* ===== */
}