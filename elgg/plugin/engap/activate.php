<?php
/**
 * Creaet chathistory Table
 *
 */

// register class
	$dbprefix = elgg_get_config('dbprefix');
//var_dump($dbprefix);
	$sql = 'CREATE TABLE IF NOT EXISTS `chathistory` (
			  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `to_guid` int(100) NOT NULL,
			  `from_guid` int(100) NOT NULL,
			  `message` varchar(300) NOT NULL,
			  `date` int(20) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;';
    $data = update_data($sql);
	//system_message("Plugin Activated - enRaiser");