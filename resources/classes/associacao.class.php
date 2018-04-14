<?php

class Associacao {
  private $id, $userid, $nutsid, $abreviatura;

  public function __construct($id, $user, $nuts, $abrev) {
    $this->id = $id;
    $this->userid = $user;
    $this->nutsid = $nuts;
    $this->abreviatura = $abrev;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_userid() {
    return $this->userid;
  }

  public function get_nutsid() {
    return $this->nutsid;
  }

  public function get_abreviatura() {
    return $this->abreviatura;
  }

}
?>
