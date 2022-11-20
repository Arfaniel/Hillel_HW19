<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\VisitPersisting;
use Faker\Factory;


class VisitController extends Controller
{
    public function index()
    {
        $faker = Factory::create();
        $ip = $faker->ipv4();
        if ($ip == '127.0.0.1') {
            $ip = request()->server->get('HTTP_X_FORWARDED_FOR');
        }
        $userAgentString = $faker->userAgent();

        VisitPersisting::dispatch($ip, $userAgentString)->onQueue('parsing');
    }
}
