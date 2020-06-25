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
appnexus.com, 2437, DIRECT, f5ab79cb980f11d1

google.com, pub-1847030151454431, DIRECT, f08c47fec0942fa0
google.com, pub-6873606674919521, DIRECT, f08c47fec0942fa0
google.com, pub-0037126603126973, DIRECT, f08c47fec0942fa0
google.com, pub-9685734445476814, DIRECT, f08c47fec0942fa0
google.com, pub-6283873300935465, DIRECT, f08c47fec0942fa0
freeskreen.com, 178, DIRECT, fe119a6acfd19070
tremorhub.com, 030lb-bps80, DIRECT, 1a4e959a1b50034a
indexexchange.com, 184088, RESELLER, 50b1c356f2c5c8fc
quantum-advertising.com, 3247, RESELLER
quantum-advertising.com, 3159, RESELLER
quantum-advertising.com, 3198, RESELLER
appnexus.com, 2579, RESELLER
smartadserver.com, 1772, RESELLER
advertising.com, 22118, RESELLER

districtm.io, 101151, DIRECT, 3fd707be9c4527c3
appnexus.com, 1908, RESELLER, f5ab79cb980f11d1

adtech.com, 10895, DIRECT
coxmt.com, 2000067907202, RESELLER
pubmatic.com, 156078, RESELLER
pubmatic.com, 156377, RESELLER
pubmatic.com, 155967, RESELLER
openx.com, 537143344, RESELLER
indexexchange.com, 175407, RESELLER
openx.com, 537125356, RESELLER
openx.com, 540471645, DIRECT, 6a698e2ec38604c6

pubmatic.com, 158605, DIRECT, 5d62403b186f2ace

aps.amazon.com,5958391e-88ea-48ec-8c15-5013f0cdbc6d,DIRECT
pubmatic.com,157150,RESELLER,5d62403b186f2ace
openx.com,540191398,RESELLER,6a698e2ec38604c6
appnexus.com,1908,RESELLER,f5ab79cb980f11d1
yldbt.com,5b522cc167f6b300b89dc6d3,RESELLER,cd184cb30abaabb5
adtech.com,12068,RESELLER
districtm.io,100962,RESELLER,3fd707be9c4527c3
rubiconproject.com,18020,RESELLER,0bfd66d529a55807
rhythmone.com,1654642120,RESELLER,a670c89d4a324e47

ad-generation.jp,12474,RESELLER
appnexus.com,3663,RESELLER,f5ab79cb980f11d1
yahoo.com,55029,RESELLER,e1a5b5b6e3255540

m32.media, 1033, DIRECT
m32connect.com, 1033, DIRECT

RETURN;

        // Dispatch request
        $response = new Response($txtFile);
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
}
