<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Controller;

use DERHANSEN\SfBanners\Domain\Model\Banner;
use DERHANSEN\SfBanners\Domain\Model\BannerDemand;
use DERHANSEN\SfBanners\Domain\Repository\BannerRepository;
use DERHANSEN\SfBanners\Service\BannerService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\ImmediateResponseException;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\Controller\ErrorController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Banner Controller
 */
class BannerController extends ActionController
{
    protected BannerService $bannerService;
    protected BannerRepository $bannerRepository;

    /**
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
     */
    protected function initializeCache()
    {
        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);
        $this->cacheInstance = $cacheManager->getCache('sfbanners_cache');
    }

    public function injectBannerRepository(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function injectBannerService(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    /**
     * Click Action for a banner
     *
     * @param Banner|null $banner
     * @return ResponseInterface
     * @throws ImmediateResponseException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function clickAction(Banner $banner = null): ResponseInterface
    {
        if (is_null($banner)) {
            return GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction(
                $this->request,
                'Banner not found.'
            );
        }
        $banner->increaseClicks();
        $this->bannerRepository->update($banner);

        return $this->responseFactory->createResponse()
            ->withHeader('location', $banner->getLinkUrl());
    }

    /**
     * Show action
     *
     * @return ResponseInterface
     */
    public function showAction(): ResponseInterface
    {
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $maxResults = $this->settings['maxResults'] !== '' ? (int)$this->settings['maxResults'] : 0;
        $uniqueid = strtolower(substr(base64_encode(sha1(microtime())), 0, 9));
        $stringToHash = $this->getTypoScriptFrontendController()->id . $this->settings['category'] .
            $this->settings['startingPoint'] . $this->settings['displayMode'] . $maxResults;
        $hmac = $this->hashService->generateHmac($stringToHash);

        $arguments = [
            'type' => $this->settings['ajaxPageTypeNum'],
            'tx_sfbanners_pi1' => [
                'action' => 'getBanners',
                'controller' => 'Banner',
                'currentPageUid' => $this->getTypoScriptFrontendController()->id,
                'hmac' => $hmac,
            ],
        ];

        if ($languageAspect->getId() > 0) {
            $arguments['_language'] = $languageAspect;
        }

        if ($this->settings['startingPoint'] !== '') {
            $arguments['tx_sfbanners_pi1']['startingPoint'] = $this->settings['startingPoint'];
        }
        if ($this->settings['category'] !== '') {
            $arguments['tx_sfbanners_pi1']['categories'] = $this->settings['category'];
        }
        if ($this->settings['displayMode'] !== '') {
            $arguments['tx_sfbanners_pi1']['displayMode'] = $this->settings['displayMode'];
        }
        if ($this->settings['maxResults'] !== '' &&
            MathUtility::canBeInterpretedAsInteger($this->settings['maxResults'])
        ) {
            $arguments['tx_sfbanners_pi1']['maxResults'] = (int)$this->settings['maxResults'];
        }

        $url = (string)$this->request->getAttribute('site')->getRouter()
            ->generateUri((string)$this->getTypoScriptFrontendController()->id, $arguments);

        $this->view->assign('url', $url);
        $this->view->assign('uniqueid', $uniqueid);

        /* Find all banners and add additional CSS */
        $banners = $this->bannerRepository->findAll();
        $cssFile = $this->bannerService->getAdditionalCssFile($banners);

        if ($cssFile !== '') {
            /** @var PageRenderer $pageRenderer */
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->addCssFile($cssFile, 'stylesheet', 'all', '', true);
        }

        return $this->htmlResponse();
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
     * @return ResponseInterface
     */
    public function getBannersAction(
        string $categories = '',
        string $startingPoint = '',
        string $displayMode = 'all',
        int $currentPageUid = 0,
        int $maxResults = 0,
        string $hmac = ''
    ): ResponseInterface {
        $compareString = $currentPageUid . $categories . $startingPoint . $displayMode . $maxResults;

        if ($this->hashService->validateHmac($compareString, $hmac)) {
            /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
            $demand = GeneralUtility::makeInstance(BannerDemand::class);
            $demand->setCategories($categories);
            $demand->setStartingPoint($startingPoint);
            $demand->setDisplayMode($displayMode);
            $demand->setCurrentPageUid($currentPageUid);
            $demand->setMaxResults($maxResults);

            /* Get banners */
            $banners = $this->bannerRepository->findDemanded($demand);

            /* If no banners available, return empty string */
            if (count($banners) === 0) {
                return $this->htmlResponse('');
            }

            /* Update Impressions */
            $this->bannerRepository->updateImpressions($banners);

            /* Collect identifier based on uids for all banners */
            $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
            $ident = $this->getTypoScriptFrontendController()->id . $languageAspect->getId();
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

        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withHeader('X-Robots-Tag', 'noindex, nofollow');
        $response->getBody()->write($ret);

        return $response;
    }

    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'] ?: null;
    }
}
