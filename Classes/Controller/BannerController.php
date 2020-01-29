<?php
namespace DERHANSEN\SfBanners\Controller;

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use DERHANSEN\SfBanners\Domain\Model\BannerDemand;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\ImmediateResponseException;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\Controller\ErrorController;

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
     */
    protected $bannerService;

    /**
     * bannerRepository
     *
     * @var \DERHANSEN\SfBanners\Domain\Repository\BannerRepository
     */
    protected $bannerRepository;

    /**
     * Hash Service
     *
     * @var \TYPO3\CMS\Extbase\Security\Cryptography\HashService
     */
    protected $hashService;

    /**
     * The Cache
     *
     * @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
     */
    protected $cacheInstance;

    /**
     * Initialize cache
     */
    public function initializeAction()
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
        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);
        $this->cacheInstance = $cacheManager->getCache('sfbanners_cache');
    }

    /**
     * @param \DERHANSEN\SfBanners\Domain\Repository\BannerRepository $bannerRepository
     */
    public function injectBannerRepository(\DERHANSEN\SfBanners\Domain\Repository\BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * @param \DERHANSEN\SfBanners\Service\BannerService $bannerService
     */
    public function injectBannerService(\DERHANSEN\SfBanners\Service\BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Security\Cryptography\HashService $hashService
     */
    public function injectHashService(\TYPO3\CMS\Extbase\Security\Cryptography\HashService $hashService)
    {
        $this->hashService = $hashService;
    }

    /**
     * Click Action for a banner
     *
     * @param \DERHANSEN\SfBanners\Domain\Model\Banner $banner
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function clickAction(\DERHANSEN\SfBanners\Domain\Model\Banner $banner = null)
    {
        if (is_null($banner)) {
            $response = GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction(
                $GLOBALS['TYPO3_REQUEST'],
                'Banner not found.'
            );
            throw new ImmediateResponseException($response, 1549896549734);
        }
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
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $maxResults = $this->settings['maxResults'] !== '' ? (int)$this->settings['maxResults'] : 0;
        $uniqueid = strtolower(substr(base64_encode(sha1(microtime())), 0, 9));
        $stringToHash = $GLOBALS['TSFE']->id . $this->settings['category'] . $this->settings['startingPoint'] .
            $this->settings['displayMode'] . $maxResults;
        $hmac = $this->hashService->generateHmac($stringToHash);

        $arguments = [
            'L' => $languageAspect->getId(),
            'type' => $this->settings['ajaxPageTypeNum'],
            'tx_sfbanners_pi1[action]' => 'getBanners',
            'tx_sfbanners_pi1[controller]' => 'Banner',
            'tx_sfbanners_pi1[currentPageUid]' => $GLOBALS['TSFE']->id,
            'tx_sfbanners_pi1[hmac]' => $hmac,
        ];

        if ($this->settings['startingPoint'] !== '') {
            $arguments['tx_sfbanners_pi1[startingPoint]'] = $this->settings['startingPoint'];
        }
        if ($this->settings['category'] !== '') {
            $arguments['tx_sfbanners_pi1[categories]'] = $this->settings['category'];
        }
        if ($this->settings['displayMode'] !== '') {
            $arguments['tx_sfbanners_pi1[displayMode]'] = $this->settings['displayMode'];
        }
        if ($this->settings['maxResults'] !== '' &&
            MathUtility::canBeInterpretedAsInteger($this->settings['maxResults'])
        ) {
            $arguments['tx_sfbanners_pi1[maxResults]'] = (int)$this->settings['maxResults'];
        }

        $url = $this->controllerContext
            ->getUriBuilder()
            ->reset()
            ->setUseCacheHash(true)
            ->setTargetPageUid($GLOBALS['TSFE']->id)
            ->setArguments($arguments)
            ->buildFrontendUri();

        $this->view->assign('url', $url);
        $this->view->assign('uniqueid', $uniqueid);

        /* Find all banners and add additional CSS */
        $banners = $this->bannerRepository->findAll();
        $cssFile = $this->bannerService->getAdditionalCssFile($banners);

        if ($cssFile != '') {
            /** @var PageRenderer $pageRenderer */
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->addCssFile($cssFile, 'stylesheet', 'all', '', true);
        }
    }

    /**
     * Returns banners for the given parameters if given Hmac validation succeeds
     *
     * @param string $categories
     * @param string $startingPoint
     * @param string $displayMode
     * @param int $currentPageUid
     * @param int $maxResults
     * @param string $hmac
     * @return string
     */
    public function getBannersAction(
        $categories = '',
        $startingPoint = '',
        $displayMode = 'all',
        $currentPageUid = 0,
        $maxResults = 0,
        $hmac = ''
    ) {
        $compareString = $currentPageUid . $categories . $startingPoint . $displayMode . $maxResults;

        if ($this->hashService->validateHmac($compareString, $hmac)) {
            /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
            $demand = $this->objectManager->get(BannerDemand::class);
            $demand->setCategories($categories);
            $demand->setStartingPoint($startingPoint);
            $demand->setDisplayMode($displayMode);
            $demand->setCurrentPageUid($currentPageUid);
            $demand->setMaxResults($maxResults);

            /* Get banners */
            $banners = $this->bannerRepository->findDemanded($demand);

            /* If no banners available, return empty string */
            if (count($banners) === 0) {
                return '';
            }

            /* Update Impressions */
            $this->bannerRepository->updateImpressions($banners);

            /* Collect identifier based on uids for all banners */
            $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
            $ident = $GLOBALS['TSFE']->id . $languageAspect->getId();
            foreach ($banners as $banner) {
                $ident .= $banner->getUid();
            }

            $ret = $this->cacheInstance->get(sha1($ident));
            if ($ret === false || $ret === null) {
                $this->view->assign('banners', $banners);
                $this->view->assign('settings', $this->settings);
                $ret = $this->view->render();

                // Save value in cache
                $this->cacheInstance->set(sha1($ident), $ret, ['sf_banners'], $this->settings['cacheLifetime']);
            }
        } else {
            $ret = LocalizationUtility::translate('wrong_hmac', 'SfBanners');
        }
        return $ret;
    }
}
