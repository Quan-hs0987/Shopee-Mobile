<?php 
    class Cart {
        public $db = null;

        public function __construct(DBController $db) {
            if (!isset($db->conn)) {
                return null;
            }
            $this->db = $db;
        }

        public function insertIntoCart($params = null, $table = "cart") {
            if ($this->db->conn != null) {
                if ($params != null) {
                    $columns = implode(',', array_keys($params));
                    $values = implode(',', array_values($params));
                    $query_string = sprintf("INSERT INTO %s(%s) VALUES(%s)", $table, $columns, $values);
                    $result = $this->db->conn->query($query_string);
                    return $result;
                }
            }
            return false; // Trả về false nếu không có tham số hoặc kết nối cơ sở dữ liệu không tồn tại
        }
        
        public function addToCart($userid, $itemid) {
            if (isset($userid) && isset($itemid)) {
                $params = array(
                    "user_id" => $userid,
                    "item_id" => $itemid
                );
                $result = $this->insertIntoCart($params);
                if ($result) {
                    // Chuyển hướng người dùng về trang hiện tại
                    header("Location: ".$_SERVER['PHP_SELF']);
                }
            }
        }

        public function deleteCart($item_id = null, $table = 'cart'){
            if($item_id != null){
                $result = $this->db->conn->query("DELETE FROM {$table} WHERE item_id={$item_id}");
                if($result){
                    header("Location: ".$_SERVER['PHP_SELF']);
                }
                return $result;
            }
        }
        

        public function getSum($arr){
            if (isset($arr)){
                $sum = 0;
                foreach ($arr as $item ){
                    $sum += floatval($item[0]);
                }
                return sprintf('%.2f', $sum);
            }
        }
        
        // get item in shopee cart
        public function getCartId($cartArray = null, $key = 'item_id'){
            if ($cartArray != null){
                $cart_id = array_map(function($value) use ($key){
                    return $value[$key];
                }, $cartArray);
                return $cart_id;
            }
        }

        public function saveForLater($item_id = null, $saveTable = 'wishlist', $fromTable = 'cart'){
            if ($item_id != null){
                $query = "INSERT INTO $saveTable SELECT * FROM $fromTable WHERE item_id = ?";
                $stmt = $this->db->conn->prepare($query);
                $stmt->bind_param("i", $item_id);
                $stmt->execute();
                
                $query = "DELETE FROM $fromTable WHERE item_id = ?";
                $stmt = $this->db->conn->prepare($query);
                $stmt->bind_param("i", $item_id);
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) {
                    header("Location: ".$_SERVER['PHP_SELF']);
                } else {
                    return false;
                }
            }
        }
        
    }
?>