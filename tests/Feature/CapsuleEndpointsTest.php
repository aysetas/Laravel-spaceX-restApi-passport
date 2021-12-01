<?php

namespace Tests\Feature;

use App\Models\Capsule;
use App\Services\CapsuleService;

use Tests\TestCase;

class CapsuleEndpointsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListCapsule()
    {
        $this->withoutMiddleware();
        $structure=  [
            'data' => [
            'original' => [
        '*' => [
            'id',
            'capsule_serial',
            'capsule_id',
            'status',
            'original_launch',
            'original_launch_unix',
            'landings',
            'type',
            'details',
            'reuse_count',
            'created_at',
            'updated_at',
            'missions' => [
                '*' => [
                    'id',
                    'name',
                    'flight',
                    'capsule_id',
                    'created_at',
                    'updated_at'
                ],
            ],
        ],
    ]]];
        $response = $this->getJson(route('capsules.index'));
        $response->assertJsonStructure($structure);
    }


    public function testFilterCapsule()
    {
        $this->withoutMiddleware();
        $structure=  [
            'data' => [
                'original' => [
                    '*' => [
                        'id',
                        'capsule_serial',
                        'capsule_id',
                        'status',
                        'original_launch',
                        'original_launch_unix',
                        'landings',
                        'type',
                        'details',
                        'reuse_count',
                        'created_at',
                        'updated_at',
                        'missions' => [
                            '*' => [
                                'id',
                                'name',
                                'flight',
                                'capsule_id',
                                'created_at',
                                'updated_at'
                            ],
                        ],
                    ],
                ]]];

        $statuses = $this->capsule->all()->pluck('status');
        foreach ($statuses as $status) {
            $response = $this->getJson(route('capsules.index'), ['status' => $status]);
            $response->assertStatus(200);
            $response->assertJsonFragment(['status' => $status]);
            $response->assertJsonStructure($structure);
    }
    }

    public function testShowCapsule()
    {
        $this->withoutMiddleware();
        $structure=  [
            'data' => [
                'original' => [
                    '*' => [
                        'id',
                        'capsule_serial',
                        'capsule_id',
                        'status',
                        'original_launch',
                        'original_launch_unix',
                        'landings',
                        'type',
                        'details',
                        'reuse_count',
                        'created_at',
                        'updated_at',
                        'missions' => [
                            '*' => [
                                'id',
                                'name',
                                'flight',
                                'capsule_id',
                                'created_at',
                                'updated_at'
                            ],
                        ],
                    ],
                ]]];
        $capsule= $this->capsule->with('missions')->inRandomOrder()->first()->capsule_serial;
        $response = $this->getJson(route('capsules.index',['capsule_serial' => $capsule]));
        $response->assertStatus(200);
        $response->assertJsonStructure($structure);

    }
}
