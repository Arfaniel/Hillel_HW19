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
    public $userAgentString;
    public $countryCode;
    public $continentCode;
    public $browserName;
    public $osName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $ip, string $userAgentString)
    {
        $this->ip = $ip;
        $this->userAgentString = $userAgentString;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GeoServiceInterface $geoReader, UserAgentServiceInterface $userAgentReader)
    {
        $geoReader->parse($this->ip);
        $userAgentReader->parse($this->userAgentString);
        $this->countryCode = $geoReader->getCountry() ?? 'UN';
        $this->continentCode = $geoReader->getIsoCode() ?? 'UN';
        $this->browserName = $userAgentReader->getBrowser();
        $this->osName = $userAgentReader->getOs();
        Visit::create([
            'ip' => $this->ip,
            'country_code' => $this->countryCode,
            'continent_code' => $this->continentCode,
            'browser_name' => $this->browserName,
            'os_name' => $this->osName
        ]);
    }
}
