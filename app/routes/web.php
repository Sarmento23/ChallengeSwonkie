<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post("/videos","YoutubeController@ScrapeVideos");
$router->get("/videos","YoutubeController@GetVideos");
$router->delete("/video/{id}","YoutubeController@DeleteVideo");
$router->put("/video/{id}","YoutubeController@EditVideo");

$router->get(
    '/',
    function () use ($router) {
        return "Challenge-Swonkie : Henrique Sarmento";
    }
);

?>
