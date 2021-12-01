<?php

namespace App\Repository\Eloquent;

use App\Events\SyncCompletedEvent;
use App\Events\SyncStartedEvent;
use App\Models\Capsule;

use App\Repository\CapsuleRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class CapsuleRepository extends BaseRepository implements CapsuleRepositoryInterface
{
    protected $capsule;

    public function __construct(Capsule $capsule)
    {
        $this->capsule = $capsule;
        parent::__construct($capsule);
    }

    public function listFilterCapsule()
    {
        $capsule = $this->capsule->with('missions')->get();
        if (request()->status) {
            $capsule = $capsule->where('status', 'like', request()->status);
        }
        return response($capsule, 200);
    }

    public function showCapsule($capsule_serial)
    {
        $capsule = $this->capsule->with('missions')->where('capsule_serial', $capsule_serial)->get();
        return response([
            'data' => $capsule,
        ], 200);
    }

    public function databaseSync()
    {
        DB::beginTransaction();

        try {
            event(new SyncStartedEvent());
            $res = Http::get('https://api.spacexdata.com/v3/capsules')->json();
            $clientdatas = $res;
            foreach ($clientdatas as $clientdata) {
                $data = Capsule::updateOrCreate([
                    'capsule_serial' => $clientdata['capsule_serial'],
                ],
                    [
                        'capsule_id' => $clientdata['capsule_id'],
                        'status' => $clientdata['status'],
                        'original_launch' => Carbon::parse($clientdata['original_launch'])->toDateString(),
                        'original_launch_unix' => $clientdata['original_launch_unix'],
                        'landings' => $clientdata['landings'],
                        'type' => $clientdata['type'],
                        'details' => $clientdata['details'],
                        'reuse_count' => $clientdata['reuse_count'],
                    ]);
                foreach ($clientdata['missions'] as $mission) {
                    $data->missions()->updateOrCreate(
                        [
                            'flight' => $mission['flight'],
                        ],
                        [
                            'name' => $mission['name'],
                        ],
                    );
                }
            }
            DB::commit();
            event(new SyncCompletedEvent($clientdatas));
        } catch (Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }


    }
}
