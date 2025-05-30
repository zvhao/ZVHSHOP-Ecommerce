<?php
class DB
{
    public $conn;
    public $servername = "sql113.infinityfree.com";
    public $username = "if0_37639300";
    public $password = "jMwEuWOh176Ce";
    public $dbname = "if0_37639300_zvhshop_ecommerce";

    function __construct()
    {
        $dburl = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname . ";charset=utf8";

        $this->conn = new PDO($dburl, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // return $this->conn;
    }
    /**
     * Thực thi câu lệnh sql thao tác dữ liệu (INSERT, UPDATE, DELETE)
     * @param string $sql câu lệnh sql
     * @param array $args mảng giá trị cung cấp cho các tham số của $sql
     * @throws PDOException lỗi thực thi câu lệnh
     */
    function pdo_execute($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            // $this->conn = pdo_get_connection();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            return true;
        } catch (PDOException $e) {
            throw $e;
        } finally {
            // unset($this->conn);
        }
    }
    function pdo_execute_lastInsertID($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            // $this->conn = pdo_get_connection();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        } finally {
            // unset($this->conn);
        }
    }
    /**
     * Thực thi câu lệnh sql truy vấn dữ liệu (SELECT)
     * @param string $sql câu lệnh sql
     * @param array $args mảng giá trị cung cấp cho các tham số của $sql
     * @return array mảng các bản ghi
     * @throws PDOException lỗi thực thi câu lệnh
     */
    function pdo_query($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            // $this->conn = pdo_get_connection();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            $rows = $stmt->fetchAll();
            return $rows;
        } catch (PDOException $e) {
            throw $e;
        } finally {
            // unset($this->conn);
        }
    }
    /**
     * Thực thi câu lệnh sql truy vấn một bản ghi
     * @param string $sql câu lệnh sql
     * @param array $args mảng giá trị cung cấp cho các tham số của $sql
     * @return array mảng chứa bản ghi
     * @throws PDOException lỗi thực thi câu lệnh
     */
    function pdo_query_one($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            // $this->conn = pdo_get_connection();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            throw $e;
        } finally {
            // unset($this->conn);
        }
    }
    /**
     * Thực thi câu lệnh sql truy vấn một giá trị
     * @param string $sql câu lệnh sql
     * @param array $args mảng giá trị cung cấp cho các tham số của $sql
     * @return giá trị
     * @throws PDOException lỗi thực thi câu lệnh
     */
    function pdo_query_value($sql)
    {
        $sql_args = array_slice(func_get_args(), 1);
        try {
            // $this->conn = pdo_get_connection();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($sql_args);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return array_values($row)[0];
        } catch (PDOException $e) {
            throw $e;
        } finally {
            // unset($this->conn);
        }
    }
}