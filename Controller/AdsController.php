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

telaria.com, 030lb-bps80, RESELLER, 1a4e959a1b50034a
tremorhub.com, 030lb-bps80, RESELLER, 1a4e959a1b50034a
freeskreen.com, 178, DIRECT, fe119a6acfd19070
advertising.com, 22118, RESELLER
smartadserver.com, 1772, RESELLER
indexexchange.com, 184088, RESELLER, 50b1c356f2c5c8fc

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
ad-generation.jp,12474,RESELLER,7f4ea9029ac04e53
appnexus.com,3663,RESELLER,f5ab79cb980f11d1
districtm.io,100962,RESELLER,3fd707be9c4527c3
gumgum.com,14141,RESELLER,ffdef49475d318a9
openx.com,540191398,RESELLER,6a698e2ec38604c6
pubmatic.com,157150,RESELLER,5d62403b186f2ace
pubmatic.com,160006,RESELLER,5d62403b186f2ace
pubmatic.com,160096,RESELLER,5d62403b186f2ace
rhythmone.com,1654642120,RESELLER,a670c89d4a324e47
rubiconproject.com,18020,RESELLER,0bfd66d529a55807
smaato.com,1100044650,RESELLER,07bcf65f187117b4
yahoo.com,55029,RESELLER,e1a5b5b6e3255540
admanmedia.com,726,RESELLER

m32.media, 1033, DIRECT
m32connect.com, 1033, DIRECT

google.com, pub-7026201757273977, RESELLER, f08c47fec0942fa0
google.com, pub-7353644945201577, RESELLER, f08c47fec0942fa0
rhythmone.com, 752824437, RESELLER, a670c89d4a324e47
rhythmone.com, 3526250853, RESELLER, a670c89d4a324e47
openx.com, 538808047, RESELLER
openx.com, 538808048, RESELLER
openx.com, 538808049, RESELLER
openx.com, 538808050, RESELLER
openx.com, 540344750, RESELLER, 6a698e2ec38604c6
indexexchange.com, 184032, RESELLER
indexexchange.com, 187675, RESELLER
vdopia.com, 14057, RESELLER
spotxchange.com,252547,RESELLER,7842df1d2fe2db34
spotx.tv,252547,RESELLER,7842df1d2fe2db34
video.unrulymedia.com,752824437,RESELLER
video.unrulymedia.com,3526250853,RESELLER
video.unrulymedia.com,3312463993,RESELLER
sovrn.com, 278802, RESELLER, fafdf38b16bf6b2b
lijit.com, 278802, RESELLER, fafdf38b16bf6b2b
lijit.com, 278802-eb, RESELLER, fafdf38b16bf6b2b
appnexus.com, 1360, RESELLER, f5ab79cb980f11d1
gumgum.com, 11645, RESELLER, ffdef49475d318a9
openx.com, 538959099, RESELLER, 6a698e2ec38604c6
openx.com, 539924617, RESELLER, 6a698e2ec38604c6
pubmatic.com, 137711, RESELLER, 5d62403b186f2ace
pubmatic.com, 156212, RESELLER, 5d62403b186f2ace
pubmatic.com, 156700, RESELLER, 5d62403b186f2ace
rubiconproject.com, 17960, RESELLER, 0bfd66d529a55807
triplelift.com, 8637, RESELLER, 6c33edb13117fd86
triplelift.com, 8637-EB, RESELLER, 6c33edb13117fd86
pubmatic.com, 159436, RESELLER, 5d62403b186f2ace
freewheel.tv, 1131121, RESELLER
freewheel.tv, 1131329, RESELLER

indexexchange.com, 184884, DIRECT, 50b1c356f2c5c8fc
yahoo.com, 56566, DIRECT, e1a5b5b6e3255540

RETURN;

        // Dispatch request
        $response = new Response($txtFile);
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
}
