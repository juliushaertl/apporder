<?php

namespace OCA\AppOrder\Tests\Unit\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http;
use \OCA\AppOrder\Service;
use \OCA\AppOrder\AppInfo\Application;
use \OCA\AppOrder\Controller;

class SettingsControllerTest extends \Test\TestCase {

  private $container;
  private $request;
  private $service;
  private $navigationManager;
  private $userId;
  private $appName;
  private $controller;
  private $config;
  public function setUp() {

    parent::setUp();

    $app = new \OCA\AppOrder\AppInfo\Application();
    $this->container = $app->getContainer();
    $this->request = $this->getMockBuilder('OCP\IRequest')
      ->disableOriginalConstructor()
      ->getMock();
    $this->config = $this->getMockBuilder('OCP\IConfig')
      ->disableOriginalConstructor()
      ->getMock();
    $this->service = $this->getMockBuilder('\OCA\AppOrder\Service\ConfigService')
      ->disableOriginalConstructor()
      ->getMock();
    $this->navigationManager = $this->getMockBuilder('\OCP\INavigationManager')->setMethods(['getAll', 'add', 'setActiveEntry'])
      ->disableOriginalConstructor()
      ->getMock();

    $this->userId = 'admin';
    $this->appName = 'apporder';
	  $this->util = new \OCA\AppOrder\Util($this->service, $this->userId);
    $this->controller = new \OCA\AppOrder\Controller\SettingsController(
      $this->appName, $this->request, $this->service, $this->navigationManager, $this->util,
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
    $this->service->expects($this->once())
      ->method('getAppValue')
      ->with('order')
      ->will($this->returnValue(json_encode($nav_custom)));
    $this->navigationManager->expects($this->once())
      ->method('getAll')
      ->will($this->returnValue($nav_oc));

    $result = $this->controller->adminIndex(); 
    $expected = new \OCP\AppFramework\Http\TemplateResponse(
      $this->appName, 
      'admin',
      ["nav" => $nav_final],
      'blank'
    );
    $this->assertEquals($expected, $result);
  }


  public function testGetOrder() {
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
    $order = ['/app/files/', '/app/calendar/', '/app/tasks/'];
    $result = $this->controller->getOrder();
    $expected = array('status' => 'success', 'order' => json_encode($order));
    $this->assertEquals($expected, $result);
  }

  public function testSavePersonal() {
    $order = "RANDOMORDER";
    $expected = array(
      'status' => 'success',
      'data' => array('message'=> 'User order saved successfully.'),
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
