<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class BootProject extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:boot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting Laravel services...");

        $database = new Process(["php", "artisan", "migrate"]);
        $database->setTty(true);
        $database->run();

        // Reverb Server
        $reverb = new Process(['php', 'artisan', 'reverb:start']);
        $reverb->setTty(true);
        $reverb->start();

        // Queue Worker
        $queue = new Process(['php', 'artisan', 'queue:work', '--tries=3']);
        $queue->setTty(true);
        $queue->start();

        $this->info("Reverb and Queue Worker started.");

        // Mantener ambos procesos vivos
        while (true) {
            if (!$reverb->isRunning()) {
                $this->error("Reverb server stopped!");
                break;
            }

            if (!$queue->isRunning()) {
                $this->error("Queue worker stopped!");
                break;
            }

            usleep(500000); // 0.5s
        }

        return 0;
    }
}
