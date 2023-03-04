<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Domain\Model\Dto;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class BannerDemand extends AbstractEntity
{
    protected string $categories = '';
    protected string $startingPoint = '';
    protected string $displayMode = 'all';
    protected int $currentPageUid = 0;
    protected int $maxResults = 0;

    public function getCategories(): string
    {
        return $this->categories;
    }

    public function setCategories(string $categories): void
    {
        $this->categories = $categories;
    }

    public function getStartingPoint(): string
    {
        return $this->startingPoint;
    }

    public function setStartingPoint(string $startingPoint): void
    {
        $this->startingPoint = $startingPoint;
    }

    public function getDisplayMode(): string
    {
        return $this->displayMode;
    }

    public function setDisplayMode(string $displayMode): void
    {
        $this->displayMode = $displayMode;
    }

    public function getCurrentPageUid(): int
    {
        return $this->currentPageUid;
    }

    public function setCurrentPageUid(int $currentPageUid): void
    {
        $this->currentPageUid = $currentPageUid;
    }

    public function getMaxResults(): int
    {
        return $this->maxResults;
    }

    public function setMaxResults(int $maxResults): void
    {
        $this->maxResults = $maxResults;
    }
}
