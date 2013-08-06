<?php
/**
* @author Thorne Melcher <tmelcher@portdusk.com>
*/

namespace hue\models;

class Bridge {
  /**
   * The display name of the bridge.
   * 
   * @var string
   */
  protected $name;

  /**
   * @var int
   */
  protected $proxy_port;

  /**
   * @var string
   */
  protected $proxy_address;

  /**
   * The MAC Address of the bridge.
   * 
   * @var string
   */
  protected $mac_address;

  /**
   * The (internal) IP address of the bridge.
   * 
   * @var string
   */
  protected $ip_address;

  /**
   * @var string
   */
  protected $network_mask;

  /**
   * @var string
   */
  protected $gateway_ip_address;

  /**
   * Whether or not the bridge connects to your router via DHCP.
   * 
   * @var bool
   */
  protected $is_dhcp;

  /**
   * Users approved to interact with this bridge.
   * 
   * @var array
   */
  protected $whitelist;

  /**
   * The currently logged in user.
   * 
   * @var User
   */
  protected $default_user;

  public function __construct($ip_address, $username) {
    $this->ip_address = $ip_address;

    $user = new User();
    $user->setUsername($username);
    $this->default_user = $user;
  }

  /**
   * @param string $gateway_ip_address
   */
  public function setGatewayIpAddress($gateway_ip_address) {
    $this->gateway_ip_address = $gateway_ip_address;
  }

  /**
   * @return string
   */
  public function getGatewayIpAddress() {
    return $this->gateway_ip_address;
  }

  /**
   * @param string $ip_address
   */
  public function setIpAddress($ip_address) {
    $this->ip_address = $ip_address;
  }

  /**
   * @return string
   */
  public function getIpAddress() {
    return $this->ip_address;
  }

  /**
   * @param boolean $is_dhcp
   */
  public function setIsDhcp($is_dhcp) {
    $this->is_dhcp = $is_dhcp;
  }

  /**
   * @return boolean
   */
  public function getIsDhcp() {
    return $this->is_dhcp;
  }

  /**
   * @param string $mac_address
   */
  public function setMacAddress($mac_address) {
    $this->mac_address = $mac_address;
  }

  /**
   * @return string
   */
  public function getMacAddress() {
    return $this->mac_address;
  }

  /**
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param string $network_mask
   */
  public function setNetworkMask($network_mask) {
    $this->network_mask = $network_mask;
  }

  /**
   * @return string
   */
  public function getNetworkMask() {
    return $this->network_mask;
  }

  /**
   * @param string $proxy_address
   */
  public function setProxyAddress($proxy_address) {
    $this->proxy_address = $proxy_address;
  }

  /**
   * @return string
   */
  public function getProxyAddress() {
    return $this->proxy_address;
  }

  /**
   * @param int $proxy_port
   */
  public function setProxyPort($proxy_port) {
    $this->proxy_port = $proxy_port;
  }

  /**
   * @return int
   */
  public function getProxyPort() {
    return $this->proxy_port;
  }

  /**
   * @param array $whitelist
   */
  public function setWhitelist($whitelist) {
    $this->whitelist = $whitelist;
  }

  /**
   * @return array
   */
  public function getWhitelist() {
    return $this->whitelist;
  }

  /**
   * @param \hue\models\User $default_user
   */
  public function setDefaultUser($default_user) {
    $this->default_user = $default_user;
  }

  /**
   * @return \hue\models\User
   */
  public function getDefaultUser() {
    return $this->default_user;
  }

  /**
   * Gets all information about the light with a given ID# including LightState.
   * 
   * @return \hue\models\Light
   */
  public function getLight($id) {
    $url = "http://" . $this->getIpAddress() . "/api/" . $this->getDefaultUser()->getUsername() . "/lights/" . $id;

    $data = file_get_contents($url);
    $data = json_decode($data);

    $light = new Light();
    $light->setName($data->name);
    $light->setModelId($data->modelid);
    $light->setSoftwareVersion($data->swversion);

    $sdata = $data->state;
    $state = new LightState();
    $state->setIsOn($sdata->on);
    $state->setBrightness($sdata->bri);
    $state->setSaturation($sdata->sat);
    $state->setColorTemperature($sdata->ct);
    $state->setAlert($sdata->alert);
    $state->setEffect($sdata->effect);
    $state->setColorMode($sdata->colormode);

    $light->setState($state);

    return $light;
  }

  /**
   * Gets an array of all of the lights paired with this bridge. By default, this will only return Light objects with
   * IDs and names, but "fully populate" mode will get their fully info and states.
   *
   * @param bool $fully_populate
   * @return array
   */
  public function getLights($fully_populate=false) {
    $url = "http://" . $this->getIpAddress() . "/api/" . $this->getDefaultUser()->getUsername() . "/lights";

    $data = file_get_contents($url);
    $data = json_decode($data);

    $lights = array();
    foreach($data as $id => $info) {
      if($fully_populate) {
        $lights[] = $this->getLight($id);
      } else {
        $light = new Light();
        $light->setId($id);
        $light->setName($info->name);
        $light->setBridge($this);

        $lights[] = $light;
      }
    }

    return $lights;
  }

  /**
   * Turns off all the lights on the bridge.
   */
  public function setAllOff() {
    $lights = $this->getLights();

    $state = new LightState();
    $state->setIsOn(false);

    foreach($lights as $light) {
      $light->setState($state);
    }
  }

  /**
   * Set all lights on the bridge to a given state.
   * 
   * @param LightState $state
   */
  public function setAllToState($state) {
    $lights = $this->getLights();

    foreach($lights as $light) {
      $light->setState($state);
    }
  }
}
