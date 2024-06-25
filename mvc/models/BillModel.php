<?php
class BillModel extends DB
{

	public function insertBill($fullname, $tel, $email, $address, $note, $total, $method, $user_id, $created_at)
	{
		$insert = "INSERT INTO bills(fullname, tel, email, address, note, total, method, user_id, created_at) VALUES('$fullname', '$tel', '$email','$address', '$note','$total','$method','$user_id', '$created_at')";
		return $this->pdo_execute_lastInsertID($insert);
	}

	public function insertDetailBill($id_pro, $image, $name_pro, $price, $qty, $sub_total, $id_bill, $created_at)
	{
		$insert = "INSERT INTO detail_bill(id_pro, image, name_pro, price, qty, sub_total, id_bill, created_at) VALUES ('$id_pro','$image','$name_pro','$price','$qty','$sub_total','$id_bill','$created_at' )";

		$this->pdo_execute($insert);
	}

	public function getAllBill($status = -1, $user_id = 0, $keyword = '')
	{
		$select = "SELECT * FROM bills WHERE 1 ";
		if ($status > -1) {
			$select .= " AND status = $status ";
		}
		if ($user_id > 0) {
			$select .= " AND user_id = $user_id ";
		}
		if ($keyword  != '') {
			$select .= " AND email like '%" . $keyword . "%' OR address like '%" . $keyword . "%' OR fullname like '%" . $keyword . "%' OR method like '%" . $keyword . "%' OR tel like '%" . $keyword . "%'";
		}
		$select .= " ORDER BY created_at DESC";
		return $this->pdo_query($select);
	}
	public function getAllBillAdmin($status = -1, $keyword = '', $start, $num_per_page)
	{
		$select = "SELECT * FROM bills WHERE 1 ";
		if ($status > -1) {
			$select .= " AND status = $status ";
		}
		if ($keyword  != '') {
			$select .= " AND email like '%" . $keyword . "%' OR address like '%" . $keyword . "%' OR fullname like '%" . $keyword . "%' OR method like '%" . $keyword . "%' OR tel like '%" . $keyword . "%'";
		}
		$select .= " ORDER BY created_at DESC LIMIT $start, $num_per_page";
		return $this->pdo_query($select);
	}

	public function getDetailBill($id_bill)
	{
		$select = "SELECT * FROM detail_bill WHERE id_bill = $id_bill";
		return $this->pdo_query($select);
	}

	function updateBill($id, $status, $updated_at)
	{
		$update = "UPDATE bills SET status = '$status', updated_at = '$updated_at' WHERE id = '$id'";
		return $this->pdo_execute($update);
	}

	function SelectOneBill($id)
	{
		$select = "SELECT * FROM bills WHERE id = '$id'";
		if ($this->pdo_query_one($select)) {
			return $this->pdo_query_one($select);
		} else {
			return [];
		}
	}

	function editStatus($id, $status, $updated_at)
	{
		$sql = "UPDATE bills SET status= '$status', updated_at= '$updated_at' WHERE id= '$id' ";

		return $this->pdo_execute_lastInsertID($sql);
	}

	public function deleteBill($id)
	{
		$detele_detail_bill = "DELETE FROM detail_bill WHERE id_bill = $id";
		$detele_bill = "DELETE FROM bills WHERE id = $id";
		$this->pdo_execute($detele_detail_bill);
		return $this->pdo_execute($detele_bill);
	}

	public function sumBill()
	{
		$select = "SELECT SUM(total) FROM bills where status = 2";
		if ($this->pdo_query_one($select)) {
			return $this->pdo_query_value($select);
		} else {
			return [];
		}
	}
	public function bestSellerAll()
	{
		$select = " SELECT name_pro,SUM(qty) as tong  FROM detail_bill  GROUP BY id_pro  HAVING SUM(qty) = (SELECT MAX(tong) as tong FROM (SELECT id_pro,SUM(qty) as tong  FROM detail_bill GROUP BY id_pro) as abc)";
		return $this->pdo_query_one($select);
	}

	public function sumBillStatistical($dateStart, $dateEnd)
	{
		$select = "SELECT SUM(total) as sum FROM `bills` WHERE status = 2 AND created_at BETWEEN '$dateStart' AND '$dateEnd'";
		return $this->pdo_query_value($select);
	}

	public function countBillStatistical($dateStart, $dateEnd)
	{
		$select = "SELECT count(*) as count FROM `bills` WHERE status = 2 AND created_at BETWEEN '$dateStart' AND '$dateEnd'";
		return $this->pdo_query_value($select);
	}

	public function BillStatistical($dateStart, $dateEnd)
	{
		$select = "SELECT * FROM `bills` WHERE status = 2";

		$select .= " AND created_at BETWEEN '$dateStart' AND '$dateEnd' ORDER BY id desc";

		return $this->pdo_query($select);
	}

	public function detailBillStatistical($id)
	{
		$select = "SELECT * FROM `bills` WHERE id = '$id'";
		return $this->pdo_query_one($select);
	}

	public function boughtById($id_user, $id_pro)
	{
		$select = "SELECT detail_bill.id FROM detail_bill JOIN bills ON bills.id = detail_bill.id_bill WHERE bills.user_id = '$id_user' AND detail_bill.id_pro = '$id_pro' AND bills.status = 2";
		return $this->pdo_query($select);
	}

	public function numBuyOneProduct($id_pro)
	{
		return $this->pdo_query_value("SELECT SUM(qty) FROM `detail_bill` WHERE id_pro = $id_pro");
	}

	public function getBillByMonth($lastMonth)
	{
		$select = "SELECT SUM(total)as sumBill, COUNT(id) as countBill FROM bills WHERE STATUS = 2 and created_at LIKE '%" . $lastMonth . "%' ";
		return $this->pdo_query_one($select);
	}

	public function bestSellerByMonth($lastMonth)
	{
		$select = "SELECT id_pro, name_pro, SUM(qty) as bestSeller FROM  detail_bill JOIN bills ON detail_bill.id_bill = bills.id WHERE status = 2 AND bills.created_at like '%" . $lastMonth . "%' GROUP BY id_pro HAVING SUM(qty) = 
		(SELECT MAX(sumQty)maxSum FROM (
		SELECT SUM(qty)sumQty, bills.id, status, detail_bill.id_pro, detail_bill.name_pro, bills.created_at FROM detail_bill JOIN bills ON detail_bill.id_bill = bills.id WHERE status = 2 AND bills.created_at like '%" . $lastMonth . "%' GROUP BY id_pro) as abc)";
		return $this->pdo_query($select);
	}

	public function top5BestSeller() {
		$select = "SELECT id_pro, name_pro, detail_bill.image, detail_bill.price, total_rating, SUM(qty) as sumQty FROM detail_bill JOIN bills ON detail_bill.id_bill = bills.id JOIN products ON detail_bill.id_pro = products.id WHERE status = 2 GROUP BY id_pro ORDER BY sumQty DESC LIMIT 5";
		return $this->pdo_query($select);
	}

	public function top5Favorites() {
		$select = "SELECT id_pro, name, image, total_rating, COUNT(*)countFavorite FROM `favorite` JOIN products ON favorite.id_pro = products.id GROUP BY id_pro ORDER BY count(*) desc LIMIT 5";
		return $this->pdo_query($select);
	}
}
