<?php

require __DIR__ . '/vendor/autoload.php';

use Frosas\BestOfStackExchange\Site;
use Frosas\BestOfStackExchange\Site\Feed;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application;
# $app['debug'] = true;

$app->get('{siteId}/feed', function($siteId) use ($app) {
    $feed = new Feed(new Site($siteId));
    return new Response($feed->toString(), 200, array('Content-Type' => 'text/xml'));
});

$app->run();
