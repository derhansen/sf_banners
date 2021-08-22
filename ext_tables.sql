#
# Table structure for table 'tx_sfbanners_domain_model_banner'
#
CREATE TABLE tx_sfbanners_domain_model_banner (
	title varchar(255) DEFAULT '' NOT NULL,
	description varchar(255) DEFAULT '' NOT NULL,
	type int(11) DEFAULT '0' NOT NULL,
	category int(11) DEFAULT '0' NOT NULL,
	assets int(11) DEFAULT '0' NOT NULL,
	html text,
	impressions_max int(11) DEFAULT '0' NOT NULL,
	clicks_max int(11) DEFAULT '0' NOT NULL,
	impressions int(11) DEFAULT '0' NOT NULL,
	clicks int(11) DEFAULT '0' NOT NULL,
	excludepages int(11) DEFAULT '0' NOT NULL,
	recursive tinyint(4) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_sfbanners_domain_model_banner_excludepages_mm'
#
#
CREATE TABLE tx_sfbanners_domain_model_banner_excludepages_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	tablenames varchar(30) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	is_dummy_record tinyint(1) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# TABLE STRUCTURE FOR TABLE 'cf_sfbanners_cache'
#
CREATE TABLE cf_sfbanners_cache (
    id int(11) unsigned NOT NULL auto_increment,
    identifier varchar(250) DEFAULT '' NOT NULL,
    expires int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    content mediumblob,
    lifetime int(11) unsigned DEFAULT '0' NOT NULL,
    PRIMARY KEY (id),
    KEY cache_id (identifier)
) ENGINE=InnoDB;

#
# TABLE STRUCTURE FOR TABLE 'cf_sfbanners_cache_tags'
#
CREATE TABLE cf_sfbanners_cache_tags (
    id int(11) unsigned NOT NULL auto_increment,
    identifier varchar(250) DEFAULT '' NOT NULL,
    tag varchar(250) DEFAULT '' NOT NULL,
    PRIMARY KEY (id),
    KEY cache_id (identifier),
    KEY cache_tag (tag)
) ENGINE=InnoDB;