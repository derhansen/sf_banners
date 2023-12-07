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
use DERHANSEN\SfBanners\Domain\Model\Dto\BannerDemand;
use DERHANSEN\SfBanners\Domain\Repository\BannerRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\ErrorController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class BannerController extends ActionController
{
    public function __construct(
        private readonly FrontendInterface $cacheInstance,
        private readonly BannerRepository $bannerRepository
    ) {
    }

    /**
     * Click Action for a banner
     */
    public function clickAction(Banner $banner = null): ResponseInterface
    {
        if (is_null($banner)) {
            $response = GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction(
                $this->request,
                'Banner not found.'
            );
            throw new PropagateResponseException($response, 1677953992);
        }
        $banner->increaseClicks();
        $this->bannerRepository->update($banner);

        return $this->responseFactory->createResponse()
            ->withHeader('location', $banner->getLinkUrl());
    }

    /**
     * Show action
     */
    public function showAction(): ResponseInterface
    {
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $uniqueid = strtolower(substr(base64_encode(sha1(microtime())), 0, 9));

        $arguments = [
            'type' => $this->settings['ajaxPageTypeNum'],
            'tx_sfbanners_pi1' => [
                'action' => 'getBanners',
                'controller' => 'Banner',
            ],
        ];

        if ($languageAspect->getId() > 0) {
            $arguments['_language'] = $languageAspect->getId();
        }

        $fetchUrl = (string)$this->request->getAttribute('site')->getRouter()
            ->generateUri((string)$this->request->getAttribute('routing')->getPageId(), $arguments);

        $bannerConfig = [
            'uniqueId' => $uniqueid,
            'currentPageUid' => $this->request->getAttribute('routing')->getPageId(),
            'startingPoint' => $this->settings['startingPoint'] ?? '',
            'categories' => $this->settings['category'] ?? '',
            'displayMode' => $this->settings['displayMode'] ?? '',
            'maxResults' => ($this->settings['maxResults'] ?? '') !== '' ? (int)$this->settings['maxResults'] : 0,
        ];

        $config = $this->hashService->appendHmac(json_encode($bannerConfig, JSON_THROW_ON_ERROR));

        $this->view->assignMultiple([
            'fetchUrl' => $fetchUrl,
            'uniqueId' => $uniqueid,
            'config' => $config,
        ]);

        return $this->htmlResponse();
    }

    /**
     * Returns banners for the given config array as JSON response for usage in frontend
     */
    public function getBannersAction(array $bannerConfigs = []): ResponseInterface
    {
        $result = [];

        foreach ($bannerConfigs as $bannerConfig) {
            try {
                $configString = $this->hashService->validateAndStripHmac($bannerConfig);
                $config = json_decode($configString, true, 512, JSON_THROW_ON_ERROR);
                $result[] = [
                    'uniqueId' => $config['uniqueId'],
                    'html' => $this->getBannersByConfig($config),
                ];
            } catch (\Exception $e) {
                // Silently ignore exceptions
            }
        }

        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('X-Robots-Tag', 'noindex, nofollow');
        $response->getBody()->write(json_encode($result, JSON_THROW_ON_ERROR));

        return $response;
    }

    /**
     * Returns banners by the given configuration array
     */
    protected function getBannersByConfig(array $config): string
    {
        $demand = GeneralUtility::makeInstance(BannerDemand::class);
        $demand->setCategories($config['categories']);
        $demand->setStartingPoint($config['startingPoint']);
        $demand->setDisplayMode($config['displayMode']);
        $demand->setCurrentPageUid($config['currentPageUid']);
        $demand->setMaxResults($config['maxResults']);

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
        $ident = $this->request->getAttribute('routing')->getPageId() . '-' . $languageAspect->getId();
        foreach ($banners as $banner) {
            $ident .= '-' . $banner->getUid();
        }

        $ret = $this->cacheInstance->get(sha1($ident));
        if ($ret === false || $ret === null) {
            $this->view->assign('banners', $banners);
            $this->view->assign('settings', $this->settings);
            $ret = $this->view->render();

            // Save value in cache
            $this->cacheInstance->set(sha1($ident), $ret, ['sf_banners'], $this->settings['cacheLifetime']);
        }

        return $ret;
    }

    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'] ?: null;
    }
}
