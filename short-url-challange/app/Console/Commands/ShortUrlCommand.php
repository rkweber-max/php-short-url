<?php

namespace App\Console\Commands;

use AshAllenDesign\ShortURL\Classes\Builder;
use Illuminate\Console\Command;

class ShortUrlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:short-url-command';

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
        $builder = app(Builder::class);

        $shortURLObject = $builder
            ->destinationUrl('https://laravel.com')
            ->make();

        $shortURL = $shortURLObject->default_short_url;

        $this->info($shortURL);

        return 0;
    }
}
