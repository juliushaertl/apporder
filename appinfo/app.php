<?php

namespace OCA\AppOrder\AppInfo;

$app = new Application();

\OCP\Util::addStyle('apporder', 'apporder');
\OCP\Util::addScript('apporder', 'apporder');
\OCP\App::registerAdmin('apporder', 'admin');
