<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sso:createApplication {name} {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an application';

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
        $application = \App\Models\Application::create([
            "name" => $this->argument('name'),
            "url" => $this->argument('url')
        ]);
        $this->line('=======================================');
        $this->line('SSO Application created successfully.');
        $this->line('-----------------------------------------');
        $this->line('ID: ' . $application->id);
        $this->line('Client ID: ' . $application->client->id);
        $this->line('Client Secret: ' . $application->client->secret);
        $this->line('Client Callback: ' . $application->client->callback);
        $this->line('=======================================');
        return 0;
    }
}
