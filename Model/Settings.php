<?php

namespace Fybcode\DfpBundle\Model;

/**
 * @package     FybcodeDfpBundle
 * @author      Francis Bilodeau <fbilodeau@dessinsdrummond.com>
 * @copyright   (c) 2017 Francis Bilodeau
 */

class Settings
{
    protected $publisherId;
    protected $divClass;

    /**
     * @param int $publisherId
     * @param int $divClass
     */
    public function __construct($publisherId, $divClass)
    {
        $this->setPublisherId($publisherId);
        $this->setDivClass($divClass);
    }

    /**
     * Get the publisher id.
     *
     * @return string
     */
    public function getPublisherId()
    {
        return $this->publisherId;
    }

    /**
     * Set the publisher id.
     *
     * @param string publisherId
     */
    public function setPublisherId($publisherId)
    {
        $this->publisherId = $publisherId;
    }

    /**
     * Get the divClass.
     *
     * @return string
     */
    public function getDivClass()
    {
        return $this->divClass;
    }

    /**
     * Set the divClass.
     *
     * @param string divClass
     */
    public function setDivClass($divClass)
    {
        $this->divClass = $divClass;
    }
}
