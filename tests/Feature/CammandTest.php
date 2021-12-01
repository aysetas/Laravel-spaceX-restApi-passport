<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CammandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDatabaseSyncCommand()
    {
        $this->artisan('db:sync')
            ->expectsOutput('Capsule data imported')
            ->assertExitCode(0);
    }git
}
