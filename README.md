# Laracasts Series Scraper

Basic scraper to retrieve a full set of videos under a given series on the website laracasts.com.

- This does not circumvent the need to pay in any way, you still need a valid account
- If Jeffrey objects to this, I will take it down.

<img src="https://raw.githubusercontent.com/KMountford/laracasts-series-scraper/master/example.gif" data-canonical-src="https://raw.githubusercontent.com/KMountford/laracasts-series-scraper/master/example.gif" width="640" height="324" />

### Dependencies

Requires:
- wget
- composer

### Instructions

1. Run `composer install`
2. Add the series links to the urls file (one on each line)
3. Log in to Laracasts if you haven't already and pull your session cookie into a text format, copy it in into cookies.txt (I recommend [this chrome extension](https://chrome.google.com/webstore/detail/cookiestxt/njabckikapfpffapmjgojcnbfjonfjfg?hl=en) to easily do this)
4. Run php scrape.php when ready to begin scraping
5. Learn from the downloaded series.

### Docker usage

* init the environment with "docker-compose up -d"
* install dependency `./enter` then `composer install`
* don't forget to set your cookies.txt and urls files
* run the scrapper `./enter` then `php scrape.php`
