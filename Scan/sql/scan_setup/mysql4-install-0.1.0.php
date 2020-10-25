<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('scan')};
CREATE TABLE {$this->getTable('scan')} (
  `scan_id` int(11) unsigned NOT NULL auto_increment,
  `hospital` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `city` varchar(100) NOT NULL default '',
  `scan_type` varchar(150) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `map_url` text NOT NULL,
  `usp` text NOT NULL,
  `mrp` int(11) NOT NULL default '0',
  `price` int(11) NOT NULL default '0',
  `doctors` text NOT NULL,
  `description` text NOT NULL,
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`scan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- DROP TABLE IF EXISTS {$this->getTable('scancrm')};
CREATE TABLE {$this->getTable('scancrm')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `bmsbooking_code` varchar(100) NOT NULL default '',
  'scansub_type' varchar(255) NOT NULL default '',
  `name` varchar(150) NOT NULL default '',
  `phone` varchar(20) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `location` varchar(100) NOT NULL default '',
  `scan_type` varchar(255) NOT NULL default '',
  `hospital` varchar(255) NOT NULL default '',
  `price` int(11) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `leadowner` varchar(50) NOT NULL default '',
  `feedback` varchar(255) NOT NULL default '',
  `source_from` varchar(100) NOT NULL default '',
  `attend_time` time NULL,
  `postpone_date` datetime NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


    ");

    

$installer->endSetup(); 