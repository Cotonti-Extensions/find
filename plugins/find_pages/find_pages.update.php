<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.update.done
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

if (cot_module_active('find'))
{
	require_once cot_incfile('find', 'module');
	find_build_index('page', (int) $id);
}