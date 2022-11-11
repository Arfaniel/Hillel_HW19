<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\VisitPersisting;
use App\Models\Visit;
use App\Services\UserAgent\UserAgentServiceInterface;
use Vagrant\Geo\PackageGeoInterface\GeoServiceInterface;

class VisitController extends Controller
{
    public function index(GeoServiceInterface $geoReader, UserAgentServiceInterface $userAgentReader)
    {
        $ip = request()->ip();
        if ($ip == '127.0.0.1') {
            $ip = request()->server->get('HTTP_X_FORWARDED_FOR');
        }
        $geoReader->parse($ip);
        $userAgentReader->parse($_SERVER['HTTP_USER_AGENT']);
        $country_code = $geoReader->getCountry() ?? 'UN';
        $continent_code = $geoReader->getIsoCode() ?? 'UN';
        $browser_name = $userAgentReader->getBrowser();
        $os_name = $userAgentReader->getOs();
        VisitPersisting::dispatch($ip, $country_code, $continent_code, $browser_name, $os_name)->onQueue('parsing');
    }
}
