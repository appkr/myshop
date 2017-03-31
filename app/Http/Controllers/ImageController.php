<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Image;
use Illuminate\Http\UploadedFile;

class ImageController extends Controller
{
    const IMAGE_DIR = 'public/product_images';

    public function __construct()
    {
        $this->middleware('auth:members');
    }

    public function store(StoreImageRequest $request)
    {
        $images = collect([]);

        /** @var UploadedFile $image */
        foreach ($request->getImage() as $image) {
            $filename = $image->store(self::IMAGE_DIR);

            $savedImage = Image::create([
                'filename' => pathinfo($filename, PATHINFO_BASENAME),
                'bytes' => $image->getClientSize(),
                'mime' => $image->getClientMimeType(),
            ]);

            $images->push($savedImage);
        }

        return $images;
    }

    public function destroy(Image $image)
    {
        $image->delete();

        return response()->json([], 204);
    }
}
