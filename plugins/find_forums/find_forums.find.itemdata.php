<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.itemdata
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

if ($item['node_reftype'] == 'forums.topics') {
	$item['data']['ft_icon'] = 'posts';
	$item['data']['ft_postisnew'] = FALSE;
	$item['data']['ft_pages'] = '';
	$item['data']['ft_title'] = ($item['data']['ft_mode'] == 1) ? "# ".$item['data']['ft_title'] : $item['data']['ft_title'];
	if ($item['data']['ft_movedto'] > 0) {
		$item['data']['ft_url'] = cot_url('forums', "m=posts&q=".$item['data']['ft_movedto']);
		$item['data']['ft_icon'] = $R['forums_icon_posts_moved'];
		$item['data']['ft_title']= $L['Moved'].": ".$item['data']['ft_title'];
		$item['data']['ft_postcount'] = $R['forums_code_post_empty'];
		$item['data']['ft_replycount'] = $R['forums_code_post_empty'];
		$item['data']['ft_viewcount'] = $R['forums_code_post_empty'];
		$item['data']['ft_lastpostername'] = $R['forums_code_post_empty'];
		$item['data']['ft_lastposturl'] = cot_url('forums', "m=posts&q=".$item['data']['ft_movedto']."&n=last", "#bottom");
		$item['data']['ft_lastpostlink'] = cot_rc_link($item['data']['ft_lastposturl'], $R['icon_follow'], 'rel="nofollow"') .$L['Moved'];
	} else {
		$item['data']['ft_url'] = cot_url('forums', "m=posts&q=".$item['data']['ft_id']);
		$item['data']['ft_lastposturl'] = ($usr['id'] > 0 && $item['data']['ft_updated'] > $usr['lastvisit']) ? cot_url('forums', "m=posts&q=".$item['data']['ft_id']."&n=unread", "#unread") : cot_url('forums', "m=posts&q=".$item['data']['ft_id']."&n=last", "#bottom");
		$item['data']['ft_lastpostlink'] = cot_rc_link($item['data']['ft_lastposturl'], $R['icon_unread'], 'rel="nofollow"').cot_date('datetime_short', $item['data']['ft_updated']);
		$item['data']['ft_replycount'] = $item['data']['ft_postcount'] - 1;
		if ($item['data']['ft_updated'] > $usr['lastvisit'] && $usr['id'] > 0) {
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
	if (!empty($item['data']['ft_user_posted'])) {
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
        // Todo FIND_USER_POSTED is not used and  $item['data']['ft_user_posted'] is not set
		'FIND_USER_POSTED' => isset($item['data']['ft_user_posted']) ? (int) $item['data']['ft_user_posted'] : 0,
		'FIND_URL' => $item['data']['ft_url'],
		'FIND_PREVIEW' => $item['data']['ft_preview'].'...',
		'FIND_PAGES' => $item['data']['ft_pages'],
		'FIND_MAXPAGES' => isset($item['data']['ft_maxpages']) ? $item['data']['ft_maxpages'] : '',
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
if ($item['node_reftype'] == 'forums.posts') {
    if (!isset($s) || isset(cot::$cfg['forums']['cat_' . $s]) || !cot::$cfg['forums']['cat_' . $s]['allowusertext']) {
        $item['data']['user_text'] = '';
    }
    $rowedit_url = '';
    $rowedit = '';
    $rowdelete_url = '';
    $rowdelete = '';
    if (
        cot::$usr['id'] > 0
        && (
            cot::$usr['isadmin']
            || (
                $item['data']['fp_posterid'] == cot::$usr['id']
                && (
                    cot::$cfg['forums']['edittimeout'] == '0' ||
                    cot::$sys['now'] - $item['data']['fp_creation'] < cot::$cfg['forums']['edittimeout'] * 3600
                )
            )
        )
    ) {
        $params = ['m' => 'editpost'];
        if (isset($s)) {
            $params['s'] = $s;
        }
        if (isset($q)) {
            $params['q'] = $q;
        }
        $params['p'] = $item['data']['fp_id'];
        if (isset($durl)) {
            $params['d'] = $durl;
        }
        $params['x'] = cot::$sys['xk'];
        $rowedit_url = cot_url('forums', $params);
        $rowedit = cot_rc('forums_rowedit', array('url' => $rowedit_url));

        if (isset($fp_num) && $fp_num > 1) {
            $params = array_merge(['m' => 'posts', 'a' => 'delete'], $params);

            $rowdelete_url = cot_confirm_url(
                cot_url('forums', $params ),
                'forums',
                'forums_confirm_delete_post'
            );
            $rowdelete = cot_rc('forums_rowdelete', array('url' => $rowdelete_url));
        }
    }

	if (!empty($item['data']['fp_updater'])) {
		$item['data']['fp_updatedby'] = sprintf($L['forums_updatedby'], htmlspecialchars($item['data']['fp_updater']), cot_date('datetime_medium', $item['data']['fp_updated']), cot_build_timegap($item['data']['fp_updated'], $sys['now']));
	}
	$t->assign(cot_generate_usertags($item['data'], 'FIND_USER'));

    $enableMarkUp = cot::$cfg['forums']['markup'] &&
        isset($cfg['forums']['cat_' . $item['data']['fp_cat']]) &&
        $cfg['forums']['cat_' . $item['data']['fp_cat']]['allowbbcodes'];

	$t->assign(array(
		'FIND_ID' => $item['data']['fp_id'],
		'FIND_POSTID' => 'post_'.$item['data']['fp_id'],
		'FIND_IDURL' => cot_url('forums', 'm=posts&id='.$item['data']['fp_id']),
		'FIND_URL' => cot_url('forums', 'm=posts&q='.$item['data']['fp_topicid'], '#'.$item['data']['fp_id']),
		'FIND_CREATION' => !empty($item['data']['fp_creation']) ?
            cot_date('datetime_medium', $item['data']['fp_creation']) : '',
		'FIND_CREATION_STAMP' => !empty($item['data']['fp_creation']) ? $item['data']['fp_creation'] : 0,
		'FIND_UPDATED' => cot_date('datetime_medium', $item['data']['fp_updated']),
		'FIND_UPDATED_STAMP' => !empty($item['data']['fp_updated']) ? $item['data']['fp_updated'] : 0,
		'FIND_UPDATER' => htmlspecialchars($item['data']['fp_updater']),
		'FIND_UPDATEDBY' => isset($item['data']['fp_updatedby']) ? $item['data']['fp_updatedby'] : '',
		'FIND_TEXT' => cot_parse($item['data']['fp_text'], $enableMarkUp),
		'FIND_ANCHORLINK' => cot_rc('forums_code_post_anchor', array('id' => $item['data']['fp_id'])),
		'FIND_POSTERNAME' => !empty($item['data']['user_id']) && !empty($item['data']['user_name']) ?
            cot_build_user($item['data']['user_id'], $item['data']['user_name'])
            : Cot::$L['Deleted'],
		'FIND_POSTERID' => !empty($item['data']['user_id']) ? $item['data']['user_id'] : 0,
		'FIND_POSTERIP' => (Cot::$usr['isadmin'] && !empty($item['data']['fp_posterip'])) ?
            cot_build_ipsearch($item['data']['fp_posterip']) : '',
		'FIND_DELETE' => $rowdelete,
		'FIND_DELETE_URL' => $rowdelete_url,
		'FIND_EDIT' => $rowedit,
		'FIND_EDIT_URL' => $rowedit_url,
	));

	foreach (Cot::$extrafields[Cot::$db->forum_posts] as $exfld) {
		$tag = mb_strtoupper($exfld['field_name']);
		$t->assign(array(
			'FIND_'.$tag.'_TITLE' => isset(cot::$L['forums_posts_'.$exfld['field_name'].'_title']) ?
                cot::$L['forums_posts_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
			'FIND_'.$tag => cot_build_extrafields_data(
                'forums',
                $exfld,
                $item['data']['fp_'.$exfld['field_name']],
                $enableMarkUp
            ),
			'FIND_'.$tag.'_VALUE' => $item['data']['fp_'.$exfld['field_name']]
		));
	}

	$crumbs = !empty($item['data']['fp_cat']) ? cot_forums_buildpath($item['data']['fp_cat']) : [];
    if (!empty($item['data']['ft_title'])) {
        $crumbs[] = $item['data']['ft_title'];
        $item['data']['ft_title'] = (($item['data']['ft_mode'] == 1) ? '# ' : '') . $item['data']['ft_title'];
    }
	$breadcrumbs = cot_breadcrumbs($crumbs, Cot::$cfg['homebreadcrumb'], true);
    $breadcrumbs .= Cot::$usr['isadmin'] ? Cot::$R['forums_code_admin_mark'] : '';

    $owner = !empty($item['data']['user_id']) && !empty($item['data']['user_name']) ?
        cot_build_user($item['data']['user_id'], $item['data']['user_name']) : Cot::$L['Deleted'];

	$t->assign(array(
		'FIND_BREADCRUMBS' => $breadcrumbs,
		'FIND_DESC' => !empty($item['data']['ft_desc']) ? htmlspecialchars($item['data']['ft_desc']) : '',
		'FIND_SHORTTITLE' => htmlspecialchars($item['data']['ft_title']),
		'FIND_TITLE' => htmlspecialchars($item['data']['ft_title']),
		'FIND_DATE' => !empty($item['data']['fp_creation']) ?
            cot_date('datetime_medium', $item['data']['fp_creation']) : '',
		'FIND_DATE_STAMP' => !empty($item['data']['fp_updated']) ? $item['data']['fp_updated'] : 0,
		'FIND_OWNER' => $owner,
		'FIND_ODDEVEN' => cot_build_oddeven($jj),
		'FIND_NUM' => $jj
	));
	$text = !empty($item['data']['fp_text']) ? $item['data']['fp_text'] : '';

	/* === Hook === */
	foreach (cot_getextplugins('find.itemdata.forums.posts') as $pl) {
		include $pl;
	}
	/* ===== */
}