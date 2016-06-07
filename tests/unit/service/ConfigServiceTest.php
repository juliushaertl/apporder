<?php

namespace OCA\AppOrder\Tests\Unit\Service;

use OCA\AppOrder\Service\ConfigService;
use OCP\IConfig;

class ConfigServiceTest extends \Test\TestCase {

  private $config;
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
//    $this->service->setAppValue("foo","bar");
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
