<?php

namespace Fybcode\DfpBundle\Model;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @param string $path
     * @param string $divId
     * @param array|null $sizes
     * @param Request $request
     */
    public function __construct($path, $divId, $sizes=null, Request $request)
    {
        $this->setPath($path);
        $this->setDivId($divId);
        $this->setSizes($sizes);
        $this->request = $request;
    }

    /**
     * Output the DFP code for this ad unit
     *
     * @param Fybcode\DfpBundle\Model\Settings $settings
     * @return string
     */
    public function output(Settings $settings)
    {
        $class  = $settings->getDivClass();
        $output = <<< RETURN
<div id="{$this->divId}" class="{$class}">
<script type="text/javascript">
googletag.cmd.push(function() { googletag.display('{$this->divId}'); });
</script>
</div>
RETURN;

        return $output;
    }
    
    /**
     * Fix the given sizes, if possible, so that they will match the internal array needs.
     *
     * @throws Fybcode\DfpBundle\Model\AdSizeException
     * @param array|null$sizes
     * @return array|null
     */
    protected function fixSizes($sizes)
    {
        if ($sizes === null) {
            return;
        }

        if (count($sizes) == 0) {
            throw new AdSizeException('The size cannot be an empty array. It should be given as an array with a width and height. ie: array(800,600).');
        }

        if ($this->checkSize($sizes)) {
            return array($sizes);
        }

        foreach ($sizes as $size) {
            if (!$this->checkSize($size)) {
                throw new AdSizeException(sprintf('Cannot take the size: %s as a parameter. A size should be an array giving a width and a height. ie: array(800,600).', printf($size, true)));
            }
        }

        return $sizes;
    }

    /**
     * Check that the given size has is an array with two numeric elements.
     */
    protected function checkSize($size)
    {
        if (is_array($size) && count($size) == 2 && isset($size[0]) && is_numeric($size[0]) && isset($size[1]) && is_numeric($size[1])) {
            return true;
        }

        return false;
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
        $this->sizes = $this->fixSizes($sizes);
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
}
