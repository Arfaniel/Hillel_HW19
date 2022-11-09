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

        VisitPersisting::dispatch($ip, $geoReader, $userAgentReader)->onQueue('parsing');
    }
}
