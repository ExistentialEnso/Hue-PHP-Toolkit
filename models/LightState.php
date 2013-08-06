<?php
/**
 * Contains the model definition for "LightState."
 *
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package hue-php-toolkit
 * @version 0.1
 */

namespace hue\models;

/**
 * Represents a state that a given light may be in. This is distinct from the actual light information in the API so that
 * states can be saved for later use.
 *
 * @package hue\models
 */
class LightState {
  /**
   * Whether or not this light is on.
   *
   * @var bool
   */
  protected $is_on;

  /**
   * The brightness of the light.
   *
   * @var int
   */
  protected $brightness;

  /**
   * The hue of the light.
   *
   * @var int
   */
  protected $hue;

  /**
   * The saturation of the light.
   *
   * @var int
   */
  protected $saturation;

  /**
   * The light's X position in CIE color space.
   *
   * @var float
   */
  protected $color_space_x;

  /**
   * The light's Y position in CIE color space.
   *
   * @var float
   */
  protected $color_space_y;

  /**
   * The temperature of the light.
   *
   * @var int
   */
  protected $color_temperature;

  /**
   * Temporary change to the bulb's state.
   * Values: none, select, lselect
   *
   * @var string
   */
  protected $alert;

  /**
   * Setting to "colorloop" makes light loop through hues for the current saturation and brighness.
   * Default: "none"
   *
   * @var string
   */
  protected $effect;

  /**
   * The current mode the light is using to determine color.
   * Values: xy, ct, hs
   *
   * @var string
   */
  protected $color_mode;

  /**
   * How long it should take to change to this state.
   *
   * @var int
   */
  protected $transition_time;

  /*
   * Certain fields must be limited to certain values in the setters.
   */
  private $alert_values = array("none", "select", "lselect");
  private $color_mode_values = array("xy", "ct", "hs");
  private $effect_values = array("none", "colorloop");

  /**
   * @param string $alert
   */
  public function setAlert($alert) {
    $this->alert = $alert;
  }

  /**
   * @return string
   */
  public function getAlert() {
    return $this->alert;
  }

  /**
   * @param int $brightness
   */
  public function setBrightness($brightness) {
    $this->brightness = $brightness;
  }

  /**
   * @return int
   */
  public function getBrightness() {
    return $this->brightness;
  }

  /**
   * @param string $color_mode
   */
  public function setColorMode($color_mode) {
    $this->color_mode = $color_mode;
  }

  /**
   * @return string
   */
  public function getColorMode() {
    return $this->color_mode;
  }

  /**
   * @param float $color_space_x
   */
  public function setColorSpaceX($color_space_x) {
    $this->color_space_x = $color_space_x;
  }

  /**
   * @return float
   */
  public function getColorSpaceX() {
    return $this->color_space_x;
  }

  /**
   * @param float $color_space_y
   */
  public function setColorSpaceY($color_space_y) {
    $this->color_space_y = $color_space_y;
  }

  /**
   * @return float
   */
  public function getColorSpaceY() {
    return $this->color_space_y;
  }

  /**
   * @param int $color_temperature
   */
  public function setColorTemperature($color_temperature) {
    $this->color_temperature = $color_temperature;
  }

  /**
   * @return int
   */
  public function getColorTemperature() {
    return $this->color_temperature;
  }

  /**
   * @param string $effect
   */
  public function setEffect($effect) {
    if(in_array($effect, $this->effect_values)) { // Verify new value against enum array
      $this->effect = $effect;
    }
  }

  /**
   * @return string
   */
  public function getEffect() {
    return $this->effect;
  }

  /**
   * @param int $hue
   */
  public function setHue($hue) {
    $this->hue = $hue;
  }

  /**
   * @return int
   */
  public function getHue() {
    return $this->hue;
  }

  /**
   * @param boolean $is_on
   */
  public function setIsOn($is_on) {
    $this->is_on = $is_on;
  }

  /**
   * @return boolean
   */
  public function getIsOn() {
    return $this->is_on;
  }

  /**
   * Sets the saturation value for the light. Must be either an integer from 0-255 or a float between 0-1.
   *
   * @param mixed $saturation
   */
  public function setSaturation($saturation) {
    if(is_float($saturation)) $saturation = ($saturation * 255);

    if($saturation < 0 || $saturation > 255) return;

    $this->saturation = $saturation;
  }

  /**
   * Gets the saturation value for the light.
   *
   * @return int The saturation (0-255).
   */
  public function getSaturation() {
    return $this->saturation;
  }

  /**
   * @param int $transition_time
   */
  public function setTransitionTime($transition_time) {
    $this->transition_time = $transition_time;
  }

  /**
   * @return int
   */
  public function getTransitionTime() {
    return $this->transition_time;
  }

  /**
   * Converts this LightState into a JSON array formatted for the Hue API.
   *
   * @return string
   */
  public function toApiJson()
  {
    $params = array();

    // Map our data to their less human-friendly naming format
    $params["on"] = $this->getIsOn();
    $params["bri"] = $this->getBrightness();
    $params["hue"] = $this->getHue();
    $params["sat"] = $this->getSaturation();
    $params["xy"] = $this->getColorSpaceX() . ".." . $this->getColorSpaceY();
    $params["ct"] = $this->getColorTemperature();
    $params["alert"] = $this->getAlert();
    $params["effect"] = $this->getEffect();
    $params["transitiontime"] = $this->getTransitionTime();

    return json_encode($params);
  }
}