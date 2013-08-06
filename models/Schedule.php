<?php
/**
* @author Thorne Melcher <tmelcher@portdusk.com>
*/

namespace hue\models;

/**
 * Represents a scheduled event to perform.
 *
 * @package hue\models
 */
class Schedule {
  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $description;

  /**
   * @var DateTime
   */
  protected $time;

  /**
   * @param string $description
   */
  public function setDescription($description) {
    $this->description = $description;
  }

  /**
   * @return string
   */
  public function getDescription() {
    return $this->description;
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
   * @param \hue\models\DateTime $time
   */
  public function setTime($time) {
    $this->time = $time;
  }

  /**
   * @return \hue\models\DateTime
   */
  public function getTime() {
    return $this->time;
  }


}