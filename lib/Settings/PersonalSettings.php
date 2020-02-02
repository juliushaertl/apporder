<?php
/**
 * @copyright Copyright (c) 2019 Julius Härtl <jus@bitgrid.net>
 *
 * @author Julius Härtl <jus@bitgrid.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\AppOrder\Settings;


use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

class PersonalSettings implements ISettings {

	/** @var IConfig */
	private $config;
	/** @var \OC_Defaults */
	private $defaults;
	/** @var indicates admin-forced order */
	private $force_admin_order;

	public function __construct(IConfig $config, $appName, \OC_Defaults $defaults) {
		$this->config = $config;
		$this->defaults = $defaults;
		$this->force_admin_order = json_decode($this->config->getAppValue($appName, 'force')) ?? false;
	}

	/**
	 * @return TemplateResponse returns the instance with all parameters set, ready to be rendered
	 * @since 9.1
	 */
	public function getForm() {
		if ($this->force_admin_order) {
			$response = null;
		} else {
			$response = \OC::$server->query(\OCA\AppOrder\Controller\SettingsController::class)->personalIndex();
		}
		return $response;
	}

	/**
	 * @return string the section ID, e.g. 'sharing'
	 * @since 9.1
	 */
	public function getSection() {
		if ($this->force_admin_order) {
			return null;
		} else {
			return 'apporder';
		}
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the admin section. The forms are arranged in ascending order of the
	 * priority values. It is required to return a value between 0 and 100.
	 *
	 * E.g.: 70
	 * @since 9.1
	 */
	public function getPriority() {
		if ($this->force_admin_order) {
			return null;
		} else {
			return 90;
		}
	}

}
