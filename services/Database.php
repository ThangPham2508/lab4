<?php
class Database
{
    private $mysqli;

    public function __construct($host, $user, $password, $database)
    {
        $this->mysqli = new mysqli($host, $user, $password, $database);

        if ($this->mysqli->connect_error) {
            die(json_encode(array('message' => 'Connection failed: ' . $this->mysqli->connect_error)));
        }
    }
    public function getConnection() {
        return $this->mysqli;
      }

    public function query($sql)
    {
        return $this->mysqli->query($sql);
    }

    public function close()
    {
        mysqli_close($this->mysqli);
    }
}
?>
