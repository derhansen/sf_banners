<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "sf_banners".
 *
 * Auto generated 03-09-2013 15:50
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Banner-Management',
    'description' => 'Banner-Management Extension based on Extbase and Fluid. Loads banners asynchronously using jQuery.',
    'category' => 'plugin',
    'author' => 'Torben Hansen',
    'author_email' => 'derhansen@gmail.com',
    'state' => 'stable',
    'uploadfolder' => 1,
    'clearCacheOnLoad' => 0,
    'version' => '5.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.99-10.4.99',
            'php' => '7.2.0-7.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
