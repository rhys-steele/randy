<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetPinValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pin:value {pin} {value} {--pwm}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the value for the given pin';

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
        // @todo validation
        $pin = $this->argument('pin');
        $mode = $this->argument('mode');
        $value = $this->argument('value');
        if ($mode == 'pwm') {
            shell_exec('gpio pwm ' . $pin . ' ' . $value);
        } else {
            shell_exec('gpio write ' . $pin . ' ' . $value);
        }
        $this->info('Pin ' . $pin . ' set to ' . $value . ' using ' . $mode);
        $this->info('');
        $this->info(shell_exec('gpio readall'));
    }
}
