<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    public function show(Filesystem $filesystem, $path)
    {
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            // 'source' => $filesystem->getDriver(),
            // 'cache' => $filesystem->getDriver(),
            'source' => 'uploads',
            'cache' => 'cache',
            'cache_path_prefix' => '.cache',
            'base_url' => 'images',
        ]);
        return $server->getImageResponse($path, request()->all());
    }
}
