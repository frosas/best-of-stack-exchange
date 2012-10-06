<?php

namespace Frosas\BestOfStackExchange\Site;

use Frosas\BestOfStackExchange\Site;
use Frosas\Misc\Collection;

class Feed
{
    private $site;

    function __construct(Site $site)
    {
        $this->site = $site;
    }

    function toString()
    {
        $feed = new \SimpleXMLElement('<rss />');
        $feed['version'] = '2.0';

        $channel = $feed->addChild('channel');
        $channel->addChild('title', "Best Of Stack Exchange {$this->site->getName()}");

        foreach ($this->site->getLastMonthBestQuestions() as $question) {
            $item = $channel->addChild('item');
            $item->addChild('title', $this->getItemTitle($question));
            $item->addChild('link', $question->getUrl());
            $item->addChild('guid', $question->getUrl())->addAttribute('isPermaLink', 'true');
        }

        return $feed->asXML();
    }

    private function getItemTitle($question)
    {
        $title = $question->getTitle();
        if ($tags = $question->getTags()) {
            $title .= " " . implode(" ", Collection::map($tags, function($tag) {
                return "#$tag";
            }));
        }
        return $title;
    }
}
