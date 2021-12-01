<?php

namespace App\Console\Commands;

use App\Events\SyncCompletedEvent;
use App\Events\SyncStartedEvent;
use App\Models\Capsule;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Http;

class DatabaseSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::beginTransaction();

        try {
            event(new SyncStartedEvent());
//            $client = new Client();
//            $res = $client->request('GET','https://api.spacexdata.com/v3/capsules')->getBody();
            $res = Http::get('https://api.spacexdata.com/v3/capsules')->json();
            $clientdatas = $res;
//            $clientdatas = json_decode($res->getContents(), true);

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
            $this->info('Success');
            $this->line('Capsule data imported');
        } catch (Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
