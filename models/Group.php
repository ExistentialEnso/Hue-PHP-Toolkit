<?php
/**
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package hue-php-toolkit
 * @version 0.2
 * @license LGPL v3
 */

namespace hue\models;

/**
 * Model class representing a group of lights.
 *
 * @package hue\models
 */
class Group {
  /**
   * The unique ID of this group of lights.
   *
   * @var int
   */
  protected $id;

  /**
   * The name of this group of lights
   *
   * @var string
   */
  protected $name;

  /**
   * The lights in this group.
   *
   * @var array
   */
  protected $lights;

  /**
   * The bridge this group is on.
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
   * @param array $lights
   */
  public function setLights($lights) {
    $this->lights = $lights;
  }

  /**
   * Adds a light to this group.
   *
   * @param $light
   */
  public function addLight($light) {
    $this->lights[] = $light;
  }

  /**
   * @return array
   */
  public function getLights() {
    return $this->lights;
  }

  /**
   * Sets all Lights in this Group to the provided LightState.
   *
   * @param LightState $state
   */
  public function setState($state) {
    foreach($this->lights as $light) {
      $light->setState($state);
    }
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


}