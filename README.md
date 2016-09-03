# AppOrder

[![Build Status](https://travis-ci.org/juliushaertl/apporder.svg?branch=master)](https://travis-ci.org/juliushaertl/apporder) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/juliushaertl/apporder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/juliushaertl/apporder/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/juliushaertl/apporder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/juliushaertl/apporder/?branch=master)


Enable sorting for icons inside the app menu. The order will be saved for each
user individually. Administrators can define a custom default order.
AppOrder works with the default owncloud menu as well as with the direct_menu
app.

![AppOrder in Action](https://bitgrid.net/~jus/apporder.gif)


## Set a default order for all new users

Go to the Admin settings > Additional settings and drag the icons under App order.

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
