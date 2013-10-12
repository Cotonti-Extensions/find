<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=find.sources
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('find_comment', 'plug');

find_register_source(
	'comment',
	array(
		'page',
		array(
			'c={page_cat}&al={page_alias}#c={com_id}',
			'c={page_cat}&id={page_id}#c={com_id}'
		)
	),
	"{$db_x}com",
	array('com_text'),
	'com_id',
	$db_x.'pages.page_title ON '.$db_x.'pages.page_id = '.$db_x.'com.com_code AND '.$db_x.'com.com_area = "page"',
	'com_date'
);