<?php

require_once(__DIR__ . "/vendor/autoload.php");

$startTime = time();
$lines = file('urls', FILE_IGNORE_NEW_LINES);
$urlCount = count($lines);
$i = 0;
// Scrape each series url in the urls file

echo 'Found '. $urlCount;
echo $urlCount == 1 ? ' url' : ' urls';
echo ' to crawl'.PHP_EOL;

foreach ($lines as $url) {
    $client = new \Goutte\Client();
    $crawler = $client->request('GET', $url);
    $seriesLinks = $crawler->filter('li span a')->extract(array('href'));

    $dirName = str_replace('https://laracasts.com/series/', '', $url);

    // Scrape each link that's in the series
    foreach ($seriesLinks as $seriesLink) {
        $client = new \Goutte\Client();
        $crawler = $client->request('GET', 'http://www.laracasts.com/' . $seriesLink);
        $links = $crawler->filter('li a')->extract(array('href'));

        $downloadLink = '';

        // All the li a links on the page, we want to filter it down to the download link
        foreach ($links as $key => $link) {
            if (strpos($link, 'downloads') !== false) {
                $downloadLink = '"http://www.laracasts.com' . $link . '"';
            }
        }

        $pathToCookie = __DIR__ . "/cookies.txt";
        $command = 'wget --content-disposition --directory-prefix=downloads/'.$dirName.' --load-cookies'.' '.$pathToCookie.' '.$downloadLink;

        echo 'Downloading ' . str_replace('/series/', '', $seriesLink) . '...'.PHP_EOL;
//        exec($command);
        exec($command . ' > /dev/null 2>&1');
        echo 'Done!'.PHP_EOL;

        $i++;
    }
}

$endTime = time();
$timeTakenSeconds = $endTime - $startTime;
$timeTaken = ($timeTakenSeconds > 60) ? round($timeTakenSeconds / 60) . ' minutes' : $timeTakenSeconds . ' seconds';

echo PHP_EOL;
echo PHP_EOL;
echo '****************************'. PHP_EOL;
echo 'Crawled ' .$urlCount . ' series';
echo $urlCount == 1 ? ' link' : ' links';
echo ' and downloaded '. $i;
echo ($i > 1) ? ' videos': ' video';
echo ' in ' . $timeTaken.PHP_EOL;
echo '============================'. PHP_EOL;