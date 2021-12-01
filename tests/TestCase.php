<?php

namespace Tests;

use App\Models\Capsule;
use App\Services\CapsuleService;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $capsuleService;
    protected $capsule;
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->capsuleService = $this->app->make(CapsuleService::class);
        $this->capsule = $this->app->make(Capsule::class);
        $this->faker = Factory::create();
    }
}
