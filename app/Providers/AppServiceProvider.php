<?php

namespace App\Providers;

use Vagrant\PackageGeoIpApiGeoService\IpApiGeoService;
use Vagrant\Geo\PackageGeoInterface\GeoServiceInterface;
use Vagrant\PackageGeoMaxmindservice\MaxmindService;
use App\Services\UserAgent\UserAgentServiceInterface;
use App\Services\UserAgent\WhichBrowserService;
use GeoIp2\Database\Reader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GeoServiceInterface::class, function(){
            return new IpApiGeoService();
//            return new MaxmindService();
        });
        $this->app->singleton(UserAgentServiceInterface::class, function(){
            return new WhichBrowserService($_SERVER['HTTP_USER_AGENT']);
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
