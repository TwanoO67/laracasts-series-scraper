# Laracasts Series Scraper

Basic scraper to retrieve a full set of videos under a given series on the website laracasts.com.

- This does not circumvent the need to pay in any way, you still need a valid account
- If Jeffrey objects to this, I will take it down.

<img src="https://raw.githubusercontent.com/KMountford/laracasts-series-scraper/master/example-screenshot.jpg" data-canonical-src="https://raw.githubusercontent.com/KMountford/laracasts-series-scraper/master/example-screenshot.jpg" width="323" height="605" />

### Instructions

0. Run `composer install`
1. Add the series links to the urls file (one on each line)
2. Log in to Laracasts if you haven't already and pull your session cookie into a text format, copy it in into cookies.txt (I recommend [this chrome extension](https://chrome.google.com/webstore/detail/cookiestxt/njabckikapfpffapmjgojcnbfjonfjfg?hl=en) to easily do this)
3. Run php scrape.php when ready to begin scraping
3. Learn from the downloaded series.
