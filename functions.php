<?php session_start(); include 'Database.php';



    public function sanitizeInput($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    public function insertUser() {
        /*PDO+OOP* */
        try {
            // 1. Claen Data
            $username = $this->sanitizeInput($name);
            $password = $this->sanitizeInput($password);
            $full_name = $this->sanitizeInput($full_name);
            $email = $this->sanitizeInput($email);
            $phone = $this->sanitizeInput($phone);
            $status = $this->sanitizeInput($status);
            // 2.Pre SQL Statement
            $sql = 


            
            
        } catch (PDOException $e) {
            echo "Failed for insert data" .$e->getMessage();
        }
        
    }







?>