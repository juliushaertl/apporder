<?php
/**
 * ownCloud - foobar
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author jus <jus@bitgrid.net>
 * @copyright jus 2016
 */

require_once __DIR__.'/../../../tests/bootstrap.php';
require_once __DIR__.'/../appinfo/autoload.php';

\OC::$loader->addValidRoot(OC::$SERVERROOT.'/tests');
\OC_App::loadApp('apporder');
