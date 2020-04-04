<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetPinMode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pin:mode {pin} {mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the mode for the given pin';

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
     * @return mixed
     */
    public function handle()
    {
        $pin = $this->argument('pin');
        $mode = $this->argument('mode');
        $this->info(shell_exec('gpio readall'));
        $this->info('Pin ' . $pin . ' set to ' . $mode);
        $this->info('');
        shell_exec('gpio mode ' . $pin . ' ' . $mode);
        $this->info(shell_exec('gpio readall'));
    }
}
