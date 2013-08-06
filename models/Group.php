<?php
/**
* @author Thorne Melcher <tmelcher@portdusk.com>
*/

namespace hue\models;


class Group {
  /**
   * @var string
   */
  protected $name;

  /**
   * @var array
   */
  protected $lights;

  /**
   * @param array $lights
   */
  public function setLights($lights) {
    $this->lights = $lights;
  }

  /**
   * @return array
   */
  public function getLights() {
    return $this->lights;
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


}