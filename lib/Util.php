<?php
/**
 * @copyright Copyright (c) 2016 Julius Härtl <jus@bitgrid.net>
 *
 * @author Julius Härtl <jus@bitgrid.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\AppOrder;

use OCA\AppOrder\Service\ConfigService;

class Util {

	private $userId;
	private $appConfig;

	public function __construct(ConfigService $appConfig, $userId) {
		$this->userId = $userId;
		$this->appConfig = $appConfig;
	}

	public function getAppOrder() {
		$order_user = $this->appConfig->getUserValue('order', $this->userId);
		$order_default = $this->appConfig->getAppValue('order');
		if ($order_user !== null && $order_user !== "") {
			$order = $order_user;
		} else {
			$order = $order_default;
		}
		return $order;
	}

	public function matchOrder($nav, $order) {
		$nav_tmp = array();
		$result = array();
		foreach ($nav as $app) {
			$nav_tmp[$app['href']] = $app;
		}
		if(is_array($order)) {
			foreach ($order as $app) {
				if (array_key_exists($app, $nav_tmp)) {
					$result[$app] = $nav_tmp[$app];
				}
			}
		}
		foreach ($nav as $app) {
			if (!array_key_exists($app['href'], $result)) {
				$result[$app['href']] = $app;
			}
		}
		return $result;
	}

	public function getAppHidden() {
		$hidden_user = $this->appConfig->getUserValue('hidden', $this->userId);
		$hidden_default = $this->appConfig->getAppValue('hidden');
		if ($hidden_user !== null && $hidden_user !== "") {
			$hidden = $hidden_user;
		} else {
			$hidden = $hidden_default;
		}
		return $hidden;
	}

}
