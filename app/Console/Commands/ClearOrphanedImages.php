<?php

namespace App\Console\Commands;

use App\Image;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Storage;

class ClearOrphanedImages extends Command
{
    const IMAGE_DIR = 'public/product_images';

    protected $signature = 'myshop:clear-orphaned-images';

    protected $description = '상품에 연결되지 않은 고아 이미지를 청소합니다.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $orphaned = Image::whereNull('product_id')
            ->where('created_at', '<', Carbon::now()->subDay())
            ->get();

        $bar = $this->output->createProgressBar($orphaned->count());

        foreach ($orphaned as $image) {
            $path = self::IMAGE_DIR . DIRECTORY_SEPARATOR . $image->filename;
            Storage::delete($path);
            $image->delete();
            $bar->advance();
        }

        $bar->finish();
    }
}
