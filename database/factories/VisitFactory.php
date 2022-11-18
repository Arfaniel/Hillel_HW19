<?php

namespace Database\Factories;

use App\Models\Visit;
use App\Services\UserAgent\UserAgentServiceInterface;
use App\Services\UserAgent\WhichBrowserService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Vagrant\Geo\PackageGeoInterface\GeoServiceInterface;
use Vagrant\PackageGeoIpApiGeoService\IpApiGeoService;
use Vagrant\PackageGeoMaxmindservice\MaxmindService;
use WhichBrowser\Analyser\Header\Useragent;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    protected $model = Visit::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $geoReader = new MaxmindService();
        $userAgentReader = new WhichBrowserService();
        $userAgentReader->parse(fake()->userAgent());
        $ip = fake()->ipv4;
        $geoReader->parse($ip);
        return [
            'ip'=> $ip,
            'country_code'=> $geoReader->getCountry() ?? 'UN',
            'continent_code'=> $geoReader->getIsoCode() ?? 'UN',
            'browser_name' => $userAgentReader->getBrowser(),
            'os_name' => $userAgentReader->getOs()
        ];
    }
}
