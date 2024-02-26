<?php

namespace App\Console\Commands;

use App\Models\ShortenedUrl;
use App\Services\ShortenedUrlService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HandleOldShortenedUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:handle-old-shortened-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle old shortened URLs';
    protected ShortenedUrlService $shortenedUrlService;

    public function __construct(ShortenedUrlService $shortenedUrlService)
    {
        parent::__construct();
        $this->shortenedUrlService = $shortenedUrlService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = microtime(true);
        $this->info('Starting ...');

        $query = ShortenedUrl::where(ShortenedUrl::COL_VALID_UNTIL, '<', now());

        $total = $query->count();

        if (!$total) {
            $this->info('No old URLs found ('. (microtime(true) - $startTime) .')');
            return;
        }

        $bar = $this->output->createProgressBar($total);

        $this->info('Collecting all old URLs ids and generating archive items...');

        DB::beginTransaction();

        try {
            $oldUrlsIds = [];
            ShortenedUrl::where(ShortenedUrl::COL_VALID_UNTIL, '<', now())
                ->chunk(1000, function ($items) use ($bar, &$oldUrlsIds) {
                    foreach ($items as $item) {
                        $oldUrlsIds[] = $item->id;

                        $this->shortenedUrlService->generateArchiveCopy($item, false);

                        $bar->advance();
                    }
                });

            $this->info('Removing old URLs...');

            ShortenedUrl::whereIn('id', $oldUrlsIds)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }

        $this->info('Finished ('. (microtime(true) - $startTime) .')');
    }
}
