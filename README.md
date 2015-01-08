Mass Updater for YOURLS
=======================

This plugin adds an action "mass-update" to the YOURLS API.

It can be used to mass-update URLs for when a homepages changes its domain or subdomain (e.g. you move from http://example.com to
http://example2.com but you don't want all your shortened social media links to point into nirvana).

Parameters:
- oldhost
- newhost


### Installation

Under YOURLS-DIR/user/plugins create a folder `mass-update`. Clone the github files into this directory and enable the plugin through
the admin area.


### Example

Example call:
```sh
POST http://my-shortener.com/yourls-api.php
```
Body:
```sh
signature=MYTOKEN&oldhost=http%3A%2F%2Fexample.com&newhost=http%3A%2F%2Fexample2.com&action=mass-update&format=json
```


### Optimization

You are highly advised to add an index to your YOURLS `url` table to speed up the process if you have many URLs. Otherwise
the query will scan the whole table for matching entries.

Recommended index:
```sql
ALTER TABLE `yourls_url` ADD INDEX `idx_urls` (`url`(30));
```
