<?php

namespace App\Jobs;

use App\Models\Visit;
use App\Services\UserAgent\UserAgentServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vagrant\Geo\PackageGeoInterface\GeoServiceInterface;

class VisitPersisting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ip;
    public $country_code;
    public $continent_code;
    public $browser_name;
    public $os_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $ip, GeoServiceInterface $geoReader, UserAgentServiceInterface $userAgentReader)
    {
        $geoReader->parse($ip);
        $userAgentReader->parse($_SERVER['HTTP_USER_AGENT']);
        $this->ip = $ip;
        $this->country_code = $geoReader->getCountry() ?? 'UN';
        $this->continent_code = $geoReader->getIsoCode() ?? 'UN';
        $this->browser_name = $userAgentReader->getBrowser();
        $this->os_name = $userAgentReader->getOs();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Visit::create([
            'ip' => $this->ip,
            'country_code' => $this->country_code,
            'continent_code' => $this->continent_code,
            'browser_name' => $this->browser_name,
            'os_name' => $this->os_name
        ]);
    }
}
