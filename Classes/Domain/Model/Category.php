<?php
namespace DERHANSEN\SfBanners\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Category
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class Category extends AbstractEntity
{

    /**
     * Title
     *
     * @var string
     * @validate NotEmpty
     */
    protected $title;

    /**
     * parent
     *
     * @var \DERHANSEN\SfBanners\Domain\Model\Category
     */
    protected $parent;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the parent
     *
     * @return \DERHANSEN\SfBanners\Domain\Model\Category $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets the parent
     *
     * @param \DERHANSEN\SfBanners\Domain\Model\Category $parent
     * @return void
     */
    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }
}
