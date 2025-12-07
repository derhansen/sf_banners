<?php

declare(strict_types=1);

namespace DERHANSEN\SfBanners\Event;

use DERHANSEN\SfBanners\Domain\Model\Banner;

final class AfterBannerClicksIncreasedEvent
{
    public function __construct(
        private Banner $banner
    ) {
    }

    public function getBanner(): Banner
    {
        return $this->banner;
    }
}
