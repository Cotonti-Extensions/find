CREATE TABLE IF NOT EXISTS `cot_indexer_nodes` (
  `node_id` INT NOT NULL auto_increment,
  `node_reftype` VARCHAR(20) NOT NULL,
  `node_refid` INT NOT NULL,
  `node_indexed` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`node_id`),
  UNIQUE KEY `reference` (`node_reftype`, `node_refid`)
);

CREATE TABLE IF NOT EXISTS `cot_indexer_words` (
  `word_id` INT NOT NULL auto_increment,
  `word_value` VARCHAR(50) NOT NULL,
  PRIMARY KEY  (`word_id`),
  UNIQUE KEY (`word_value`)
);

CREATE TABLE IF NOT EXISTS `cot_indexer_occurrences` (
  `node_id` INT NOT NULL,
  `word_id` INT NOT NULL,
  `location` VARCHAR(20) NOT NULL,
  `occurrences` SMALLINT NOT NULL,
  UNIQUE KEY `match` (`node_id`, `word_id`, `location`),
  KEY (`node_id`),
  KEY (`word_id`),
  KEY (`location`)
);