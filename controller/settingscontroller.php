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

namespace OCA\AppOrder\Controller;

use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\IRequest;
use \OCP\INavigationManager;
use \OCA\AppOrder\Service\ConfigService;
use \OCA\AppOrder\Util;

class SettingsController extends Controller {

	private $userId;
	private $appConfig;
	private $navigationManager;
	private $util;

	public function __construct($appName, IRequest $request, ConfigService $appConfig, INavigationManager $urlGenerator, Util $util, $userId) {
		parent::__construct($appName, $request);
		$this->userId = $userId;
		$this->appConfig = $appConfig;
		$this->navigationManager = $urlGenerator;
		$this->util = $util;
	}

	/**
	 * Admin: render admin page
	 * FIXME: Move to dedicated class
	 *
	 * @return TemplateResponse
	 */
	public function adminIndex() {
		// Private API call
		$navigation = $this->navigationManager->getAll();
		$order = json_decode($this->appConfig->getAppValue('order'));
		if($order === null) $order = array();
		$nav = $this->util->matchOrder($navigation, $order);
		$hidden = json_decode($this->appConfig->getAppValue('hidden'));
		if($hidden === null) $hidden = array();
		return new TemplateResponse(
			$this->appName,
			'admin',
			["nav" => $nav, 'type' => 'admin', 'hidden' => $hidden],
			'blank'
		);
	}

	public function personalIndex() {
		// Private API call
		$navigation = $this->navigationManager->getAll();
		$order = json_decode($this->appConfig->getUserValue('order', $this->userId));
		if($order === null){
			$order = json_decode($this->appConfig->getAppValue('order'));
			if($order === null) $order = array();
		}
		$nav = $this->util->matchOrder($navigation, $order);
		$hidden = json_decode($this->appConfig->getUserValue('hidden',$this->userId));
		if($hidden === null){
			$hidden = json_decode($this->appConfig->getAppValue('hidden'));
			if($hidden === null) $hidden = array();
		}
		return new TemplateResponse(
			$this->appName,
			'admin',
			["nav" => $nav, 'type' => 'personal', 'hidden' => $hidden],
			'blank'
		);
	}

	/**
	 * Admin: save default order
	 *
	 * @param $order
	 * @return array response
	 */
	public function saveDefaultOrder($order) {
		if (!is_null($order)) {
			$this->appConfig->setAppValue('order', $order);
		}
		return array('status' => 'success', 'order' => $order);
	}

	/**
	 * Return order for current user
	 *
	 * @NoAdminRequired
	 * @return array response
	 */
	public function getOrder() {
		$order = $this->util->getAppOrder();
		$hidden = $this->util->getAppHidden();
		return array('status' => 'success', 'order' => $order, 'hidden' => $hidden);
	}

	/**
	 * Save order for current user
	 *
	 * @NoAdminRequired
	 * @param $order string
	 * @return array response
	 */
	public function savePersonal($order) {
		$this->appConfig->setUserValue('order', $this->userId, $order);
		$response = array(
			'status' => 'success',
			'data' => array('message' => 'User order saved successfully.'),
			'order' => $order
		);
		return $response;
	}

	/**
	 * Save hidden for current user
	 *
	 * @NoAdminRequired
	 * @param $hidden string
	 * @return array response
	 */
	public function savePersonalHidden($hidden) {
		$this->appConfig->setUserValue('hidden', $this->userId, $hidden);
		$response = array(
			'status' => 'success',
			'data' => array('message' => 'User hidden saved successfully.'),
			'hidden' => $hidden
		);
		return $response;
	}

	/**
	 * Admin: save default hidden
	 *
	 * @param $hidden
	 * @return array response
	 */
	public function saveDefaultHidden($hidden) {
		if (!is_null($hidden)) {
			$this->appConfig->setAppValue('hidden', $hidden);
		}
		return array('status' => 'success', 'hidden' => $hidden);
	}

}
