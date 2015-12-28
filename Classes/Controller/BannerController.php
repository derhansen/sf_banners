<?php
namespace DERHANSEN\SfBanners\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Banner Controller
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class BannerController extends ActionController
{

    /**
     * Banner Service
     *
     * @var \DERHANSEN\SfBanners\Service\BannerService
     * @inject
     */
    protected $bannerService;

    /**
     * bannerRepository
     *
     * @var \DERHANSEN\SfBanners\Domain\Repository\BannerRepository
     * @inject
     */
    protected $bannerRepository;

    /**
     * Hash Service
     *
     * @var \TYPO3\CMS\Extbase\Security\Cryptography\HashService
     * @inject
     */
    protected $hashService;

    /**
     * The Cache
     *
     * @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
     */
    protected $cacheInstance;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initializeCache();
    }

    /**
     * Initialize cache instance to be ready to use
     *
     * @return void
     */
    protected function initializeCache()
    {
        $cacheManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager');
        $this->cacheInstance = $cacheManager->getCache('sfbanners_cache');
    }

    /**
     * Click Action for a banner
     *
     * @param \DERHANSEN\SfBanners\Domain\Model\Banner $banner
     * @return void
     */
    public function clickAction(\DERHANSEN\SfBanners\Domain\Model\Banner $banner)
    {
        $banner->increaseClicks();
        $this->bannerRepository->update($banner);
        $this->redirectToURI($banner->getLinkUrl());
    }

    /**
     * Show action
     *
     * @return void
     */
    public function showAction()
    {
        $uniqueid = strtolower(substr(base64_encode(sha1(microtime())), 0, 9));
        $stringToHash = $GLOBALS['TSFE']->id . $this->settings['category'] . $this->settings['startingPoint'] .
            $this->settings['displayMode'];
        $hmac = $this->hashService->generateHmac($stringToHash);

        $this->view->assign('pid', $GLOBALS['TSFE']->id);
        $this->view->assign('lang', $GLOBALS['TSFE']->sys_language_uid);
        $this->view->assign('categories', $this->settings['category']);
        $this->view->assign('startingPoint', $this->settings['startingPoint']);
        $this->view->assign('displayMode', $this->settings['displayMode']);
        $this->view->assign('typeNum', $this->settings['ajaxPageTypeNum']);
        $this->view->assign('uniqueid', $uniqueid);
        $this->view->assign('absRefPrefix', $GLOBALS['TSFE']->absRefPrefix);
        $this->view->assign('hmac', $hmac);

        /* Find all banners and add additional CSS */
        $banners = $this->bannerRepository->findAll();
        $cssFile = $this->bannerService->getAdditionalCssFile($banners);

        if ($cssFile != '') {
            $GLOBALS['TSFE']->getPageRenderer()->addCssFile($cssFile, 'stylesheet', 'all', '', true);
        }
    }

    /**
     * Returns banners for the given parameters if given Hmac validation succeeds
     *
     * @param string $categories
     * @param string $startingPoint
     * @param string $displayMode
     * @param int $currentPageUid
     * @param string $hmac
     * @return string
     */
    public function getBannersAction(
        $categories = '',
        $startingPoint = '',
        $displayMode = 'all',
        $currentPageUid = 0,
        $hmac = ''
    ) {
        $compareString = $currentPageUid . $categories . $startingPoint . $displayMode;

        if ($this->hashService->validateHmac($compareString, $hmac)) {
            /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
            $demand = $this->objectManager->get('DERHANSEN\\SfBanners\\Domain\\Model\\BannerDemand');
            $demand->setCategories($categories);
            $demand->setStartingPoint($startingPoint);
            $demand->setDisplayMode($displayMode);
            $demand->setCurrentPageUid($currentPageUid);

            /* Get banners */
            $banners = $this->bannerRepository->findDemanded($demand);

            /* Update Impressions */
            $this->bannerRepository->updateImpressions($banners);

            /* Collect identifier based on uids for all banners */
            $ident = $GLOBALS['TSFE']->id . $GLOBALS['TSFE']->sys_language_uid;
            foreach ($banners as $banner) {
                $ident .= $banner->getUid();
            }

            $ret = $this->cacheInstance->get(sha1($ident));
            if ($ret === false || $ret === null) {
                $this->view->assign('banners', $banners);
                $this->view->assign('settings', $this->settings);
                $ret = $this->view->render();

                // Save value in cache
                $this->cacheInstance->set(sha1($ident), $ret, array('sf_banners'), $this->settings['cacheLifetime']);
            }
        } else {
            $ret = LocalizationUtility::translate('wrong_hmac', 'SfBanners');
        }
        return $ret;
    }

}
