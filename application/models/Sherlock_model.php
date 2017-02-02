<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sherlock_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function init($appKey)
  {
    $this->db->where('appKey', $appKey);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if(!$service) return 'error';
    else return $service->token;
  }

  function compare_fingerprint($datas)
  {
    $this->db->where('email', $datas['email']);
    $this->db->from('user');
    $user = $this->db->get()->row();

    if(!$user) return 'no user';

    $user_id = $user->user_id;

    $this->db->where('user_id', $user_id);
    $this->db->from('fingerprint');
    $fingerprints = $this->db->get()->result();

    if(!$fingerprints) return 'no fingerprint';

    // ntbf db에서 threshold 값 불러와야하는데..
    $max_score = 0;
    foreach ($fingerprints as $fingerprint)
    {

    }



  }

  function signup($datas)
  {
    $this->db->where('token', $datas['token']);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if(!$service)
    {
      return array('error', 'token error');
    }

    $tname = $service->tname;
    $mix = $service->mix;

    $this->db->where('email', $datas['email']);
    $this->db->from($tname);
    $user = $this->db->get()->row();

    if($user)
    {
      return array('error', 'email exist');
    }

    $this->db->set('email', $datas['email']);
    $this->db->set('password', $datas['password']);
    $this->db->set('pin', $datas['pin']);
    foreach ($datas['fps'] as $key => $value) {
      $this->db->set($key, $value);
    }
    $this->db->set('reg_date', 'NOW()', FALSE);
    $res = $this->db->insert($tname);

    if($res) return array('ok', 'ok');
    else return array('error', 'db fail');
  }

  function login($datas)
  {
    $this->db->where('token', $datas['token']);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if(!$service)
    {
      return 'token error';
    }

    $tname = $service->tname;
    $mix = $service->mix;
    $thresh_1 = $service->thresh_1;
    $thresh_2 = $service->thresh_2;

    $this->db->where('email', $datas['email']);
    $this->db->from($tname);
    $user = $this->db->get()->row();

    if(!$user) return array('error', 'no user');

    if($datas['loginType'] == 'email')
    {
      $weight = json_decode(WEIGHT);

      $score = 0;
      $i = 0;
      foreach ($datas['fps'] as $key => $value) {
        if($user->$key == $value)
        {
          $score += $weight[$i];
        }
        $i++;
      }
      if($score > $thresh_1) return array('ok', 'ok');
      else if($score > $thresh_2) return array('move', 'to pin');
      else return array('move', 'to pwd');
    }
    else if($datas['loginType'] == 'pin')
    {
      if($user->pin == $datas['pin']) return array('ok', 'ok');
      else return array('move', 'to pwd');
    }
    else if($datas['loginType'] == 'password')
    {
      if($user->password == $datas['password']) return array('ok', 'ok');
      else return array('error', 'password wrong');
    }
    else
    {
      return array('error', 'no loginType');
    }
  }



}
