<?php

namespace App\Console\Commands;


use App\Services\CapsuleService;
use Illuminate\Console\Command;


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
    protected $capsuleService;

    public function __construct(CapsuleService $capsuleService)
    {
        parent::__construct();
        $this->capsuleService = $capsuleService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->capsuleService->databaseSync();
        $this->info('Success');
        $this->line('Capsule data imported');
    }
}
