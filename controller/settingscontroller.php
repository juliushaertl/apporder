<?php

namespace OCA\AppOrder\Controller;

use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\IRequest;
use \OCP\INavigationManager;
use \OCA\AppOrder\Service\ConfigService;

class SettingsController extends Controller{

    private $userId;
    private $l10n;
    private $appConfig;
    private $navigationManager;

    public function __construct($appName, IRequest $request, ConfigService $appConfig, INavigationManager $navigationManager, $userId){
        parent::__construct($appName, $request);
        $this->userId = $userId;
        $this->appConfig = $appConfig;
        $this->navigationManager = $navigationManager;
    }

    public function adminIndex(){
        $navigation = $this->navigationManager->getAll();
        $order = json_decode($this->appConfig->getAppValue('order'));
        $nav = $this->matchOrder($navigation, $order);
        return new TemplateResponse(
            $this->appName, 
            'admin',
            ["nav" => $nav],
            'blank'
        );
    }

    public function getAppOrder() {
        $order_user = $this->appConfig->getUserValue('order', $this->userId);
        $order_default = $this->appConfig->getAppValue('order');
        if ($order_user !== null && $order_user !== "")
            $order = $order_user;
        else
            $order = $order_default;
        return $order;
    }

    public function matchOrder($nav, $order) {
        $nav_tmp = array();
        $result = array();
        foreach($nav as $app)
            $nav_tmp[$app['href']] = $app;
        foreach($order as $app)
            $result[$app] = $nav_tmp[$app];
        foreach($nav as $app)
            if(!array_key_exists($app['href'], $result))
                $result[$app['href']] = $app;
        return $result;
    }

    /**
     * @NoAdminRequired
     */
    public function getOrder(){
        $order = $this->getAppOrder();
        return array('status' => 'success', 'order' => $order);
    }

    /**
     * @NoAdminRequired
     */
    public function savePersonal($order){
        $this->appConfig->setUserValue('order', $this->userId, $order);
        $response = array(
            'status' => 'success',
            'data' => array('message'=> 'User order saved successfully.'),
            'order' => $order
        );
        return $response;
    }

    public function saveDefaultOrder($order){
        if (!is_null($order)){
            $this->appConfig->setAppValue('order',$order);
        }
        return array('status' => 'success', 'order' => $order);
    }
}
