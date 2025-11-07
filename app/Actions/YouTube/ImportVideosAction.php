<?php

namespace App\Actions\YouTube;

use App\Models\YouTubeVideo;
use Google\Client;
use Google\Service\YouTube;
use Google\Service\YouTube\SearchResult;
use Illuminate\Support\Carbon;

class ImportVideosAction
{
    protected YouTube $youTubeService;

    public function __construct()
    {
        $googleClient = resolve(Client::class);
        $googleClient->setDeveloperKey(
            config('services.youtube.api_key')
        );

        $this->youTubeService = resolve(
            YouTube::class,
            ['clientOrConfig' => $googleClient]
        );
    }

    public function execute(): void
    {
        $searchResults = $this->searchYouTube(Carbon::now());

        while (count($searchResults) > 1) {
            foreach ($searchResults as $searchResult) {
                $this->addVideo($searchResult);

                $publishedBefore = Carbon::parse(
                    $searchResult->getSnippet()->getPublishedAt()
                );
            }
            $searchResults = $this->searchYouTube($publishedBefore);
        }
    }

    protected function searchYouTube(Carbon $publishedBefore): array
    {
        return $this->youTubeService
            ->search
            ->listSearch(
                ['id', 'snippet'],
                [
                    'channelId' => config('services.youtube.channel_id'),
                    'maxResults' => 50,
                    'order' => 'date',
                    'publishedBefore' => $publishedBefore->format('Y-m-d\TH:i:s.u\Z'),
                ]
            )->getItems();
    }

    protected function addVideo(SearchResult $searchResult): void
    {
        $searchSnippet = $searchResult->getSnippet();
        $videoId = $searchResult->getId()->getVideoId();
        $thumbnailUrl = $searchSnippet->getThumbnails()->getMedium();

        if ($videoId) {
            $video = YouTubeVideo::where(['youtube_id' => $videoId])->first();

            if (! $video) {
                YouTubeVideo::create([
                    'youtube_id' => $videoId,
                    'title' => $searchSnippet->getTitle(),
                    'thumbnail_url' => $thumbnailUrl->getUrl(),
                    'published_at' => Carbon::parse($searchSnippet->getPublishedAt()),
                ]);
            }
        }
    }
}
