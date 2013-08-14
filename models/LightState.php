<?php
/**
 * Contains the model definition for "LightState."
 *
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package hue-php-toolkit
 * @version 0.2
 * @license LGPL v3
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
  protected $is_on = true;

  /**
   * The brightness of the light.
   * Possible values: 0-255
   *
   * @var int
   */
  protected $brightness = 0;

  /**
   * The hue of the light.
   * Possible values: 0-65535
   *
   * @var int
   */
  protected $hue;

  /**
   * The saturation of the light.
   *
   * @var int
   */
  protected $saturation = 0;

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
  protected $color_mode = "hs";

  /**
   * How long it should take to change to this state.
   *
   * @var int
   */
  protected $transition_time;

  /*
   * Certain fields must be limited to certain values in the setters. If new, valid options are added to the API, they
   * must be added to these arrays for the input to be accepted as valid.
   */
  private $alert_values = array("none", "select", "lselect");
  private $color_mode_values = array("xy", "ct", "hs");
  private $effect_values = array("none", "colorloop");

  /**
   * The standard 141 HTML named colors and their hex values.
   *
   * @var array
   */
  private $named_colors = array(
        'aliceblue'=>'F0F8FF',
        'antiquewhite'=>'FAEBD7',
        'aqua'=>'00FFFF',
        'aquamarine'=>'7FFFD4',
        'azure'=>'F0FFFF',
        'beige'=>'F5F5DC',
        'bisque'=>'FFE4C4',
        'black'=>'000000',
        'blanchedalmond '=>'FFEBCD',
        'blue'=>'0000FF',
        'blueviolet'=>'8A2BE2',
        'brown'=>'A52A2A',
        'burlywood'=>'DEB887',
        'cadetblue'=>'5F9EA0',
        'chartreuse'=>'7FFF00',
        'chocolate'=>'D2691E',
        'coral'=>'FF7F50',
        'cornflowerblue'=>'6495ED',
        'cornsilk'=>'FFF8DC',
        'crimson'=>'DC143C',
        'cyan'=>'00FFFF',
        'darkblue'=>'00008B',
        'darkcyan'=>'008B8B',
        'darkgoldenrod'=>'B8860B',
        'darkgray'=>'A9A9A9',
        'darkgreen'=>'006400',
        'darkgrey'=>'A9A9A9',
        'darkkhaki'=>'BDB76B',
        'darkmagenta'=>'8B008B',
        'darkolivegreen'=>'556B2F',
        'darkorange'=>'FF8C00',
        'darkorchid'=>'9932CC',
        'darkred'=>'8B0000',
        'darksalmon'=>'E9967A',
        'darkseagreen'=>'8FBC8F',
        'darkslateblue'=>'483D8B',
        'darkslategray'=>'2F4F4F',
        'darkslategrey'=>'2F4F4F',
        'darkturquoise'=>'00CED1',
        'darkviolet'=>'9400D3',
        'deeppink'=>'FF1493',
        'deepskyblue'=>'00BFFF',
        'dimgray'=>'696969',
        'dimgrey'=>'696969',
        'dodgerblue'=>'1E90FF',
        'firebrick'=>'B22222',
        'floralwhite'=>'FFFAF0',
        'forestgreen'=>'228B22',
        'fuchsia'=>'FF00FF',
        'gainsboro'=>'DCDCDC',
        'ghostwhite'=>'F8F8FF',
        'gold'=>'FFD700',
        'goldenrod'=>'DAA520',
        'gray'=>'808080',
        'green'=>'008000',
        'greenyellow'=>'ADFF2F',
        'grey'=>'808080',
        'honeydew'=>'F0FFF0',
        'hotpink'=>'FF69B4',
        'indianred'=>'CD5C5C',
        'indigo'=>'4B0082',
        'ivory'=>'FFFFF0',
        'khaki'=>'F0E68C',
        'lavender'=>'E6E6FA',
        'lavenderblush'=>'FFF0F5',
        'lawngreen'=>'7CFC00',
        'lemonchiffon'=>'FFFACD',
        'lightblue'=>'ADD8E6',
        'lightcoral'=>'F08080',
        'lightcyan'=>'E0FFFF',
        'lightgoldenrodyellow'=>'FAFAD2',
        'lightgray'=>'D3D3D3',
        'lightgreen'=>'90EE90',
        'lightgrey'=>'D3D3D3',
        'lightpink'=>'FFB6C1',
        'lightsalmon'=>'FFA07A',
        'lightseagreen'=>'20B2AA',
        'lightskyblue'=>'87CEFA',
        'lightslategray'=>'778899',
        'lightslategrey'=>'778899',
        'lightsteelblue'=>'B0C4DE',
        'lightyellow'=>'FFFFE0',
        'lime'=>'00FF00',
        'limegreen'=>'32CD32',
        'linen'=>'FAF0E6',
        'magenta'=>'FF00FF',
        'maroon'=>'800000',
        'mediumaquamarine'=>'66CDAA',
        'mediumblue'=>'0000CD',
        'mediumorchid'=>'BA55D3',
        'mediumpurple'=>'9370D0',
        'mediumseagreen'=>'3CB371',
        'mediumslateblue'=>'7B68EE',
        'mediumspringgreen'=>'00FA9A',
        'mediumturquoise'=>'48D1CC',
        'mediumvioletred'=>'C71585',
        'midnightblue'=>'191970',
        'mintcream'=>'F5FFFA',
        'mistyrose'=>'FFE4E1',
        'moccasin'=>'FFE4B5',
        'navajowhite'=>'FFDEAD',
        'navy'=>'000080',
        'oldlace'=>'FDF5E6',
        'olive'=>'808000',
        'olivedrab'=>'6B8E23',
        'orange'=>'FFA500',
        'orangered'=>'FF4500',
        'orchid'=>'DA70D6',
        'palegoldenrod'=>'EEE8AA',
        'palegreen'=>'98FB98',
        'paleturquoise'=>'AFEEEE',
        'palevioletred'=>'DB7093',
        'papayawhip'=>'FFEFD5',
        'peachpuff'=>'FFDAB9',
        'peru'=>'CD853F',
        'pink'=>'FFC0CB',
        'plum'=>'DDA0DD',
        'powderblue'=>'B0E0E6',
        'purple'=>'800080',
        'red'=>'FF0000',
        'rosybrown'=>'BC8F8F',
        'royalblue'=>'4169E1',
        'saddlebrown'=>'8B4513',
        'salmon'=>'FA8072',
        'sandybrown'=>'F4A460',
        'seagreen'=>'2E8B57',
        'seashell'=>'FFF5EE',
        'sienna'=>'A0522D',
        'silver'=>'C0C0C0',
        'skyblue'=>'87CEEB',
        'slateblue'=>'6A5ACD',
        'slategray'=>'708090',
        'slategrey'=>'708090',
        'snow'=>'FFFAFA',
        'springgreen'=>'00FF7F',
        'steelblue'=>'4682B4',
        'tan'=>'D2B48C',
        'teal'=>'008080',
        'thistle'=>'D8BFD8',
        'tomato'=>'FF6347',
        'turquoise'=>'40E0D0',
        'violet'=>'EE82EE',
        'wheat'=>'F5DEB3',
        'white'=>'FFFFFF',
        'whitesmoke'=>'F5F5F5',
        'yellow'=>'FFFF00',
        'yellowgreen'=>'9ACD32');

  /**
   * Sets the alert effect. Must be "none", "select", or "lselect".
   *
   * @param string $alert
   */
  public function setAlert($alert) {
    if(in_array($alert, $this->alert_values)) {
      $this->alert = $alert;
    }
  }

  /**
   * Gets this state's alert effect.
   *
   * @return string
   */
  public function getAlert() {
    return $this->alert;
  }

  /**
   * Sets the brightness of this light state. Must be an int between 0-255 or a float between 0-1. Note that 0 does not
   * mean off but the dimmest possible setting for the bulb that still gives off light. Use ->setIsOn(false) to completely
   * turn off the light.
   *
   * @param mixed $brightness
   */
  public function setBrightness($brightness) {
    $this->brightness = $brightness;
  }

  /**
   * Gets the brightness of this light state.
   *
   * @return int Value between 0-255
   */
  public function getBrightness() {
    return $this->brightness;
  }

  /**
   * Sets the color mode to use (some fields will be ignored depending on mode).
   * Options: "ct" (color temperature), "xy" (XY space), "hs" (hue/saturation)
   *
   * @param string $color_mode
   */
  public function setColorMode($color_mode) {
    if(in_array($color_mode, $this->color_mode_values)) { // Verify new value against enum array
      $this->color_mode = $color_mode;
    }
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
   * Converts this LightState into a JSON array formatted specifically for the Hue API.
   *
   * @return string
   */
  public function toApiJson() {
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

  /**
   * Sets a hex color for the light. This will change the "color_mode", "hue", "brightness", and "saturation" fields, as
   * the method works by setting their value, not by natively passing the hex code to the bulb.
   *
   * Standard Hue bulbs seem to have a difficult time with colors near cyan (#00FFFF). Grayness also is also translated
   * into dimness, so, for example, #888888 is white at medium brightness, not a medium gray.
   *
   * The color will be accurate in sense that it accurately translates the hex into its equivalent to the best of the
   * bulb's ability, but the bulbs simply aren't designed to reproduce the full RGB color gamut.
   *
   * @param string $color
   * @return boolean Whether it successfully converted the hex code.
   */
  public function setHexCode($color) {
    // Strip out the leading hashtag if there
    if(substr($color, 0, 1) == "#") $color = substr($color, 1);

    // If we don't now have 6 digits, we have a problem
    if(strlen($color) != 6) return false;

    // Get our red, blue, and green values in fractional form
    $red = ((float) hexdec(substr($color, 0, 2)))/255;
    $blue = ((float) hexdec(substr($color, 4, 2)))/255;
    $green = ((float) hexdec(substr($color, 2, 2)))/255;

    // we need these later
    $highest = max($red, $green, $blue);
    $diff = $highest - min($red, $green, $blue);

    // We want the light to be as bright as our brightest individual color.
    $brightness = $highest;

    // Calculate our saturation as well as values used in the hue formula
    if($diff == 0) {
      $base = 0;
      $delta = 0;
      $saturation = 0;
    } else {
      $saturation = $diff / $highest;
      $base = 0;
      $delta = 0;

      switch($highest) {
        case $red:
          $base = 0;
          $delta = ($green-$blue)/($diff*2);
          break;
        case $green:
          $base = 25500; // Pure green, per the documentation
          $delta = ($blue-$red)/($diff*2);
          break;
        case $blue:
          $base = 46920; // Pure blue, per the documentation
          $delta = ($red-$green)/($diff*2);
          break;
      }
    }

    // Correction for red-dominant purples to a positive value above blue instead of a negative value below red
    if($delta < 0) {
      $base = 46920;
      $delta = (1 + $delta);
    }

    // Determine the conversion value for our delta value
    if($base < 2) $scaling = 25500; // Red-dominant colors occupy 38.910505836% of Hue's color space
    elseif($base < 4) $scaling = 21420; // Green-dominant colors occupy 32.684824902% of Hue's color space
    else $scaling = 18615; // Blue-dominant colors occupy 28.40466926% of Hue's color space

    // Determine our appropriately-scaled hue value
    $this->hue = (int) ($base + ($delta * $scaling));

    // Scale up our brightness and saturation to the right units
    $this->saturation = (int) ($saturation * 255);
    $this->brightness = (int) ($brightness * 255);

    return true;
  }

  /**
   * Sets the state to one of the 141 named HTML colors. Can include spaces or be in any case combination.  This will
   * change the "color_mode", "hue", "brightness", and "saturation" fields, as the method works by setting their value,
   * not by natively passing the color to the bulb.
   *
   * This works a lot better with some colors than others. Standard Hue bulbs seem to suck at rendering colors in the
   * cyan/aqua range in general (even in the official app), and darkness gets translated into dimness, so "dark red"
   * is really more like "dim red" and "light gray" is more like "dim white".
   *
   * The color will be accurate in sense that it accurately translates the name into the W3C-standard equivalent to the
   * best of the bulb's ability, but the bulbs simply aren't designed to reproduce the full RGB color gamut.
   *
   * @param string $color
   * @return bool Whether the color name was accepted.
   */
  public function setNamedColor($color) {
    // Make sure we have the best shot of matching a name in our array
    $color = strtolower(str_replace(array("-", " ", "_"), "", $color));

    if(isset($this->named_colors[$color])) {
      $this->setHexCode($this->named_colors[$color]);

      return true;
    }

    return false;
  }
}