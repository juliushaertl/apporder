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
use \OCA\AppOrder\Util;

class UtilTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var ConfigService
	 */
  private $service;
  private $userId;
  private $util;
  private $config;
  public function setUp() {

    parent::setUp();

    $this->config = $this->getMockBuilder('OCP\IConfig')
      ->disableOriginalConstructor()
      ->getMock();
    $this->service = $this->getMockBuilder('\OCA\AppOrder\Service\ConfigService')
      ->disableOriginalConstructor()
      ->getMock();
    $this->userId = 'admin';
    $this->util = new Util($this->service, $this->userId);

  }

  public function testMatchOrder() {
    $nav = [
      ['href' => '/app/files/', 'name' => 'Files'],
      ['href' => '/app/calendar/', 'name' => 'Calendar'],
      ['href' => '/app/tasks/', 'name' => 'Tasks'],
    ];
    $order = ['/app/calendar/', '/app/tasks/'];
    $result = $this->util->matchOrder($nav, $order);
    $expected = [
      '/app/calendar/' => ['href' => '/app/calendar/', 'name' => 'Calendar'],
      '/app/tasks/' => ['href' => '/app/tasks/', 'name' => 'Tasks'],
      '/app/files/' => ['href' => '/app/files/', 'name' => 'Files'],
    ];
    $this->assertEquals($expected, $result);
  }

  public function testGetAppOrder() {
    $nav_system = ['/app/calendar/', '/app/tasks/'];
    $nav_user = ['/app/files/', '/app/calendar/', '/app/tasks/'];
    $this->service->expects($this->once())
      ->method('getAppValue')
      ->with('order')
      ->will($this->returnValue(json_encode($nav_system)));
    $this->service->expects($this->once())
      ->method('getUserValue')
      ->with('order', $this->userId)
      ->will($this->returnValue(json_encode($nav_user)));
    $result = $this->util->getAppOrder();
    $this->assertEquals(json_encode($nav_user), $result);
  }

  public function testGetAppOrderNoUser() {
    $nav_system = ['/app/calendar/', '/app/tasks/'];
    $nav_user = '';
    $this->service->expects($this->once())
      ->method('getAppValue')
      ->with('order')
      ->will($this->returnValue(json_encode($nav_system)));
    $this->service->expects($this->once())
      ->method('getUserValue')
      ->with('order', $this->userId)
      ->will($this->returnValue($nav_user));
    $result = $this->util->getAppOrder();
    $this->assertEquals(json_encode($nav_system), $result);
  }

}
