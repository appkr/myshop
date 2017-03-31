<?php

use App\Image;
use App\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

/**
 * @property Generator faker
 */
class ImagesTableSeeder extends Seeder
{
    const IMAGE_DIR = 'app/public/product_images';

    public function __construct()
    {
        /** @var Generator $factory */
        $this->faker = Factory::create('ko_KR');
    }

    public function run()
    {
        Image::truncate();

        $this->prepareDirectory();

        $this->command->info('이미지 파일을 다운로드 합니다. 시간이 걸립니다.');

        Product::get()->each(function (Product $product) {
            $imgFileDto = $this->downloadFile();
            $this->persistImage($product, $imgFileDto);
            $this->command->line("{$imgFileDto->filename}을 다운로드 받았습니다");
        });
    }

    private function prepareDirectory()
    {
        $imageDir = storage_path(self::IMAGE_DIR);

        if (File::isDirectory($imageDir)) {
            File::deleteDirectory($imageDir);
        }

        File::makeDirectory($imageDir);
    }

    private function downloadFile()
    {
        $imageDir = storage_path(self::IMAGE_DIR);
        $path = $this->faker->image($imageDir);

        $dto = new stdClass;
        $dto->filename = File::basename($path);
        $dto->bytes = File::size($path);
        $dto->mime = File::mimeType($path);

        return $dto;
    }

    private function persistImage(Product $product, stdClass $imgFileDto)
    {
        return (new Image)->forceFill([
            'product_id' => $product->id,
            'filename' => $imgFileDto->filename,
            'bytes' => $imgFileDto->bytes,
            'mime' => $imgFileDto->mime,
        ])->save();
    }
}
