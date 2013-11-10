<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.itemdata
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

if ($item['node_reftype'] == 'forums.topics')
{	$item['data']['ft_icon'] = 'posts';
	$item['data']['ft_postisnew'] = FALSE;
	$item['data']['ft_pages'] = '';
	$item['data']['ft_title'] = ($item['data']['ft_mode'] == 1) ? "# ".$item['data']['ft_title'] : $item['data']['ft_title'];
	if ($item['data']['ft_movedto'] > 0)
	{
		$item['data']['ft_url'] = cot_url('forums', "m=posts&q=".$item['data']['ft_movedto']);
		$item['data']['ft_icon'] = $R['forums_icon_posts_moved'];
		$item['data']['ft_title']= $L['Moved'].": ".$item['data']['ft_title'];
		$item['data']['ft_postcount'] = $R['forums_code_post_empty'];
		$item['data']['ft_replycount'] = $R['forums_code_post_empty'];
		$item['data']['ft_viewcount'] = $R['forums_code_post_empty'];
		$item['data']['ft_lastpostername'] = $R['forums_code_post_empty'];
		$item['data']['ft_lastposturl'] = cot_url('forums', "m=posts&q=".$item['data']['ft_movedto']."&n=last", "#bottom");
		$item['data']['ft_lastpostlink'] = cot_rc_link($item['data']['ft_lastposturl'], $R['icon_follow'], 'rel="nofollow"') .$L['Moved'];
	}
	else
	{
		$item['data']['ft_url'] = cot_url('forums', "m=posts&q=".$item['data']['ft_id']);
		$item['data']['ft_lastposturl'] = ($usr['id'] > 0 && $item['data']['ft_updated'] > $usr['lastvisit']) ? cot_url('forums', "m=posts&q=".$item['data']['ft_id']."&n=unread", "#unread") : cot_url('forums', "m=posts&q=".$item['data']['ft_id']."&n=last", "#bottom");
		$item['data']['ft_lastpostlink'] = cot_rc_link($item['data']['ft_lastposturl'], $R['icon_unread'], 'rel="nofollow"').cot_date('datetime_short', $item['data']['ft_updated']);
		$item['data']['ft_replycount'] = $item['data']['ft_postcount'] - 1;
		if ($item['data']['ft_updated'] > $usr['lastvisit'] && $usr['id']>0)
		{
			$item['data']['ft_icon'] .= '_new';
			$item['data']['ft_postisnew'] = TRUE;
		}
		if ($item['data']['ft_postcount'] >= $cfg['forums']['hottopictrigger'] && !$item['data']['ft_state'] && !$item['data']['ft_sticky'])
		{
			$item['data']['ft_icon'] = ($item['data']['ft_postisnew']) ? 'posts_new_hot' : 'posts_hot';
		}
		else
		{
			$item['data']['ft_icon'] .= ($item['data']['ft_sticky']) ? '_sticky' : '';
			$item['data']['ft_icon'] .=  ($item['data']['ft_state']) ? '_locked' : '';
		}
		$item['data']['ft_icon_type'] = $item['data']['ft_icon'];
		$item['data']['ft_icon'] = cot_rc('forums_icon_topic', array('icon' => $item['data']['ft_icon']));
		$item['data']['ft_lastpostername'] = cot_build_user($item['data']['ft_lastposterid'], htmlspecialchars($item['data']['ft_lastpostername']));
	}
	if ($item['data']['ft_postcount'] > $cfg['forums']['maxpostsperpage'] && !$item['data']['ft_movedto'])
	{
		$pn_q = $item['data']['ft_movedto'] > 0 ? $item['data']['ft_movedto'] : $item['data']['ft_id'];
		$pn = cot_pagenav('forums', 'm=posts&q='.$pn_q, 0, $item['data']['ft_postcount'], $cfg['forums']['maxpostsperpage'], 'd');
		$item['data']['ft_pages'] = cot_rc('forums_code_topic_pages', array('main' => $pn['main'], 'first' => $pn['first'], 'last' => $pn['last']));
	}
	$item['data']['ft_icon_type_ex'] = $item['data']['ft_icon_type'];
	if ($item['data']['ft_user_posted'])
	{
		$item['data']['ft_icon_type_ex'] .= '_posted';
	}
	$t->assign(array(
		'FIND_ID' => $item['data']['ft_id'],
		'FIND_STATE' => $item['data']['ft_state'],
		'FIND_ICON' => $item['data']['ft_icon'],
		'FIND_ICON_TYPE' => $item['data']['ft_icon_type'],
		'FIND_ICON_TYPE_EX' => $item['data']['ft_icon_type_ex'],
		'FIND_TITLE' => htmlspecialchars($item['data']['ft_title']),
		'FIND_DESC' => htmlspecialchars($item['data']['ft_desc']),
		'FIND_CREATIONDATE' => cot_date('datetime_short', $item['data']['ft_creationdate']),
		'FIND_CREATIONDATE_STAMP' => $item['data']['ft_creationdate'],
		'FIND_UPDATEDURL' => $item['data']['ft_lastposturl'],
		'FIND_UPDATED' => $item['data']['ft_lastpostlink'],
		'FIND_UPDATED_STAMP' => $item['data']['ft_updated'],
		'FIND_MOVED' => ($item['data']['ft_movedto'] > 0) ? 1 : 0,
		'FIND_TIMEAGO' => cot_build_timegap($item['data']['ft_updated']),
		'FIND_POSTCOUNT' => $item['data']['ft_postcount'],
		'FIND_REPLYCOUNT' => $item['data']['ft_replycount'],
		'FIND_VIEWCOUNT' => $item['data']['ft_viewcount'],
		'FIND_FIRSTPOSTER' => cot_build_user($item['data']['ft_firstposterid'], htmlspecialchars($item['data']['ft_firstpostername'])),
		'FIND_LASTPOSTER' => $item['data']['ft_lastpostername'],
		'FIND_USER_POSTED' => (int) $item['data']['ft_user_posted'],
		'FIND_URL' => $item['data']['ft_url'],
		'FIND_PREVIEW' => $item['data']['ft_preview'].'...',
		'FIND_PAGES' => $item['data']['ft_pages'],
		'FIND_MAXPAGES' => $item['data']['ft_maxpages'],
	));
	foreach ($cot_extrafields[$db_forum_topics] as $exfld)
	{
		$tag = mb_strtoupper($exfld['field_name']);
		$t->assign(array(
			'FIND_'.$tag.'_TITLE' => isset($L['forums_topics_'.$exfld['field_name'].'_title']) ?  $L['forums_topics_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
			'FIND_'.$tag => cot_build_extrafields_data('forums', $exfld, $item['data']['ft_'.$exfld['field_name']], ($cfg['forums']['markup'] && $cfg['forums']['cat_' . $s]['allowbbcodes'])),
			'FIND_'.$tag.'_VALUE' => $item['data']['ft_'.$exfld['field_name']]
		));
	}
	$t->assign(array(
		'FIND_SHORTTITLE' => htmlspecialchars($item['data']['ft_title']),
		'FIND_DATE' => cot_date('datetime_short', $item['data']['ft_creationdate']),
		'FIND_DATE_STAMP' => $item['data']['ft_creationdate'],
		'FIND_OWNER' => cot_build_user($item['data']['ft_firstposterid'], htmlspecialchars($item['data']['ft_firstpostername'])),
		'FIND_ODDEVEN' => cot_build_oddeven($jj),
		'FIND_NUM' => $jj
	));
	$text = $item['data']['ft_desc'];
	/* === Hook === */
	foreach (cot_getextplugins('find.itemdata.forums.topics') as $pl)
	{
		include $pl;
	}
	/* ===== */
}
if ($item['node_reftype'] == 'forums.posts')
{
	$item['data']['user_text'] = ($cfg['forums']['cat_' . $s]['allowusertext']) ? $item['data']['user_text'] : '';
	$rowedit_url = (($usr['isadmin'] || ($item['data']['fp_posterid'] == $usr['id'] && ($cfg['forums']['edittimeout'] == '0' || $sys['now'] - $item['data']['fp_creation'] < $cfg['forums']['edittimeout'] * 3600))) && $usr['id'] > 0) ? cot_url('forums', 'm=editpost&s=' . $s . '&q=' . $q . '&p=' . $item['data']['fp_id'] . '&d=' . $durl . '&' . cot_xg()) : '';
	$rowedit = (($usr['isadmin'] || ($item['data']['fp_posterid'] == $usr['id'] && ($cfg['forums']['edittimeout'] == '0' || $sys['now'] - $item['data']['fp_creation'] < $cfg['forums']['edittimeout'] * 3600))) && $usr['id'] > 0) ? cot_rc('forums_rowedit', array('url' => $rowedit_url)) : '';
	$rowdelete_url = ($usr['id'] > 0 && ($usr['isadmin'] || ($item['data']['fp_posterid'] == $usr['id'] && ($cfg['forums']['edittimeout'] == '0' || $sys['now'] - $item['data']['fp_creation'] < $cfg['forums']['edittimeout'] * 3600)))) ? cot_confirm_url(cot_url('forums', 'm=posts&a=delete&' . cot_xg() . '&s=' . $s . '&q=' . $q . '&p=' . $item['data']['fp_id'] . '&d=' . $durl), 'forums', 'forums_confirm_delete_post') : '';
	$rowdelete = ($usr['id'] > 0 && ($usr['isadmin'] || ($item['data']['fp_posterid'] == $usr['id'] && ($cfg['forums']['edittimeout'] == '0' || $sys['now'] - $item['data']['fp_creation'] < $cfg['forums']['edittimeout'] * 3600)) && $fp_num > 1)) ? cot_rc('forums_rowdelete', array('url' => $rowdelete_url)) : '';
	if (!empty($item['data']['fp_updater']))
	{
		$item['data']['fp_updatedby'] = sprintf($L['forums_updatedby'], htmlspecialchars($item['data']['fp_updater']), cot_date('datetime_medium', $item['data']['fp_updated']), cot_build_timegap($item['data']['fp_updated'], $sys['now']));
	}
	$t->assign(cot_generate_usertags($item['data'], 'FIND_USER'));
	$t->assign(array(
		'FIND_ID' => $item['data']['fp_id'],
		'FIND_POSTID' => 'post_'.$item['data']['fp_id'],
		'FIND_IDURL' => cot_url('forums', 'm=posts&id='.$item['data']['fp_id']),
		'FIND_URL' => cot_url('forums', 'm=posts&q='.$item['data']['fp_topicid'], '#'.$item['data']['fp_id']),
		'FIND_CREATION' => cot_date('datetime_medium', $item['data']['fp_creation']),
		'FIND_CREATION_STAMP' => $item['data']['fp_creation'],
		'FIND_UPDATED' => cot_date('datetime_medium', $item['data']['fp_updated']),
		'FIND_UPDATED_STAMP' => $item['data']['fp_updated'],
		'FIND_UPDATER' => htmlspecialchars($item['data']['fp_updater']),
		'FIND_UPDATEDBY' => $item['data']['fp_updatedby'],
		'FIND_TEXT' => cot_parse($item['data']['fp_text'], ($cfg['forums']['markup'] && $cfg['forums']['cat_' . $s]['allowbbcodes'])),
		'FIND_ANCHORLINK' => cot_rc('forums_code_post_anchor', array('id' => $item['data']['fp_id'])),
		'FIND_POSTERNAME' => cot_build_user($item['data']['fp_posterid'], htmlspecialchars($item['data']['fp_postername'])),
		'FIND_POSTERID' => $item['data']['fp_posterid'],
		'FIND_POSTERIP' => ($usr['isadmin']) ? cot_build_ipsearch($item['data']['fp_posterip']) : '',
		'FIND_DELETE' => $rowdelete,
		'FIND_DELETE_URL' => $rowdelete_url,
		'FIND_EDIT' => $rowedit,
		'FIND_EDIT_URL' => $rowedit_url,
	));
	foreach ($cot_extrafields[$db_forum_posts] as $exfld)
	{
		$tag = mb_strtoupper($exfld['field_name']);
		$t->assign(array(
			'FIND_'.$tag.'_TITLE' => isset($L['forums_posts_'.$exfld['field_name'].'_title']) ?  $L['forums_posts_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
			'FIND_'.$tag => cot_build_extrafields_data('forums', $exfld, $item['data']['fp_'.$exfld['field_name']], ($cfg['forums']['markup'] && $cfg['forums']['cat_' . $s]['allowbbcodes'])),
			'FIND_'.$tag.'_VALUE' => $item['data']['fp_'.$exfld['field_name']]
		));
	}
	$item['data']['ft_title'] = (($item['data']['ft_mode'] == 1) ? '# ' : '') . $item['data']['ft_title'];
	$crumbs = cot_forums_buildpath($s);
	$crumbs[] = $item['data']['ft_title'];
	$toptitle = cot_breadcrumbs($crumbs, $cfg['homebreadcrumb'], true);
	$toptitle .= ( $usr['isadmin']) ? $R['forums_code_admin_mark'] : '';
	$t->assign(array(
		'FIND_TITLE' => $toptitle,
		'FIND_DESC' => htmlspecialchars($item['data']['ft_desc']),
		'FIND_SHORTTITLE' => htmlspecialchars($item['data']['ft_title']),
		'FIND_TITLE' => htmlspecialchars($item['data']['ft_title']),
		'FIND_DATE' => cot_date('datetime_medium', $item['data']['fp_creation']),
		'FIND_DATE_STAMP' => $item['data']['fp_updated'],
		'FIND_OWNER' => cot_build_user($item['data']['fp_posterid'], htmlspecialchars($item['data']['fp_postername'])),
		'FIND_ODDEVEN' => cot_build_oddeven($jj),
		'FIND_NUM' => $jj
	));
	$text = $item['data']['fp_text'];
	/* === Hook === */
	foreach (cot_getextplugins('find.itemdata.forums.posts') as $pl)
	{
		include $pl;
	}
	/* ===== */
}