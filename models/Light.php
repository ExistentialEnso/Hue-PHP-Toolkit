<?php
/**
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package hue-php-toolkit
 * @version 0.2
 * @license LGPL v3
 */

namespace hue\models;


class Light {
  /**
   * The internal, unique ID# for this light.
   *
   * @var int
   */
  protected $id;

  /**
   * The display name for the light.
   * 
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $type;

  /**
   * The current state of the light.
   * 
   * @var LightState
   */
  protected $state;

  /**
   * The model of lightbulb.
   * 
   * @var string
   */
  protected $model_id;

  /**
   * The currently installed software on the bulb.
   * 
   * @var string
   */
  protected $software_version;

  /**
   * The bridge this light is connected to.
   * 
   * @var Bridge
   */
  protected $bridge;

  /**
   * @param int $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param string $model_id
   */
  public function setModelId($model_id) {
    $this->model_id = $model_id;
  }

  /**
   * Gets the model ID for this light. "LCT001" is a standard Hue bulb.
   *
   * @return string
   */
  public function getModelId() {
    return $this->model_id;
  }

  /**
   * Sets the name of this Light. Maxmimum 32 characters.
   *
   * @param string $name
   */
  public function setName($name) {
    if(strlen($name) > 32) $name = substr($name, 0, 32);

    $this->name = $name;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Updates the state of the light. Will push to the bridge unless optional parameter set.
   * 
   * @param \hue\models\LightState $state
   */
  public function setState($state, $skip_push=false) {
    $this->state = $state;
    
    if($skip_push) return;

    $data = array("on"=>$state->getIsOn(), "bri"=>$state->getBrightness(), "hue"=>$state->getHue(), "sat"=>$state->getSaturation(), "ct"=>$state->getColorTemperature(),
      "alert"=>$state->getAlert(), "effect"=>$state->getEffect(), "transitiontime"=>$state->getTransitionTime(), "colormode"=>$state->getColorMode());

    foreach($data as $key=>$value) {
      if(is_null($value)) unset($data[$key]);
    }

    $data = json_encode($data);

    // PUT the state into the bulb via the bridge
    $ch = curl_init("http://" . $this->getBridge()->getIpAddress() . "/api/" . $this->getBridge()->getDefaultUser()->getUsername() . "/lights/" . $this->getId() . "/state");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
    curl_exec($ch);
  }

  /**
   * @return \hue\models\LightState
   */
  public function getState() {
    return $this->state;
  }

  /**
   * @param string $type
   */
  public function setType($type) {
    $this->type = $type;
  }

  /**
   * Gets a short description of the light type. "Extended color light" is the value for a standard Hue bulb.
   *
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @param \hue\models\Bridge $bridge
   */
  public function setBridge($bridge) {
    $this->bridge = $bridge;
  }

  /**
   * @return \hue\models\Bridge
   */
  public function getBridge() {
    return $this->bridge;
  }

  /**
   * @param string $software_version
   */
  public function setSoftwareVersion($software_version) {
    $this->software_version = $software_version;
  }

  /**
   * @return string
   */
  public function getSoftwareVersion() {
    return $this->software_version;
  }


}
