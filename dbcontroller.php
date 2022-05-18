<?php
class DBController
{
    public $mConnector;
    public $order_by_keys = array("maker_name", "car_name", "car_type", "frame_number", "first_entry_date", "mileage", "out_color_name", "shift_cd", "sale_price");
    public $sort_order_keys = array("asc", "desc");
    function __construct($conn)
    {
        $this->mConnector = $conn;
    }

    public function login($email, $password) {
        $returnArr = [];
        $sql = "select * from t_user where email=:email";
        $stmt = $this->mConnector->prepare($sql);
        $stmt->bindParam(":email",$email);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if (md5($password)==$result["password"]) {
                $returnArr["user_mail"] = $email;
            } else {
                $returnArr["password_error"] = "パスワードを正しく入力して下さい。";
            }
        } else {
            $returnArr["mail_error"] = "ユーザーが存在ではありません。";
        }
        var_dump($returnArr);
        return $returnArr;
    }

    // Search, Sort, GetAll >> all combined
    public function searchTCars($index, $limit, $keyword = null, $carNumber = null, $order_by = null, $sort_order = null)
    {
        $sql = "SELECT * from t_car_base ";

        if ($keyword || $carNumber) {
            $sql .= "where ";
        }
        if ($keyword) {
            $sql .= "(maker_name like :mname or car_name like :cname) ";
        }
        if ($carNumber) {
            if ($keyword) {
                $sql .= "and ";
            }
            $sql .= "frame_number like :fnumber ";
        }
        
        if ($order_by && $sort_order) {
            if (!in_array($order_by, $this->order_by_keys) || !in_array($sort_order, $this->sort_order_keys)) {
                $order_by = "frame_number";
                $sort_order = "asc";
            }
            $sql .= "order by " . $order_by . " " . $sort_order;
        }

        $sql .= " LIMIT :index, :limit";

        //sql is ready, bind start
        $statement = $this->mConnector->prepare($sql);
        $statement->bindValue(":index", $index, PDO::PARAM_INT);
        $statement->bindValue(":limit", $limit, PDO::PARAM_INT);
        if ($keyword) {
            $keyParam = '%' . $keyword . '%';
            $statement->bindParam(":mname", $keyParam);
            $statement->bindParam(":cname", $keyParam);
        }
        if ($carNumber) {
            $carNumParam = '%' . $carNumber . '%';
            $statement->bindParam(":fnumber", $carNumParam);
        }
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    # get data from TCarBase By id
    public function getTCarBaseById($id)
    {
        $sql = "select * from t_car_base where id=:tid";
        $statement = $this->mConnector->prepare($sql);
        $statement->bindParam(":tid", $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    # get current searched data count
    public function getRowCount($keyword, $carNumber)
    {
        $sql = "SELECT count(*) from t_car_base ";
        if ($keyword || $carNumber) {
            $sql .= "where ";
        }
        if ($keyword) {
            $sql .= "(maker_name like :mname or car_name like :cname) ";
        }
        if ($carNumber) {
            if ($keyword) {
                $sql .= "and ";
            }
            $sql .= "frame_number like :fnumber ";
        }
        $statement = $this->mConnector->prepare($sql);
        if ($keyword) {
            $keyParam = '%' . $keyword . '%';
            $statement->bindParam(":mname", $keyParam);
            $statement->bindParam(":cname", $keyParam);
        }
        if ($carNumber) {
            $carNumParam = '%' . $carNumber . '%';
            $statement->bindParam(":fnumber", $carNumParam);
        }
        $statement->execute();
        $count = $statement->fetchColumn();
        return $count;
    }

    # get all data from MCommon
    public function getMCommonList()
    {
        $sql = "select data_type,data_cd,value1 from m_common";
        $statement = $this->mConnector->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        $m_common = array();
        foreach ($result as $value) {
            $m_common[$value["data_type"]][$value["data_cd"]] = $value["value1"];
        }
        return $m_common;
    }

    # get all data from MMaker
    public function getMMakerList()
    {
        $sql = "select id,name from m_maker";
        $statement = $this->mConnector->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    # get all data from MCarName
    public function getMCarNameList()
    {
        $sql = "select * from m_car_name";
        $statement = $this->mConnector->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    # get MMaker by Id
    public function getMMakerById($id)
    {
        $sql = "select name from m_maker where id=:id";
        $statement = $this->mConnector->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $result = $statement->fetchColumn();
        return $result;
    }

    # get MCarName by Id
    public function getMCarNameById($id)
    {
        $sql = "select name from m_car_name where id=:id";
        $statement = $this->mConnector->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $result = $statement->fetchColumn();
        return $result;
    }

    # insert into TCar
    public function insertTCar($st_cd, $maker_name, $car_name, $car_type, $frame_number, $first_entry_date, $out_color_name, $shift_cd, $shift_cnt, $shift_posi_cd, $sale_price)
    {
        $sql = "insert into t_car_base (ins_user_id, st_cd, maker_name, car_name, car_type, frame_number, first_entry_date, out_color_name, shift_cd, shift_cnt, shift_posi_cd, sale_price) values (:ins_user_id, :st_cd, :maker_name, :car_name, :car_type, :frame_number, :first_entry_date, :out_color_name, :shift_cd, :shift_cnt, :shift_posi_cd, :sale_price)";
        $statement = $this->mConnector->prepare($sql);
        $ins_user_id = 0;
        $statement->bindParam(":ins_user_id", $ins_user_id);
        $statement->bindParam(":st_cd", $st_cd);
        $statement->bindParam(":maker_name", $maker_name);
        $statement->bindParam(":car_name", $car_name);
        $statement->bindParam(":car_type", $car_type);
        $statement->bindParam(":frame_number", $frame_number);
        $statement->bindParam(":first_entry_date", $first_entry_date);
        $statement->bindParam(":out_color_name", $out_color_name);
        $statement->bindParam(":shift_cd", $shift_cd);
        $statement->bindParam(":shift_cnt", $shift_cnt);
        $statement->bindParam(":shift_posi_cd", $shift_posi_cd);
        $statement->bindParam(":sale_price", $sale_price);
        return $statement->execute();
    }

    # update row in TCar
    public function updateTCar($id, $st_cd, $maker_name, $car_name, $car_type, $frame_number, $first_entry_date, $out_color_name, $shift_cd, $shift_cnt, $shift_posi_cd, $sale_price)
    {
        $sql = "update t_car_base set st_cd = :st_cd, maker_name = :maker_name, car_name = :car_name, car_type = :car_type, frame_number = :frame_number, first_entry_date = :first_entry_date, out_color_name = :out_color_name, shift_cd = :shift_cd, shift_cnt = :shift_cnt, shift_posi_cd = :shift_posi_cd, sale_price = :sale_price where id= :id";
        $statement = $this->mConnector->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->bindParam(":st_cd", $st_cd);
        $statement->bindParam(":maker_name", $maker_name);
        $statement->bindParam(":car_name", $car_name);
        $statement->bindParam(":car_type", $car_type);
        $statement->bindParam(":frame_number", $frame_number);
        $statement->bindParam(":first_entry_date", $first_entry_date);
        $statement->bindParam(":out_color_name", $out_color_name);
        $statement->bindParam(":shift_cd", $shift_cd);
        $statement->bindParam(":shift_cnt", $shift_cnt);
        $statement->bindParam(":shift_posi_cd", $shift_posi_cd);
        $statement->bindParam(":sale_price", $sale_price);
        return $statement->execute();
    }
}
