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
appnexus.com, 2437, RESELLER, f5ab79cb980f11d1

google.com, pub-1847030151454431, RESELLER, f08c47fec0942fa0
google.com, pub-9685734445476814, DIRECT, f08c47fec0942fa0
google.com, pub-6873606674919521, DIRECT, f08c47fec0942fa0
google.com, pub-0037126603126973, DIRECT, f08c47fec0942fa0

freeskreen.com, 178, DIRECT, fe119a6acfd19070
slimcut.media, 178, DIRECT, fe119a6acfd19070
indexexchange.com, 184088, RESELLER

indexexchange.com, 184884, RESELLER, 50b1c356f2c5c8fc

districtm.io, 101151, DIRECT
appnexus.com, 1908, RESELLER, f5ab79cb980f11d1

adtech.com, 10895, RESELLER

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
