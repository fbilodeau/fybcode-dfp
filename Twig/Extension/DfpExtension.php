<?php

namespace Fybcode\DfpBundle\Twig\Extension;

use Fybcode\DfpBundle\Model\AdUnit;
use Fybcode\DfpBundle\Model\Settings;
use Fybcode\DfpBundle\Model\Collection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DfpExtension extends AbstractExtension
{
    protected $settings;
    protected $collection;

    /**
     * @param Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param Fybcode\DfpBundle\Model\Settings $settings
     * @param Fybcode\DfpBundle\Model\Collection $collection
     */
    public function __construct(RequestStack $requestStack, Settings $settings, Collection $collection, TokenStorageInterface $tokenStorageInterface, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->requestStack = $requestStack;
        $this->settings   = $settings;
        $this->collection = $collection;
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Define the functions that are available to templates.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('dfp_ad_unit', array($this, 'addAdUnit'), array('is_safe' => array('html'))),
        ];
    }

    /**
     * Create an ad unit and return the source
     *
     * @param array $adUnit
     * @return string
     */
    public function addAdUnit(array $adUnit)
    {
        // Check if user logged in.
        $userId = 0;
        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->tokenStorageInterface->getToken()->getUser()) {
            $userId = $this->tokenStorageInterface->getToken()->getUser()->getId();
        }

        $unit = new AdUnit($adUnit['code'], $adUnit['id'], $adUnit['size'], $this->requestStack->getCurrentRequest(), $userId, $adUnit['madopsPreset'], $adUnit['dfpAdUnitPath'], $adUnit['m32id']);

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
