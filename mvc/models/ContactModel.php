<?php
class ContactModel extends DB
{

    function insertContact($name, $phone, $email, $content, $created_at)
    {
        $sql = "INSERT INTO contact(name, phone, email, content, created_at) VALUES('$name', '$phone', '$email', '$content', '$created_at')";
        return $this->pdo_execute_lastInsertID($sql);
    }

    function getAllContact($responded, $orderBy)
    {
        $select = "SELECT * FROM contact WHERE 1 ";
        if ($responded != '') {
            $select .= "AND responded IS $responded ";
        }
        if ($orderBy != '') {
            $select .= " ORDER BY created_at $orderBy";
        }
        return $this->pdo_query($select);
    }

    function respondContact($id, $responded)
    {
        $sql = "UPDATE contact SET responded = '$responded' WHERE id = '$id'";
        return $this->pdo_execute($sql);
    }
}
