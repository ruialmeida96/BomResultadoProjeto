<?php

class Log {
  private $id, $userid, $data, $hora,$disc;

  public function __construct($id, $user, $date, $time,$desc) {
    $this->id = $id;
    $this->userid = $user;
    $this->data = $date;
    $this->hora = $time;
    $this->disc = $desc;
  }

  public function get_id() {
    return $this->id;
  }

  public function get_userid() {
    return $this->userid;
  }

  public function get_data() {
    return $this->data;
  }

  public function get_hora() {
    return $this->hora;
  }

  public function get_disc() {
    return $this->disc;
  }
}
?>
