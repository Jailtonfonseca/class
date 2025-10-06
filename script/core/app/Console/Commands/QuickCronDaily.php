<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\Upgrade;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class QuickCronDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:quick-cron-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run QuickCMS Cron Job Daily';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* Create sitemap.xml */
        $url = route('home');
        $url = rtrim($url, '/');

        $sitemap = SitemapGenerator::create($url)->getSitemap();

        $sitemap->writeToFile(public_path('sitemap.xml'));
        return 0;
    }
}
