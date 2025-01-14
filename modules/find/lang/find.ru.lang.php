<?php
defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Info
 */

$L['Search'] = 'Поиск';
$L['Find'] = &$L['Search'];
$L['info_desc'] = 'Индексированный поиск';

/**
 * Plugin Config
 */

$L['cfg_results_per_page'] = 'Максимум результатов на страницу';
$L['cfg_min_words_per_page'] = 'Минимальное количество слов для страницы, которая будет индексироваться';
$L['cfg_min_word_length'] = 'Минимальная длина слова для того, чтобы быть проиндексированным';
$L['cfg_extract_count'] = 'Максимальное количество штук в выборке';
$L['cfg_extract_length'] = 'Максимальная длина каждой части выборки';
$L['cfg_cache_ttl'] = 'Время жизни кэша * секунд';
$L['cfg_blacklist'] = 'Включить общий черный список слов для уменьшения размера БД';

/**
 * Plugin Title & Subtitle
 */

$L['plu_title'] = $L['Find'];

/**
 * Plugin Admin
 */

$Ls['results'] = array('элемента','элементов','элементов');

/**
 * Plugin Body
 */

$L['find_adm_counts'] = 'Счетчики';
$L['find_top5'] = 'ТОП 5 слов';

$L['find_all'] = 'Все';
$L['find_results'] = 'Показано {$onpage} из {$total} {$results}.';

$L['indexer_title'] = 'Индексатор';
$L['indexer_complete'] = 'Индексация завершена';
$L['indexer_executed'] = 'Сделано {$queries} запросов за {$time}.';

$L['indexer_reindex_all'] = 'Переиндексировать все ноды';
$L['indexer_reindex_all_note'] = 'Может занять некоторое время';

$L['indexer_statistics'] = 'Статистика';
$L['indexer_nodes'] = 'ноды';
$L['indexer_words'] = 'слова';
$L['indexer_occurrences'] = 'выражения';

$L['find_title'] = 'Поиск на сайте';
$L['find_title_result'] = 'Результат поиска «{$query}»';
$L['find_in'] = 'Искать в ...';
$L['find_hint'] = 'Подсказка: вы можете использовать + и - модификаторы, чтобы сделать Ваш поиск более точным. Используйте двойные кавычки, чтобы найти точные фразы.';
$L['find_no_resultst'] = 'Нет результатов. Попробуйте что-то еще.';

$charblacklist = str_split("`~!@#$%^&*()-_+=<>?/,.|\[]{}:;\"'");
$L['find_blacklist'] = " и в во не что он на я с со как а то все она так его но да ты к у же вы за бы по только ее мне было вот от меня еще нет о из ему теперь когда даже ну вдруг ли если уже или ни быть был него до вас нибудь опять уж вам сказал ведь там потом себя ничего ей может они тут где есть надо ней для мы тебя их чем была сам чтоб без будто человек чего раз тоже себе под жизнь будет ж тогда кто этот говорил того потому этого какой совсем ним здесь этом один почти мой тем чтобы нее кажется сейчас были куда зачем сказать всех никогда сегодня можно при наконец два об другой хоть после над больше тот через эти нас про всего них какая много разве сказала три эту моя впрочем хорошо свою этой перед иногда лучше чуть том нельзя такой им более всегда конечно всю между";