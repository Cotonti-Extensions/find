<?php
defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Info
 */

$L['Search'] = 'Search';
$L['Find'] = &$L['Search'];
$L['info_desc'] = 'Indexed search';

/**
 * Plugin Config
 */

$L['cfg_results_per_page'] = 'Maximum results per page';
$L['cfg_min_words_per_page'] = 'Minimum word count for page to be indexed';
$L['cfg_min_word_length'] = 'Minimum word length for it to be indexed';
$L['cfg_extract_count'] = 'Maximum number of pieces in extract';
$L['cfg_extract_length'] = 'Maximum length of each piece of extract';
$L['cfg_cache_ttl'] = 'Keep results in cache for * seconds';
$L['cfg_blacklist'] = 'Enable common word blacklist to reduce DB size';

/**
 * Plugin Title & Subtitle
 */

$L['plu_title'] = $L['Find'];

/**
 * Plugin Admin
 */

$Ls['results'] = array('results', 'result');

/**
 * Plugin Body
 */

$L['find_adm_counts'] = 'Counts';
$L['find_top5'] = 'Top 5 words';

$L['find_all'] = 'All';
$L['find_results'] = 'Showing {$onpage} of {$total} {$results}.';

$L['indexer_title'] = 'Indexer';
$L['indexer_complete'] = 'Indexing Complete';
$L['indexer_executed'] = 'Executed {$queries} queries in {$time}.';

$L['indexer_reindex_all'] = 'Re-index all nodes';
$L['indexer_reindex_all_note'] = 'may take a few minutes';

$L['indexer_statistics'] = 'Statistics';
$L['indexer_nodes'] = 'nodes';
$L['indexer_words'] = 'words';
$L['indexer_occurrences'] = 'occurrences';

$L['find_title'] = 'Search the site';
$L['find_title_result'] = 'Search result "'.htmlspecialchars($q).'"';
$L['find_in'] = 'Search in ...';
$L['find_hint'] = 'Hint: you can use the + and - modifiers to make your search more precise. Use double quotes to find exact phrases.';
$L['find_no_resultst'] = 'No results. Try something else.';

$charblacklist = str_split("`~!@#$%^&*()-_+=<>?/,.|\[]{}:;\"'");
$L['find_blacklist'] = "a as able about above according accordingly across actually after afterwards again against ain't ago all allow allows almost alone along already also alt although always am among amongst amp an and another any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are aren't around as aside ask asking associated at available away awfully be became because become becomes becoming been before beforehand behind being believe below beside besides best better between beyond both brief but by c'mon came can can't cannot cant cause causes certain certainly changes clearly co com come comes concerning consequently consider considering contain containing contains corresponding could couldn't course currently definitely described despite did didn't different do does doesn't doing don't done down downwards during each edu eg eight either else elsewhere enough entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example except far few fifth first five followed following follows for former formerly forth four from further furthermore get gets getting given gives go goes going gone got gotten greetings had hadn't happens hardly has hasn't have haven't having he he's hello help hence her here here's hereafter hereby herein hereupon hers herself hi him himself his hither hopefully how howbeit however href http i'd i'll i'm i've ie if ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into inward is isn't it it'd it'll it's its itself just keep keeps kept know knows known last lately later latter latterly least less lest let let's like liked likely little look looking looks ltd mainly many may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd near nearly necessary need needs neither never nevertheless new news next nine no nobody non none noone nor normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only onto or other others otherwise ought our ours ourselves out outside over overall own page particular particularly per perhaps php placed please plus possible presumably probably provides que quit quite qv rather rd re really reasonably regarding regardless regards relatively respectively right said same saw say saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent serious seriously seven several shall she should shouldn't since six small so some somebody somehow someone something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such sup sure take taken tell tends th than thank thanks thanx that that's thats the their theirs them themselves then thence there there's thereafter thereby therefore therein theres thereupon these they they'd they'll they're they've think third this thorough thoroughly those though three through throughout thru thus time times to together too took toward towards tried tries true truly try trying twice two un under unfortunately unless unlikely until unto up upon us use user users used useful uses using usually value various very via viz vs want wants was wasn't way we we'd we'll we're we've welcome well went were weren't what what's whatever when whence whenever where where's whereafter whereas whereby wherein whereupon wherever whether which while whither who who's whoever whole whom whose why wide will willing wish with within without won't wonder would would wouldn't yes yet you you'd you'll you're you've your yours yourself yourselves zero";