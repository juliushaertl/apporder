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

namespace OCA\AppOrder\Tests\Unit\Service;

use OCA\AppOrder\Service\ConfigService;
use OCP\IConfig;

class ConfigServiceTest extends \PHPUnit_Framework_TestCase {

	/** @var IConfig|\PHPUnit_Framework_MockObject_MockObject */
	private $config;
	/** @var ConfigService */
	private $service;

	public function setUp() {
		$this->config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		$this->service = new ConfigService($this->config, 'apporder');
	}

	public function testAppValue() {
		$this->config->expects($this->any())
			->method('getAppValue')
			->with('apporder', 'foo')
			->willReturn('bar');
		$result = $this->service->getAppValue("foo");
		$this->assertEquals('bar', $result);
	}

	public function testUserValue() {
		$this->config->expects($this->any())
			->method('getUserValue')
			->with('user', 'apporder', 'foo')
			->willReturn('bar');
		$this->service->setUserValue("foo", "user", "bar");
		$result = $this->service->getUserValue("foo", "user");
		$this->assertEquals('bar', $result);
	}

}
