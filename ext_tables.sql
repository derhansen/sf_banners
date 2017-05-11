#
# Table structure for table 'tx_sfbanners_domain_model_category'
#
CREATE TABLE tx_sfbanners_domain_model_category (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	parent varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	is_dummy_record tinyint(1) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid),
	KEY phpunit_dummy (is_dummy_record)

);

#
# Table structure for table 'tx_sfbanners_domain_model_banner'
#
CREATE TABLE tx_sfbanners_domain_model_banner (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description varchar(255) DEFAULT '' NOT NULL,
	type int(11) DEFAULT '0' NOT NULL,
	category int(11) DEFAULT '0' NOT NULL,
	image text,
	assets int(11) DEFAULT '0' NOT NULL,
	margin_top int(11) DEFAULT '0' NOT NULL,
	margin_right int(11) DEFAULT '0' NOT NULL,
	margin_bottom int(11) DEFAULT '0' NOT NULL,
	margin_left int(11) DEFAULT '0' NOT NULL,
	alttext tinytext,
	link tinytext,
	html text,
	flash text,
	flash_width int(11) DEFAULT '0' NOT NULL,
	flash_height int(11) DEFAULT '0' NOT NULL,
	flash_wmode varchar(255) DEFAULT '' NOT NULL,
	flash_allow_script_access varchar(255) DEFAULT '' NOT NULL,
	impressions_max int(11) DEFAULT '0' NOT NULL,
	clicks_max int(11) DEFAULT '0' NOT NULL,
	impressions int(11) DEFAULT '0' NOT NULL,
	clicks int(11) DEFAULT '0' NOT NULL,
	excludepages int(11) DEFAULT '0' NOT NULL,
	recursive tinyint(4) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	is_dummy_record tinyint(1) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid),
	KEY phpunit_dummy (is_dummy_record)

);

#
# Table structure for table 'tx_sfbanners_domain_model_banner_category_mm'
#
#
CREATE TABLE tx_sfbanners_domain_model_banner_category_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	tablenames varchar(30) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	is_dummy_record tinyint(1) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign),
	KEY phpunit_dummy (is_dummy_record)
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
	KEY uid_foreign (uid_foreign),
	KEY phpunit_dummy (is_dummy_record)
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