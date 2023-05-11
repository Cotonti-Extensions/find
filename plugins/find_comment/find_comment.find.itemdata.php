<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.itemdata
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

if ($item['node_reftype'] == 'comment') {
	$t->assign(cot_generate_pagetags(
        $item['data'],
        'FIND_',
        Cot::$cfg['page']['cat___default']['truncatetext'],
        cot_auth('page', $item['data']['page_cat'], 'A')
    ));
	$t->assign(cot_generate_usertags($item['data'], 'FIND_PAGE_OWNER_'));

    $owner = !empty($item['data']['user_id']) && !empty($item['data']['user_name']) ?
        cot_build_user($item['data']['user_id'], $item['data']['user_name']) : Cot::$L['Deleted'];

	$t->assign(array(
		'FIND_URL' => (empty($item['data']['page_alias'])) ? cot_url('page', 'c='.$item['data']['page_cat'].'&id='.$item['data']['page_id'], '#c'.$item['data']['com_id']) : cot_url('page', 'c='.$item['data']['page_cat'].'&al='.$item['data']['page_alias'], '#c'.$item['data']['com_id']),
		'FIND_OWNER' => cot_build_user($item['data']['com_authorid'], htmlspecialchars($item['data']['com_author'])),
		'FIND_PAGE_OWNER' => $owner,
		'FIND_ODDEVEN' => cot_build_oddeven($jj),
		'FIND_NUM' => $jj
	));
	$text = $item['data']['com_text'];

	/* === Hook === */
	foreach (cot_getextplugins('find.itemdata.comment') as $pl) {
		include $pl;
	}
	/* ===== */
}