# AppOrder

[![Build Status](https://travis-ci.org/juliushaertl/apporder.svg?branch=master)](https://travis-ci.org/juliushaertl/apporder) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/juliushaertl/apporder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/juliushaertl/apporder/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/juliushaertl/apporder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/juliushaertl/apporder/?branch=master)

> **Warning**
>
> Due to server changes this app will no longer be compatible with Nextcloud 25 and is considered unmaintained from now on. 
> For introducing the functionality upstream please follow https://github.com/nextcloud/server/issues/4917

Enable sorting the app icons from the personal settings. The order will be 
saved for each user individually. Administrators can define a custom default 
order.

## Set a default order for all new users

Go to the Settings > Administration > Additional settings and drag the icons under App order.

## Use first app as default app

You can easily let Nextcloud redirect your user to the first app in their
personal order by changing the following parameter in your config/config.php:

    'defaultapp' => 'apporder',

Users will now get redirected to the first app of the default order or to the
first app of the user order. 

# Installation

## From git

1. Clone the app into your apps/ directory: `git clone https://github.com/juliushaertl/apporder.git`
2. Enable it
