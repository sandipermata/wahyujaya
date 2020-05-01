<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Medoo/Medoo.php';
use Medoo\Medoo;

class Base {
  private $db;
  public function __construct(){
    $this->db = new Medoo(
      [ 
        'database_type' => 'mysql',
        'charset'       => 'utf8',

        /*/
        'server'        => '202.157.177.91',
        'database_name' => 'wantechs_tlight',
        'username'      => 'wantechs_tlight',
        'password'      => '2upYcu5Y97',
        /*/
        'server'        => 'localhost',
        'database_name' => 'db_traffic',
        'username'      => 'root',
        'password'      => '',
        /**/
      ]
    );
    $this->db->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function getInfo($CI_VERSION){
    $data = array(
      "server_info" => array(
        "language" => array(
          "name" => "php",
          "version" => phpversion()
        ),
        "database"  => array(
          "name"    => "Medoo",
          "version" => $this->db->info()['version'],
          "driver" => $this->db->info()['driver']
        ),
        "framework" => array(
          "name" => "CodeIgniter (CI)",
          "version" => $CI_VERSION
        )
      )
    );
    return $data;
  }

  public function db_execute($sql){
    $query = $this->db->query($sql);
    if($query){
      $hasil = array(
        "kind" => "success",
        "code" => "200",
        "status_code" => "200",
        "description" => "OK",
        "message" => "OK",
        "data" => $query->fetchAll(PDO::FETCH_ASSOC)
      );
      return $hasil;
    }else{
      $result = array(
        "kind" => "error",
        "code" => "400",
        "status_code" => "400",
        "description" => $this->db->lasterror,
        "message" => $this->db->lasterror,
        "data" => array()
      );
      return $result;
    }
  }

  public function select_all($table, $field = null){
    if($field){
      $fields = $field;
    }else{
      $fields = "*";
    }
    $query = $this->db->select($table, $fields);
    if($query){
      $hasil = array(
        "kind" => "success",
        "code" => "200",
        "status_code" => "200",
        "description" => "OK",
        "message" => "OK",
        "data" => $query
      );
      return $hasil;
    }else{
      if(count($query) < 1){
        $hasil = array(
          "kind" => "success",
          "code" => "200",
          "status_code" => "200",
          "description" => "OK",
          "message" => "OK",
          "data" => $query
        );
        return $hasil;        
      }else{        
        $result = array(
          "kind" => "error",
          "code" => "400",
          "status_code" => "400",
          "description" => $this->db->lasterror,
        "message" => $this->db->lasterror,
          "data" => array()
        );
        return $result;
      }
    }
  }

  public function select_where($table, $field = null, $where){
    if($field){
      $fields = $field;
    }else{
      $fields = "*";
    }
    $query = $this->db->select($table, $fields, $where);
    if($query){
      $hasil = array(
        "kind" => "success",
        "code" => "200",
        "status_code" => "200",
        "description" => "OK",
        "message" => "OK",
        "data" => $query
      );
      return $hasil;
    }else{
      if(count($query) < 1){
        $hasil = array(
          "kind" => "success",
          "code" => "200",
          "status_code" => "200",
          "description" => "OK",
        "message" => "OK",
          "data" => $query
        );
        return $hasil;        
      }else{        
        $result = array(
          "kind" => "error",
          "code" => "400",
          "status_code" => "400",
          "description" => $this->db->lasterror,
        "message" => $this->db->lasterror,
          "data" => array()
        );
        return $result;
      }
    }
  }

  public function select_count($table, $where=null){
    $result = $this->db->count($table, $where);
    return $result;
  }

  public function db_insert($table, $data){
    if ($this->db->insert($table, $data) ){
      $result = array(
        "kind" => "success",
        "code" => "200",
        "status_code" => "200",
        "description"  => "OK",
        "message" => "OK",
        "data" => array($data),
      );
    }else{
      $result = array(
        "kind" => "error",
        "code" => "400",
        "status_code" => "400",
        "description"  => $this->db->lasterror,
        "message" => $this->db->lasterror,
        "data" => array($data),
      );
    }
    return $result;
  }

  public function db_update($table, $data, $where){
    $put = $this->db->update($table, $data, $where);
    if ( $put ){
      if($put->rowCount() > 0){
        $result = array(
          "kind" => "success",
          "code" => "200",
          "status_code" => "200",
          "description"  => $put->rowCount() . " data updated successfully",
        "message" => $put->rowCount() . " data updated successfully",
          "data" => array($data) ,
        );
      }else{
        $result = array(
          "kind" => "success",
          "code" => "100",
          "status_code" => "100",
          "description"  => "no data updated",
          "message"  => "no data updated",
          "data" => array($data),
        );
      }
    }else{
      $result = array(
        "kind" => "error",
        "code" => "400",
        "status_code" => "400",
        "description"  => $this->db->lasterror,
          "message"  => $this->db->lasterror,
        "data" => array($data),
      );
    }
    return $result;
  }

  public function db_delete($table, $where){
    $hasil = $this->db->delete($table, $where);
    if($hasil->rowCount() > 0){
      $result = array(
        "kind" => "success",
        "code" => "200",
        "status_code" => "200",
        "description"  => $hasil->rowCount() . " data(s) deleted",
          "message"  => $hasil->rowCount() . " data(s) deleted",
        "data" => array(),
      );
    }else{
      $result = array(
        "kind" => "nope",
        "code" => "100",
        "status_code" => "100",
        "description"  => "no data deleted",
        "message"  => "no data deleted",
        "data" => array(),
      );
    }
    return $result;
  }

  public function generateSalt($cost = 13){
      $cost = (int) $cost;
      if ($cost < 4 || $cost > 31) {
          //throw new InvalidArgumentException('Cost must be between 4 and 31.');
      }

      // Get a 20-byte random string
      $rand =  random_bytes(20);
      // Form the prefix that specifies Blowfish (bcrypt) algorithm and cost parameter.
      $salt = sprintf('$2y$%02d$', $cost);
      // Append the random salt data in the required base64 format.
      $salt .= str_replace('+', '.', substr(base64_encode($rand), 0, 22));

      return $salt;
  }

  public function generatePasswordHash($password, $cost = null){
      if ($cost === null) {
          $cost = 13;
      }

      if (function_exists('password_hash')) {
          /* @noinspection PhpUndefinedConstantInspection */
          return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
      }

      $salt = $this->generateSalt($cost);
      $hash = crypt($password, $salt);
      // strlen() is safe since crypt() returns only ascii
      if (!is_string($hash) || strlen($hash) !== 60) {
          throw new Exception('Unknown error occurred while generating hash.');
      }

      return $hash;
  }

  public function validatePassword($password, $hash){
    if (!is_string($password) || $password === '') {
      throw new InvalidArgumentException('Password must be a string and cannot be empty.');
    }

    if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $hash, $matches) || $matches[1] < 4 || $matches[1] > 30) {
      throw new InvalidArgumentException('Hash is invalid.');
    }

