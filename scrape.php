<?php

require_once(__DIR__ . "/vendor/autoload.php");

function dd($dumpThis) {
    var_dump($dumpThis);
    die();
}

$startTime = time();
$lines = file('urls', FILE_IGNORE_NEW_LINES);

## Strips out any lines that are comments to ensure the count is of urls only.
foreach ($lines as $key => $line) {
    if (strpos($line, '#') !== false) {
        unset($lines[$key]);
    }
}

$urlCount = count($lines);

if ($urlCount == 0) {
    echo 'No urls found.'.PHP_EOL;
    echo 'Please enter at least one url in the urls file'.PHP_EOL;
    exit;
}

$i = 0;

echo 'Found '. $urlCount;
echo $urlCount == 1 ? ' url' : ' urls';
echo ' to crawl'.PHP_EOL;

$site='https://laracasts.com/';

foreach ($lines as $url) {
    $client = new \Goutte\Client();
    $crawler = $client->request('GET', $url);
    $episodeItemLinks = $crawler->filter('.episode-list-title a')->extract(array('href'));
    $dirName = str_replace($site, '', $url);

    // Scrape each link that's in the series
    $episodeItemLinks = array_unique($episodeItemLinks);

    foreach ($episodeItemLinks as $episodeItem) {

        if (strpos($episodeItem, '/series/') === false) {
            continue;
        }

        $client = new
         \Goutte\Client();
         echo 'Episode link ' .$site . $episodeItem.PHP_EOL;
        $crawler = $client->request('GET', $site . $episodeItem);

        $downloadLink = $crawler->filter('a[title="Download Video"]')->first()->attr('href');
        $downloadLink = '"'.$site . $downloadLink . '"';

        $pathToCookie = __DIR__ . "/cookies.txt";
        $command = 'wget --content-disposition --directory-prefix=downloads/'.$dirName.' --load-cookies'.' '.$pathToCookie.' '.$downloadLink;

        echo 'Downloading ' . str_replace('/series/', '', $episodeItem) . '...'.PHP_EOL;
       // exec($command);
        exec($command . ' > /dev/null 2>&1');
        echo 'Done!'.PHP_EOL;

        $i++;
    }
}

$endTime = time();
$timeTakenSeconds = $endTime - $startTime;
$timeTaken = ($timeTakenSeconds > 60) ? round($timeTakenSeconds / 60) . ' minute(s)' : $timeTakenSeconds . ' seconds';

echo PHP_EOL;
echo PHP_EOL;
echo '****************************'. PHP_EOL;
echo 'Crawled ' .$urlCount . ' series';
echo $urlCount == 1 ? ' link' : ' links';
echo ' and downloaded '. $i;
echo ($i > 1) ? ' videos': ' video';
echo ' in ' . $timeTaken.PHP_EOL;
echo '============================'. PHP_EOL;;