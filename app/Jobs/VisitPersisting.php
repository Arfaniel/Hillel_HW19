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
    public function __construct(string $ip, string $country_code, string $continent_code, string $browser_name, string $os_name)
    {

        $this->ip = $ip;
        $this->country_code = $country_code;
        $this->continent_code = $continent_code;
        $this->browser_name = $browser_name;
        $this->os_name = $os_name;
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
