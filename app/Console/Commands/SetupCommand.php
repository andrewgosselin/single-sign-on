<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sso:setup {--fullreset} {--skipconfirmations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Does the initial setup for the SSO application.';

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
        if(!$this->option('skipconfirmations') && $this->option('fullreset')) {
            $confirmed = $this->confirm('Are you sure you want to do a full reset?', true);
        } else {
            $confirmed = true;
        }

        // Migrate and reset.
        if($this->option('fullreset') || $this->confirm('Do you want to reset and migrate the database? (This will remove all data in the database to be a fresh install.)', true)) {
            \Artisan::call("migrate:fresh");
            $this->info('Successfully migrated and reset the database.');
        } else {
            $this->info('Skipping reset.');
            if($this->confirm('Do you want to migrate the database?', true)) {
                \Artisan::call("migrate");
                $this->info('Successfully migrated the database.');
            } else {
                $this->info('Skipping migration.');
            }
        }

        // Setup passport.
        // if($this->option('fullreset') || $this->confirm('Do you want to setup OAuth? (Dont do this if you have already ran the OAuth setup.)', true)) {
        //     \Artisan::call("passport:install --uuids --force");
        //     $this->info('Successfully installed the OAuth.');
        // } else {
        //     $this->info('Skipping OAuth install.');
        // }

        // Seed database.
        if($this->option('fullreset') || $this->confirm('Do you want to seed the database? (This is recommended, adds all required default data.)', true)) {
            \Artisan::call("db:seed");
            $this->info('Successfully seeded the database.');
        } else {
            $this->info('Skipping database seed.');
        }

        $this->info('Single Sign On install complete.');
        return 0;
    }
}
