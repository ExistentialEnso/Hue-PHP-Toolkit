<?php
/**
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package hue-php-toolkit
 * @version 0.2
 * @license LGPL v3
 */

namespace hue\models;


class User {
  protected $username;

  protected $device_type;

  protected $id;

  /**
   * @param mixed $device_type
   */
  public function setDeviceType($device_type) {
    $this->device_type = $device_type;
  }

  /**
   * @return mixed
   */
  public function getDeviceType() {
    return $this->device_type;
  }

  /**
   * @param mixed $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param mixed $username
   */
  public function setUsername($username) {
    $this->username = $username;
  }

  /**
   * @return mixed
   */
  public function getUsername() {
    return $this->username;
  }
}