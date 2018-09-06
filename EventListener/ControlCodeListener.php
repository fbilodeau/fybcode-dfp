<?php

namespace Fybcode\DfpBundle\EventListener;

use Fybcode\DfpBundle\Model\Collection;
use Fybcode\DfpBundle\Model\Settings;
use Fybcode\DfpBundle\Model\AdUnit;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;

/**
 * @package     FybcodeDfpBundle
 * @author      Francis Bilodeau <fbilodeau@dessinsdrummond.com>
 * @copyright   (c) 2017 Francis Bilodeau
 */

class ControlCodeListener
{
    /**
     * The template placeholder where the DFP code is to be inserted.
     */
    const PLACEHOLDER = '<!-- FybcodeDfpBundle Control Code -->';

    /**
     * @var Fybcode\DfpBundle\Model\Collection
     */
    protected $collection;

    /**
     * @var Fybcode\DfpBundle\Model\Settings
     */
    protected $settings;

    /**
     * @var Symfony\Component\HttpFoundation\RequestStack $requestStack
     */
    protected $requestStack;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * Constructor.
     *
     * @param Fybcode\DfpBundle\Model\Collection $collection
     * @param Fybcode\DfpBundle\Model\Settings $settings
     * @param Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param Doctrine\ORM\EntityManager $em
     */
    public function __construct(Collection $collection, Settings $settings, RequestStack $requestStack, EntityManager $em)
    {
        $this->settings   = $settings;
        $this->collection = $collection;
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    /**
     * Switch out the Control Code placeholder for the Google DFP control code html,
     * based upon the included ads.
     *
     * @param Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $controlCode = '';
        if (count($this->collection) > 0) {
            $controlCode .= $this->getMainControlCode();

            $controlCode .= $this->setTargeting($this->requestStack->getCurrentRequest()->get('_route'), $this->requestStack->getCurrentRequest()->get('_route_params'));

            foreach ($this->collection as $unit) {
                $controlCode .= $unit->getSizes() === null ? $this->getOutOfPageAdControlBlock($unit) : $this->getAdControlBlock($unit);
            }

        }

        $response->setContent(str_replace(self::PLACEHOLDER, $controlCode, $response->getContent()));
    }

    /**
     * Get the main google dfp control code block.
     *
     * This inserts the main google script.
     *
     * @return string
     */
    protected function getMainControlCode()
    {
        // <script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
        return <<< CONTROL
<script async src='//rdc.m32.media/m32hb_gpt.min.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>
CONTROL;
    }
    
    /**
     * Get the control block for an individual ad.
     *
     * @return string
     */
    protected function getAdControlBlock(AdUnit $unit)
    {
        $publisherId  = trim($this->settings->getPublisherId(), '/');
        $desktopSizes = $this->printDesktopSizes($unit->getSizes());
        $mobileSizes  = $this->printMobileSizes($unit->getSizes());
        $divId        = $unit->getDivId();
        $path         = $unit->getPath();

        return <<< BLOCK
<script type="text/javascript">
googletag.cmd.push(function() {
      var mapping = googletag.sizeMapping().
      addSize([0, 0], {$mobileSizes}).
      addSize([1050, 200], {$desktopSizes}).build();   
googletag.defineSlot('/{$publisherId}/{$path}', {$desktopSizes}, '{$divId}').defineSizeMapping(mapping).addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>
BLOCK;
    }

    /**
     * Get the control block for an individual ad.
     *
     * @return string
     */
    protected function getOutOfPageAdControlBlock(AdUnit $unit)
    {
        $publisherId = trim($this->settings->getPublisherId(), '/');
        $divId       = $unit->getDivId();
        $path        = $unit->getPath();

        return <<< BLOCK
<script type="text/javascript">
googletag.cmd.push(function() {
googletag.defineOutOfPageSlot('/{$publisherId}/{$path}', '{$divId}').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>
BLOCK;
    }
    
    /**
     * Print the sizes array in it's json equivalent.
     *
     * @param array $sizes
     * @return string
     */
    protected function printDesktopSizes(array $sizes)
    {
        // This function is to check what is the allowed size for the ads. We will only allow desktop friendly ads.
        $string = '';
        if (count($sizes)) {
            foreach ($sizes as $size) {
                if (($size[1] != '50') && ($size[1] != '100')) {
                    $string .= '[' . $size[0] . ', ' . $size[1] . '], ';
                }
            }
        }

        return '['.trim($string, ', ').']';
    }

    /**
     * Print the sizes array in it's json equivalent.
     *
     * @param array $sizes
     * @return string
     */
    protected function printMobileSizes(array $sizes)
    {
        // This function is to check what is the allowed size for the ads. We will only allow mobile friendly ads.
        $string = '';
        if (count($sizes)) {
            foreach ($sizes as $size) {
                if (($size[0] <= '320') && ($size[1] <= '250')) {
                    $string .= '[' . $size[0] . ', ' . $size[1] . '], ';
                }
            }
        }

        return '['.trim($string, ', ').']';
    }

    /* Todo: Frank: Cette fonction devrait normalement être dans mon fichier AppBundle, car c'est du code qui est spécifique à mon application principale. Ainsi, il faudrait garder
    probablement la fonction ici, et pouvoir être capable de l'appeler, soit via une requête twig ou un paramètre. Pour le moment, je laisse le tout ici, mais ce sera à réfléchir
    à l'avenir. */
    /**
     * Set targeting tag depending on our route and on different parameters.
     * This is hardcoded due to the fact that we do not want to edit manually every twig templates.
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    protected function setTargeting($route, $params = array())
    {
        $targets = array();
        $categories = array();
        $output = null;

        switch ($route) {
            case 'accueil':
                $targets[] = array('sections' => 'accueil');
                break;
            case 'catalog':
                $targets[] = array('sections' => 'recherche');
                break;
            case 'collection-single':
                $targets[] = array('sections' => 'recherche');
                if (isset($params['slugFr'])) {
                    $planCollection = $this->em->getRepository('AppBundle:PlanCollection')->findOneBy(array('slugFr' => $params['slugFr']));
                    if ($planCollection) {
                        $id = $planCollection->getId();
                        // Collections with garages
                        if (($id == 14) || ($id == 15) || ($id == 16) || ($id == 21) || ($id == 22) || ($id == 23) || ($id == 24) || ($id == 29) || ($id == 34) ||
                            ($id == 42) || ($id == 44) || ($id == 45) || ($id == 46) || ($id == 47) || ($id == 48) || ($id == 49) || ($id == 64) || ($id == 66) ||
                            ($id == 73) || ($id == 110) || ($id == 126) || ($id == 134) || ($id == 143) || ($id == 155) || ($id == 157) || ($id == 161) ||
                            ($id == 165) || ($id == 169) || ($id == 172) || ($id == 190) || ($id == 191) || ($id == 192)) {
                            $categories[] = array('type' => 'garage');
                            $categories[] = array('categorie' => 'attachedGarage');
                        }
                        // Vicwest
                        if (($id == 6) || ($id == 7) || ($id == 8) || ($id == 9) || ($id == 10) || ($id == 38) || ($id == 39) || ($id == 123) || ($id == 147) ||
                            ($id == 175)) {
                            $categories[] = array('advertiser' => 'vicwest');
                        }
                    }
                }
                break;
            case 'fiche':
                $targets[] = array('sections' => 'detail');
                if (isset($params['slug'])) {
                    $plan = $this->em->getRepository('AppBundle:Plan')->getPlanByPlanUrl($params['slug']);
                    if ($plan) {
                        // Plan Type.
                        if ($plan->getPlanType()->getId()) {
                            $dfp_value = null;
                            switch ($plan->getPlanType()->getId()) {
                                case '1000001':
                                    $dfp_value = "house";
                                    break;
                                case '1000002':
                                    $dfp_value = "garage";
                                    break;
                                case '1000005':
                                    $dfp_value = "multifamily";
                                    break;
                            }
                            if ($dfp_value) {
                                $categories[] = array('type' => $dfp_value);
                            }
                        }
                        // Plan Formats.
                        $planFormats = $plan->getPlanFormats();
                        if (count($planFormats)) {
                            foreach($planFormats as $planFormat) {
                                if ($planFormat->getPlanFormat()->getId()) {
                                    $dfp_value = null;
                                    switch ($planFormat->getPlanFormat()->getId()) {
                                        case '1000001':
                                            $dfp_value = '1etage';
                                            break;
                                        case '1000003':
                                            $dfp_value = '2etages';
                                            break;
                                        case '1000004':
                                            $dfp_value = 'splitLevel';
                                            break;
                                    }
                                    if ($dfp_value) {
                                        $categories[] = array('format' => $dfp_value);
                                    }
                                }
                            }
                        }
                        // Plan categories.
                        $planCategories = $plan->getPlanCategories();
                        if (count($planCategories)) {
                            foreach($planCategories as $planCategory) {
                                if ($planCategory->getPlanCategory()->getId()) {
                                    $dfp_value = null;
                                    switch ($planCategory->getPlanCategory()->getId()) {
                                        case '1000009':
                                        case '1000010':
                                            $dfp_categorie[] = 'duplexTriplex';
                                            break;
                                        case '1000012':
                                            $dfp_categorie[] = 'garageApartment';
                                            break;
                                        case '1000016':
                                        case '1000019':
                                            $dfp_categorie[] = 'limitedMobility';
                                            break;
                                        case '1000007':
                                            $dfp_categorie[] = 'semiDetached';
                                            break;
                                        case '1000020':
                                            $dfp_categorie[] = 'tinyHouse';
                                            break;
                                    }
                                    if ($dfp_value) {
                                        $categories[] = array('categorie' => $dfp_value);
                                    }
                                }
                            }
                        }
                        // Garage.
                        $planGarage = $plan->getGarageOption();
                        if ($planGarage) {
                            if (($planGarage->getId()) && ($planGarage->getId() != '1000008')) {
                                $categories[] = array('categorie' => 'attachedGarage');
                            }
                        }
                        // Construction cost.
                        if ($plan->getConstructionCost()) {
                            if ($plan->getConstructionCost() <= 175000) {
                                $categories[] = array('prix' => '175000');
                            } else if ($plan->getConstructionCost() > 500000) {
                                $categories[] = array('prix' => 'plusde500000');
                            } else if ($plan->getConstructionCost() <= 500000) {
                                $categories[] = array('prix' => '500000');
                            }
                        }
                        // No plan.
                        if ($plan->getPlanNumber()) {
                            $categories[] = array('noplan' => $plan->getPlanNumber());
                        }
                    }
                }
                break;
            /* Todo : S'assurer d'avoir toutes les pages de rénovation */
            case 'portfolio':
            case 'portfolioTheme':
                if (isset($params['id']) && $params['id'] = 1000001) {
                    $categories[] = array('categorie' => 'attachedGarage');
                }
            case 'fiche-reno':
                $targets[] = array('sections' => 'renovation');
                break;
            case 'points-vente':
            case 'fiche-point':
                $targets[] = array('sections' => 'agence');
                if (isset($params['slug'])) {
                    $webTtAddress = $this->em->getRepository('AppBundle:WebTtAddress')->findOneBy(array('slug' => $params['slug']));
                    if ($webTtAddress) {
                        switch ($webTtAddress->getId()) {
                            case '2850':
                                $targets[] = array('agence' => 'Baie-Comeau');
                                break;
                            case '2853':
                                $targets[] = array('agence' => 'Baie-Saint-Paul');
                                break;
                            case '1':
                                $targets[] = array('agence' => 'Riviere-du-Loup');
                                break;
                            case '2':
                                $targets[] = array('agence' => 'Bromont');
                                break;
                            case '3':
                                $targets[] = array('agence' => 'Drummondville / St-Hyacinthe');
                                break;
                            case '1132':
                                $targets[] = array('agence' => 'Edmundston');
                                break;
                            case '4':
                                $targets[] = array('agence' => 'Gatineau');
                                break;
                            case '6':
                                $targets[] = array('agence' => 'Tremblant');
                                break;
                            case '7':
                                $targets[] = array('agence' => 'Lavaltrie');
                                break;
                            case '8':
                                $targets[] = array('agence' => 'Laval');
                                break;
                            case '2864':
                                $targets[] = array('agence' => 'Levis');
                                break;
                            case '9':
                                $targets[] = array('agence' => 'Longueuil');
                                break;
                            case '2046':
                                $targets[] = array('agence' => 'Mascouche / Terrebonne');
                                break;
                            case '12':
                                $targets[] = array('agence' => 'Quebec');
                                break;
                            case '13':
                                $targets[] = array('agence' => 'Rouyn-Noranda');
                                break;
                            case '14':
                                $targets[] = array('agence' => 'Saguenay-Lac-St-Jean');
                                break;
                            case '2870':
                                $targets[] = array('agence' => 'Saint-Georges');
                                break;
                            case '2857':
                                $targets[] = array('agence' => 'Sainte-Marie');
                                break;
                            case '15':
                                $targets[] = array('agence' => 'Sherbrooke');
                                break;
                            case '16':
                                $targets[] = array('agence' => 'Sorel-Tracy');
                                break;
                            case '17':
                                $targets[] = array('agence' => 'St-Jerome');
                                break;
                            case '18':
                                $targets[] = array('agence' => 'Valleyfield');
                                break;
                            case '19':
                                $targets[] = array('agence' => 'Trois-Rivieres');
                                break;
                            case '20':
                                $targets[] = array('agence' => 'Victoriaville');
                                break;
                        }
                    }
                }
                break;
            /* Todo: Toutes les pages du programme entrepreneur */
            case 'entrepreneur':
                $targets[] = array('sections' => 'entrepreneur');
                break;
            case 'portfolio-standard':
            case 'portfolio-standard-format':
            case 'portfolio-standard-style':
            case 'portfolio-custom':
                $targets[] = array('sections' => 'photos');
                break;
            case 'repertoire':
                $targets[] = array('sections' => 'repertoire_recherche');
                break;
            case 'entrepreneur-premium':
            case 'entrepreneur':
                $targets[] = array('sections' => 'repertoire_detail');
                break;
            default:
                $targets[] = array('sections' => 'general');
                break;
        }

        // Set our targets in code.
        if (!empty($targets)) {
            foreach($targets as $target) {
                $key = key($target);
                $value = reset($target);
                $output .= <<< BLOCK
<script type="text/javascript">
googletag.cmd.push(function() {
googletag.pubads().setTargeting('{$key}', ['{$value}']);
});
</script>
BLOCK;
            }
        }

        // This one is different, because targets are next to one another.
        if (!empty($categories)) {
            $output .= <<< BLOCK
<script type="text/javascript">
googletag.cmd.push(function() {
googletag.pubads()
BLOCK;
            foreach($categories as $category) {
                $key = key($category);
                $value = reset($category);
                $output .= <<< BLOCK
.setTargeting('{$key}', ['{$value}'])
BLOCK;
            }
            $output .= <<< BLOCK
;});
</script>
BLOCK;
        }
        return $output;
    }

}
