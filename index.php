<?php

require_once(__DIR__ . "/vendor/autoload.php");

$lines = file('urls', FILE_IGNORE_NEW_LINES);

$i = 1;

// Scrape each series url in the urls file
foreach ($lines as $url) {
    $client = new \Goutte\Client();
    $crawler = $client->request('GET', $url);
    $seriesLinks = $crawler->filter('li span a')->extract(array('href'));

    $dirName = str_replace('https://laracasts.com/series/', '', $url);
    exec('mkdir ' . $dirName);

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
        $command = 'wget --content-disposition --directory-prefix='.$dirName.' --load-cookies'.' '.$pathToCookie.' '.$downloadLink;

        echo 'Downloading ' . $seriesLink . '...'.PHP_EOL;
//        exec($command);
        exec($command . ' > /dev/null 2>&1');
        echo 'Done!'.PHP_EOL;
        $i++;
    }
}

