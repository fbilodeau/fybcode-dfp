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
google.com, pub-6873606674919521, DIRECT, f08c47fec0942fa0
google.com, pub-0037126603126973, DIRECT, f08c47fec0942fa0
google.com, pub-9685734445476814, DIRECT, f08c47fec0942fa0

adtech.com, 10895, direct
coxmt.com, 2000067907202, reseller
pubmatic.com, 156078, reseller
pubmatic.com, 156377, reseller
pubmatic.com, 155967, reseller
openx.com, 537143344, reseller
indexexchange.com, 175407, reseller
openx.com, 537125356, reseller
aol.net, 10895, direct
aol.com, 54777, direct, e1a5b5b6e3255540
yahoo.com, 54777, direct, e1a5b5b6e3255540
indexexchange.com, 184884, direct, 50b1c356f2c5c8fc
aps.amazon.com, 5958391e-88ea-48ec-8c15-5013f0cdbc6d, direct
admanmedia.com, 726, reseller
sharethrough.com, 7144eb80, reseller
yieldmo.com, 2719019867620450718, reseller
smaato.com, 1100044650, reseller, 07bcf65f187117b4
rubiconproject.com, 18020, reseller, 0bfd66d529a55807
emxdgt.com, 2009, reseller, 1e1d41537f7cad7f
districtm.io, 100962, reseller, 3fd707be9c4527c3
pubmatic.com, 157150, reseller, 5d62403b186f2ace
pubmatic.com, 160096, reseller, 5d62403b186f2ace
pubmatic.com, 160006, reseller, 5d62403b186f2ace
openx.com, 540191398, reseller, 6a698e2ec38604c6
ad-generation.jp, 12474, reseller, 7f4ea9029ac04e53
contextweb.com, 562541, reseller, 89ff185a4c4e857c
rhythmone.com, 1654642120, reseller, a670c89d4a324e47
yahoo.com, 55029, reseller, e1a5b5b6e3255540
appnexus.com, 3663, reseller, f5ab79cb980f11d1
appnexus.com, 1908, reseller, f5ab79cb980f11d1
appnexus.com, 1356, reseller, f5ab79cb980f11d1
gumgum.com, 14141, reseller, ffdef49475d318a9
rubiconproject.com, 23292, direct, 0bfd66d529a55807
yahoo.com, 56566, direct, e1a5b5b6e3255540
appnexus.com, 2437, direct, f5ab79cb980f11d1
districtm.io, 101151, direct, 3fd707be9c4527c3
smartadserver.com, 1772, reseller
advertising.com, 22118, reseller
tremorhub.com, 030lb-bps80, reseller, 1a4e959a1b50034a
telaria.com, 030lb-bps80, reseller, 1a4e959a1b50034a
indexexchange.com, 184088, reseller, 50b1c356f2c5c8fc
freeskreen.com, 178, direct, fe119a6acfd19070
google.com, pub-1847030151454431, reseller, f08c47fec0942fa0
advertising.com, 28612, direct
aol.com, 55212, direct, e1a5b5b6e3255540
yahoo.com, 55212, direct, e1a5b5b6e3255540
rubiconproject.com, 23294, reseller, 0bfd66d529a55807
smartadserver.com, 3353, direct
pubmatic.com, 156439, reseller
pubmatic.com, 154037, reseller
smartadserver.com, 4071, direct
adyoulike.com, b4bf4fdd9b0b915f746f6747ff432bde, reseller
axonix.com, 57264, reseller
admanmedia.com, 43, reseller
smaato.com, 1100044045, reseller, 07bcf65f187117b4
rubiconproject.com, 16114, reseller, 0bfd66d529a55807
verve.com, 15503, reseller, 0c8f5958fc2d6270
openx.com, 537149888, reseller, 6a698e2ec38604c6
loopme.com, 5679, reseller, 6c8d5f95897a5a3b
xad.com, 958, reseller, 81cbf0a75a5e0e9a
contextweb.com, 560288, reseller, 89ff185a4c4e857c
rhythmone.com, 2564526802, reseller, a670c89d4a324e47
pubnative.net, 1006576, reseller, d641df8625486a7b
appnexus.com, 3703, reseller, f5ab79cb980f11d1
sharethrough.com, ozkPECkT, direct, d53b998a7bd4ecd2
m32connect.com, 1033, direct
m32.media, 1033, direct
openx.com, 540471645, direct, 6a698e2ec38604c6
pubmatic.com, 158605, direct, 5d62403b186f2ace
152media.com, 152, direct
appnexus.com, 3153, reseller, f5ab79cb980f11d1
lockerdome.com, 11424682666850300, direct
sharethrough.com, aa5dab82, direct, d53b998a7bd4ecd2

RETURN;

        // Dispatch request
        $response = new Response($txtFile);
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
}
