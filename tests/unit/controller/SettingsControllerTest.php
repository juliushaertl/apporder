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

namespace OCA\AppOrder\Tests\Unit\Controller;

use OCA\AppOrder\Controller\SettingsController;
use OCA\AppOrder\Service\ConfigService;
use OCA\AppOrder\Util;
use OCP\IConfig;
use OCP\INavigationManager;
use OCP\IRequest;

class SettingsControllerTest extends \PHPUnit_Framework_TestCase {

	/** @var IRequest|\PHPUnit_Framework_MockObject_MockObject */
	private $request;
	/** @var ConfigService|\PHPUnit_Framework_MockObject_MockObject */
	private $service;
	/** @var INavigationManager|\PHPUnit_Framework_MockObject_MockObject */
	private $navigationManager;
	/** @var string */
	private $userId;
	/** @var string */
	private $appName;
	/** @var SettingsController */
	private $controller;
	/** @var IConfig|\PHPUnit_Framework_MockObject_MockObject */
	private $config;
	/** @var Util */
	private $util;

	public function setUp() {

		parent::setUp();
		$this->request = $this->getMockBuilder('OCP\IRequest')
			->disableOriginalConstructor()
			->getMock();
		$this->config = $this->getMockBuilder('OCP\IConfig')
			->disableOriginalConstructor()
			->getMock();
		$this->service = $this->getMockBuilder('\OCA\AppOrder\Service\ConfigService')
			->disableOriginalConstructor()
			->getMock();
		$this->navigationManager = $this->getMockBuilder('\OCP\INavigationManager')
			->setMethods(['getAll', 'add', 'setActiveEntry'])
			->disableOriginalConstructor()
			->getMock();

		$this->userId = 'admin';
		$this->appName = 'apporder';
		$this->util = new Util($this->service, $this->userId);
		$this->controller = new SettingsController(
			$this->appName,
			$this->request,
			$this->service,
			$this->navigationManager,
			$this->util,
			$this->userId
		);

	}

	public function testAdminIndex() {
		$nav_custom = ['/app/calendar/', '/app/tasks/'];
		$nav_oc = [
			['href' => '/app/files/', 'name' => 'Files'],
			['href' => '/app/calendar/', 'name' => 'Calendar'],
			['href' => '/app/tasks/', 'name' => 'Tasks'],
		];
		$nav_final = [
			'/app/calendar/' => $nav_oc[1], '/app/tasks/' => $nav_oc[2], '/app/files/' => $nav_oc[0]
		];
		$hidden = ["/app/calendar/"];
		$this->service->expects($this->at(0))
			->method('getAppValue')
			->with('order')
			->will($this->returnValue(json_encode($nav_custom)));
		$this->service->expects($this->at(1))
			->method('getAppValue')
			->with('hidden')
			->will($this->returnValue(json_encode($hidden)));
		$this->navigationManager->expects($this->once())
			->method('getAll')
			->will($this->returnValue($nav_oc));

		$result = $this->controller->adminIndex();
		$expected = new \OCP\AppFramework\Http\TemplateResponse(
			$this->appName,
			'admin',
			["nav" => $nav_final, 'type' => 'admin', 'hidden' => $hidden],
			'blank'
		);
		$this->assertEquals($expected, $result);
	}

	public function testPersonalIndex() {
		$nav_custom = ['/app/calendar/', '/app/tasks/'];
		$nav_oc = [
			['href' => '/app/files/', 'name' => 'Files'],
			['href' => '/app/calendar/', 'name' => 'Calendar'],
			['href' => '/app/tasks/', 'name' => 'Tasks'],
		];
		$nav_final = [
			'/app/calendar/' => $nav_oc[1], '/app/tasks/' => $nav_oc[2], '/app/files/' => $nav_oc[0]
		];
		$hidden = ["/app/calendar/"];
		$this->service->expects($this->at(0))->method('getUserValue')
			->with('order', 'admin')
			->will($this->returnValue(json_encode($nav_custom)));
		$this->service->expects($this->at(1))->method('getUserValue')
			->with('hidden', 'admin')
			->will($this->returnValue(json_encode($hidden)));
		$this->navigationManager->expects($this->once())
			->method('getAll')
			->will($this->returnValue($nav_oc));

		$result = $this->controller->personalIndex();
		$expected = new \OCP\AppFramework\Http\TemplateResponse(
			$this->appName,
			'admin',
			["nav" => $nav_final, 'type' => 'personal', "hidden" => $hidden],
			'blank'
		);
		$this->assertEquals($expected, $result);
	}


	public function testGetOrder() {
		$nav_system = ['/app/calendar/', '/app/tasks/'];
		$nav_user = ['/app/files/', '/app/calendar/', '/app/tasks/'];

		$hidden_admin = ['/app/calender/'];
		$hidden_user = ['/app/files/'];

		$this->service->expects($this->at(0))
			->method('getUserValue')
			->with('order', $this->userId)
			->will($this->returnValue(json_encode($nav_user)));

		$this->service->expects($this->at(1))
			->method('getAppValue')
			->with('order')
			->will($this->returnValue(json_encode($nav_system)));

		$this->service->expects($this->at(2))
			->method('getUserValue')
			->with('hidden', $this->userId)
			->will($this->returnValue(json_encode($hidden_user)));

		$this->service->expects($this->at(3))
			->method('getAppValue')
			->with('hidden')
			->will($this->returnValue(json_encode($hidden_admin)));

		$order = ['/app/files/', '/app/calendar/', '/app/tasks/'];
		$hidden = ['/app/files/'];

		$result = $this->controller->getOrder();

		$expected = array('status' => 'success', 'order' => json_encode($order), 'hidden' => json_encode($hidden));

		$this->assertEquals($expected, $result);
	}

	public function testSavePersonal() {
		$order = "RANDOMORDER";
		$expected = array(
			'status' => 'success',
			'data' => array('message' => 'User order saved successfully.'),
			'order' => $order
		);
		$result = $this->controller->savePersonal($order);
		$this->assertEquals($expected, $result);
	}

	public function testSaveDefaultOrder() {
		$order = "RANDOMORDER";
		$expected = array(
			'status' => 'success',
			'order' => $order
		);
		$result = $this->controller->saveDefaultOrder($order);
		$this->assertEquals($expected, $result);
	}
}
