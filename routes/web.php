<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('posts');
});

Route::get('post/{post}', function (string $slug ) {
    $path =  __DIR__ . "/../resources/posts/{$slug}.html";
    if ( ! file_exists( $path ) ) {
        //dd('File does not exist');
        //ddd('File does not exist');
        //abort(404);
        return redirect('/');
    }

    $post = cache()->remember("posts.{$slug}", 5, function () use ($path) {
        var_dump('fresh fetch!');
        return file_get_contents($path);
    });

    return view('post', [
        'post' => $post // $post
    ]);
})->where( 'post', '[A-z_\-]+');
