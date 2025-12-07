<?php

declare(strict_types=1);

namespace DERHANSEN\SfBanners\Event;

use DERHANSEN\SfBanners\Domain\Model\Banner;

final readonly class AfterBannerImpressionsIncreasedEvent
{
    public function __construct(
        private Banner $banner
    ) {}

    public function getBanner(): Banner
    {
        return $this->banner;
    }
}