    if (function_exists('password_verify')) {
      return password_verify($password, $hash);
    }

    $test = crypt($password, $hash);
    $n = strlen($test);
    if ($n !== 60) {
      return false;
    }
    return $this->compareString($test, $hash);
  }

  public function compareString($expected, $actual){
      if (!is_string($expected)) {
          throw new InvalidArgumentException('Expected expected value to be a string, ' . gettype($expected) . ' given.');
      }

      if (!is_string($actual)) {
          throw new InvalidArgumentException('Expected actual value to be a string, ' . gettype($actual) . ' given.');
      }

      if (function_exists('hash_equals')) {
          return hash_equals($expected, $actual);
      }

      $expected .= "\0";
      $actual .= "\0";
      $expectedLength = StringHelper::byteLength($expected);
      $actualLength = StringHelper::byteLength($actual);
      $diff = $expectedLength - $actualLength;
      for ($i = 0; $i < $actualLength; $i++) {
          $diff |= (ord($actual[$i]) ^ ord($expected[$i % $expectedLength]));
      }

      return $diff === 0;
  }

  public function baseUrl(){
    $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
    $root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    return $root;
  }

  public function base_url(){
    return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
    );
  }

  public function mymail($to, $subject, $msg, $data){
    $options['ssl']['verify_peer'] = FALSE;
    $options['ssl']['verify_peer_name'] = FALSE;

    $transport = Swift_SmtpTransport::newInstance("mail.tora.co.id",587,'tls')
    ->setUsername("bys@totallogisticsid.com")
    ->setPassword("total2015")
    ->setStreamOptions($options)
    ;

    //$ato = explode(",", json_encode($to));
    $ato = $to;
    // Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance()
    // Give the message a subject
    ->setSubject($subject)

    // Set the From address with an associative array
    ->setFrom(array("no-reply@totallogisticsid.com" => "Totallogistics"))

    // Set the To addresses with an associative array
    ->setTo($ato)
    //->setCC(array("boyke@totallogisticsid.com"))
    //->setCc(array("teguh@tora.co.id1"))
    // Give it a body
    ->setBody($msg,"text/html")
    // And optionally an alternative body
    ;

    if(!$mailer->send($message, $failures)){
      $result = array(
        "kind" => "error",
        "code" => 400,
        "message" => array($failures),
      );
    }else{
      $result = array(
        "kind" => "success",
        "code" => 200,
        "message" => "Message Sent",
      );
    }
    return $result;
  }

/*
======================================================================================================================
  RETURN THE RESPONSE WITH JSON FORMAT
*/

  public function renderJSON($hasil){
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($hasil, JSON_NUMERIC_CHECK);
    // echo json_encode($hasil);
  }

/*
  RETURN THE RESPONSE WITH JSON FORMAT
======================================================================================================================
*/


}

?>