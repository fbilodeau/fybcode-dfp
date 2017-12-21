<?php

namespace Fybcode\DfpBundle\Twig\Extension;

use Fybcode\DfpBundle\Model\AdUnit;
use Fybcode\DfpBundle\Model\Settings;
use Fybcode\DfpBundle\Model\Collection;
use Symfony\Component\HttpFoundation\RequestStack;

class DfpExtension extends \Twig_Extension
{
    protected $settings;
    protected $collection;

    /**
     * @param Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param Fybcode\DfpBundle\Model\Settings $settings
     * @param Fybcode\DfpBundle\Model\Collection $collection
     */
    public function __construct(RequestStack $requestStack, Settings $settings, Collection $collection)
    {
        $this->requestStack = $requestStack;
        $this->settings   = $settings;
        $this->collection = $collection;
    }

    /**
     * Define the functions that are available to templates.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('dfp_ad_unit', array($this, 'addAdUnit'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('dfp_oop_ad_unit', array($this, 'addOutOfPageAdUnit'), array('is_safe' => array('html')))
        );
    }

    /**
     * Create an ad unit and return the source
     *
     * @param array $adUnit
     * @return string
     */
    public function addAdUnit(array $adUnit)
    {
        $unit = new AdUnit($adUnit['code'], $adUnit['id'], $adUnit['size'], $this->requestStack->getCurrentRequest());

        $this->collection->add($unit);
        
        return $unit->output($this->settings);
    }

    /**
     * Create an out of page ad unit and return the source
     *
     * @param array $adUnit
     * @return string
     */
    public function addOutOfPageAdUnit(array $adUnit)
    {
        $unit = new AdUnit($adUnit['code'], $adUnit['id'], null);

        $this->collection->add($unit);
        
        return $unit->output($this->settings);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fybcode_dfp';
    }
}
