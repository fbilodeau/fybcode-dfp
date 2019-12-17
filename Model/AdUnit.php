<?php

namespace Fybcode\DfpBundle\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package     FybcodeDfpBundle
 * @author      Francis Bilodeau <fbilodeau@dessinsdrummond.com>
 * @copyright   (c) 2017 Francis Bilodeau
 */

class AdUnit
{
    protected $em;
    protected $path;
    protected $sizes;
    protected $divId;
    protected $request;
    protected $userId;
    protected $madopsPreset;
    protected $dfpAdUnitPath;
    protected $m32id;

    /**
     * @param string $path
     * @param string $divId
     * @param array|null $sizes
     * @param Request $request
     */
    public function __construct($path, $divId, $sizes=null, Request $request, $userId, $madopsPreset, $dfpAdUnitPath, $m32id)
    {
        // En cas de roll back sur la version de M32, retourner à une vesion précédente au 11 Décembre 2019 sur Git.
        $this->setPath($path);
        $this->setDivId($divId);
        $this->sizes = $sizes;
        $this->request = $request;
        $this->userId = $userId;
        $this->setMadopsPreset($madopsPreset);
        $this->setDfpAdUnitPath($dfpAdUnitPath);
        $this->setM32id($m32id);
    }

    /**
     * Output the DFP code for this ad unit
     *
     * @param Fybcode\DfpBundle\Model\Settings $settings
     * @return string
     */
    public function output(Settings $settings)
    {

        //if ($this->request->getClientIp() != '173.237.240.50') {

            $class = $settings->getDivClass();
            $output = ($this->madopsPreset !== null)
                        ? <<< RETURN
    <div data-m32-ad data-options='{"madopsPreset":"{$this->madopsPreset}","dfpId":"{$this->m32id}","dfpAdUnitPath":"{$this->dfpAdUnitPath}"}'></div>
RETURN
                        : <<< RETURN
    <div data-m32-ad data-options='{"sizes":"{$this->sizes}","dfpId":"{$this->m32id}","dfpAdUnitPath":"{$this->dfpAdUnitPath}"}'></div>
RETURN;

        //}

        return $output;
    }
    
    /**
     * Validate the name of the browser, used to not show ads for robots.
     */
    protected function get_browser_name($user_agent) {
        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
        elseif (strpos($user_agent, 'Edge')) return 'Edge';
        elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
        elseif (strpos($user_agent, 'Safari')) return 'Safari';
        elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
        elseif (strpos($user_agent, 'Android')) return 'Android';
        elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';

        return 'Other';
    }

    /**
     * Get the path.
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get the path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the sizes.
     *
     * @throws Fybcode\DfpBundle\Model\AdSizeException
     * @param array $sizes
     */
    public function setSizes($sizes)
    {
        $this->sizes = $sizes;
    }

    /**
     * Get the sizes.
     *
     * @return array
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * Get the divId.
     *
     * @param string $divId
     */
    public function setDivId($divId)
    {
        $this->divId = $divId;
    }

    /**
     * Get the divId.
     *
     * @return string
     */
    public function getDivId()
    {
        return $this->divId;
    }

    /**
     * Get the madopsPreset.
     *
     * @param string $madopsPreset
     */
    public function setMadopsPreset($madopsPreset)
    {
        $this->madopsPreset = $madopsPreset;
    }

    /**
     * Get the madopsPreset.
     *
     * @return string
     */
    public function getMadopsPreset()
    {
        return $this->madopsPreset;
    }

    /**
     * Get the dfpAdUnitPath.
     *
     * @param string $dfpAdUnitPath
     */
    public function setDfpAdUnitPath($dfpAdUnitPath)
    {
        $this->dfpAdUnitPath = $dfpAdUnitPath;
    }

    /**
     * Get the dfpAdUnitPath.
     *
     * @return string
     */
    public function getDfpAdUnitPath()
    {
        return $this->dfpAdUnitPath;
    }

    /**
     * Get the m32id.
     *
     * @param string $m32id
     */
    public function setM32id($m32id)
    {
        $this->m32id = $m32id;
    }

    /**
     * Get the m32id.
     *
     * @return string
     */
    public function getM32id()
    {
        return $this->m32id;
    }

}
