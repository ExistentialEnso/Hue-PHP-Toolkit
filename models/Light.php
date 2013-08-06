<?php
/**
* @author Thorne Melcher <tmelcher@portdusk.com>
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
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $type;

  /**
   * @var LightState
   */
  protected $state;

  /**
   * @var string
   */
  protected $model_id;

  /**
   * @var string
   */
  protected $software_version;

  /**
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
   * @return string
   */
  public function getModelId() {
    return $this->model_id;
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
   * @param \hue\models\LightState $state
   */
  public function setState($state) {
    $this->state = $state;

    $data = array("on"=>$state->getIsOn(), "bri"=>$state->getBrightness(), "hue"=>$state->getHue(), "sat"=>$state->getSaturation(), "ct"=>$state->getColorTemperature(),
      "alert"=>$state->getAlert(), "effect"=>$state->getEffect(), "transitiontime"=>$state->getTransitionTime());

    foreach($data as $key=>$value) {
      if(is_null($value)) unset($data[$key]);
    }

    $data = json_encode($data);

    $ch = curl_init("http://" . $this->getBridge()->getIpAddress() . "/api/" . $this->getBridge()->getDefaultUser()->getUsername() . "/lights/" . $this->getId() . "/state");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
    $response = curl_exec($ch);

    //var_dump($response);
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