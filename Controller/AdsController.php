<?php

/*
 * This file is part of the Fybcode DFP Bundle package.
 *
 * (c) Francis Bilodeau <fbilodeau@dessinsdrummond.com>
 *
 */

namespace Fybcode\DfpBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * AdsController.
 *
 * @author Francis Bilodeau <fbilodeau@dessinsdrummond.com>
 */
class AdsController extends Controller
{
    /**
     * Renders an ads.txt file.
     *
     * @return Response (Txt file)
     */
    public function txtAction()
    {
        $txtFile = $output = <<< RETURN
google.com, pub-9685734445476814, DIRECT, f08c47fec0942fa0
google.com, pub-0037126603126973, DIRECT, f08c47fec0942fa0

districtm.io, 100157, DIRECT
appnexus.com, 7944, RESELLER
appnexus.com, 1908, RESELLER
adtech.com, 10266, RESELLER
aol.com, 10266, RESELLER

RETURN;

        $userLocation = $this->get('ipLocation')->getUserLocation();
        if (($userLocation->getIPRegion() != 'QUEBEC') && ($userLocation->getIPRegion() != 'ONTARIO')) {
            $txtFile .= <<< RETURN
google.com, pub-6283873300935465, DIRECT, f08c47fec0942fa0
RETURN;
        }

        // Dispatch request
        $response = new Response($txtFile);
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
}
