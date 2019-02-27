<?php
    abstract class DataObject {
        protected $data = array();

        public function __construct($data) {


            foreach($data as $key => $value) {
                if(array_key_exists($key, $this->data))
                    $this->data[$key] = $value;
            }
        }



        public function getValue($field) {
            if(array_key_exists($field, $this->data)) {
                return $this->data[$field];
            } else {
                die("Field not found");
            }
        }
        
        public function setValue($field, $val) {
            
            foreach($this->data as $key => $value) {
                if(array_key_exists($field, $this->data))
                    $this->data[$field] = $val;
            }
        }    

        public function getValueEncoded($field) {
            return htmlspecialchars($this->getValue($field));
        }

        public static function connect() {
            try {
                // Pull this out for dive
                $conn = new PDO("mysql:host=localhost;dbname=uncouth;charset=utf8", "root", "warlock");
                $conn->setAttribute(PDO::ATTR_PERSISTENT, true);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }

            return $conn;
        }

        public static function disconnect($conn) {
            $conn = "";
        }
    }
?>