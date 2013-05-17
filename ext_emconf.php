<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "sf_banners".
 *
 * Auto generated 17-05-2013 15:39
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Banner-Management',
	'description' => 'Banner-Management Extension based on Extbase and Fluid. Loads banners asynchronously by JQuery.',
	'category' => 'plugin',
	'author' => 'Torben Hansen',
	'author_email' => 'derhansen@gmail.com',
	'author_company' => 'Skyfillers GmbH',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.5.3',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3',
			'fluid' => '1.3',
			'typo3' => '4.5.0-6.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:47:{s:12:"ext_icon.gif";s:4:"b1d0";s:17:"ext_localconf.php";s:4:"aaf5";s:14:"ext_tables.php";s:4:"7716";s:14:"ext_tables.sql";s:4:"ada9";s:9:"README.md";s:4:"0ec9";s:39:"Classes/Controller/BannerController.php";s:4:"61bb";s:31:"Classes/Domain/Model/Banner.php";s:4:"50c1";s:37:"Classes/Domain/Model/BannerDemand.php";s:4:"2667";s:33:"Classes/Domain/Model/Category.php";s:4:"384b";s:29:"Classes/Domain/Model/Page.php";s:4:"ccb1";s:46:"Classes/Domain/Repository/BannerRepository.php";s:4:"341a";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"ee2e";s:33:"Classes/Service/BannerService.php";s:4:"168e";s:37:"Classes/Service/HashServiceHelper.php";s:4:"91d3";s:46:"Classes/ViewHelpers/Flash/ParamsViewHelper.php";s:4:"7051";s:50:"Classes/ViewHelpers/Format/UrlencodeViewHelper.php";s:4:"ed32";s:43:"Configuration/Flexforms/Flexform_plugin.xml";s:4:"b1dd";s:28:"Configuration/TCA/Banner.php";s:4:"dac8";s:30:"Configuration/TCA/Category.php";s:4:"5cae";s:38:"Configuration/TypoScript/constants.txt";s:4:"18f9";s:34:"Configuration/TypoScript/setup.txt";s:4:"d1ae";s:40:"Resources/Private/Language/locallang.xml";s:4:"9ab8";s:77:"Resources/Private/Language/locallang_csh_tx_sfbanners_domain_model_banner.xml";s:4:"3970";s:79:"Resources/Private/Language/locallang_csh_tx_sfbanners_domain_model_category.xml";s:4:"c297";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"7e48";s:38:"Resources/Private/Layouts/Banners.html";s:4:"3562";s:38:"Resources/Private/Layouts/Default.html";s:4:"b421";s:50:"Resources/Private/Partials/Banner/FlashBanner.html";s:4:"936f";s:49:"Resources/Private/Partials/Banner/HtmlBanner.html";s:4:"6e4f";s:50:"Resources/Private/Partials/Banner/ImageBanner.html";s:4:"fe9d";s:50:"Resources/Private/Php/class.sf_banners_wizicon.php";s:4:"5a92";s:50:"Resources/Private/Templates/Banner/GetBanners.html";s:4:"8d7f";s:44:"Resources/Private/Templates/Banner/Show.html";s:4:"f653";s:37:"Resources/Public/Icons/ce_wizzard.gif";s:4:"b6f9";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:59:"Resources/Public/Icons/tx_sfbanners_domain_model_banner.gif";s:4:"1b36";s:61:"Resources/Public/Icons/tx_sfbanners_domain_model_category.gif";s:4:"659a";s:33:"Resources/Public/Js/HtmlParser.js";s:4:"56f8";s:33:"Resources/Public/Js/Postscribe.js";s:4:"2585";s:32:"Resources/Public/Js/SfBanners.js";s:4:"df14";s:44:"Tests/Unit/Domain/Model/BannerDemandTest.php";s:4:"8a67";s:38:"Tests/Unit/Domain/Model/BannerTest.php";s:4:"f1ab";s:40:"Tests/Unit/Domain/Model/CategoryTest.php";s:4:"cd36";s:53:"Tests/Unit/Domain/Repository/BannerRepositoryTest.php";s:4:"3332";s:40:"Tests/Unit/Service/BannerServiceTest.php";s:4:"3ddc";s:53:"Tests/Unit/ViewHelpers/Flash/ParamsViewHelperTest.php";s:4:"781f";s:14:"doc/manual.sxw";s:4:"b1c0";}',
);

?>