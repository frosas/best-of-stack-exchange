<?php

namespace Frosas\BestOfStackExchange;

use Guzzle\Http\Url;
use Guzzle\Http\Client;
use Frosas\Misc\Collection;
use Frosas\Misc\Json;
use Frosas\BestOfStackExchange\Question;

class Site
{
    private $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    function getLastMonthBestQuestions()
    {
        return Collection::wrap($this->getLastMonthBestAnswers())
            ->group(function($answer) { return $answer->question_id; })
            ->map(function($answersToSameQuestion) { return reset($answersToSameQuestion); })
            ->map(function($answer) {
                return new Question(html_entity_decode($answer->title), $answer->link, $answer->tags);
            })
            ->unwrap();
    }

    function getName()
    {
        return ucfirst($this->id);
    }

    private function getLastMonthBestAnswers()
    {
        $url = Url::factory('https://api.stackexchange.com/2.1/answers')->setQuery(array(
            'site' => $this->id,
            'fromdate' => time() - 30 * 24 * 60 * 60,
            'todate' => time(),
            'order' => 'desc',
            'sort' => 'votes',
            'filter' => '!3zv0S-ztgFcF)gR.1'
        ));
        $client = new Client;
        $json = $client->get($url)->send()->getBody();
        return Json::decode($json)->items;
    }
}
