<?php
namespace M2;

class account_info extends \Database {

	// public function showData($search = null, $sort = null) {
	// 	$this->orderby('account','asc','id','desc');
	// 	$sql = "SELECT * from account_info";
	// 	if ($search != null) {
	// 		// $sql.="where ";
	// 		$s_d = [
	// 			"account like '%$search%'",
	// 			"user_name like '%$search%'",
	// 			"gender like '%$search%'",
	// 			"birth like '%$search%'",
	// 			"email like '%$search%'",
	// 			"remark like '%$search%'",
	// 		];
	// 		$this->where(implode(' or ',$s_d));
	// 	}
	// 	$this->tableCol('id','account','user_name','birth','gender');
	// 	$data = $this->query();
	// 	if (empty($data))
	// 		return [];
	// 	foreach ($data as $k => $v) {
	// 		$data[$k]['birth'] = date("Y年m月d日", strtotime($v['birth']));
	// 		$data[$k]['gender'] = $v['gender'] == '0' ? '男' : '女';
	// 	}

	// 	return $data;
	// }

	// function CreatData(array $data = []) {
	// 	if (empty($data))
	// 		return false;
	// 	$this->begin();
	// 	$ins = $this->insert('account_info', $data);
	// 	if ($ins === false) {
	// 		$this->rollback();
	// 		return false;
	// 	}
	// 	$this->commit();
	// 	return true;
	// }

	// function UpdateData($ids, array $data = []) {
	// 	if (empty($data))
	// 		return false;
	// 	$temp = [];
	// 	foreach ($data as $k => $v) {
	// 		if (!empty($data[$k]) || strlen($data[$k]) > 0) {
	// 			array_push($temp, "{$k}='{$v}'");
	// 		} else {
	// 			unset($data[$k]);
	// 		}
	// 	}
	// 	$sql = "UPDATE account_info set " . implode(',', $temp) . " where id IN({$ids})";
	// 	// echo $sql;
	// 	$this->begin();
	// 	$ins = $this->execute($sql);
	// 	if ($ins === false) {
	// 		$this->rollback();
	// 		return false;
	// 	}
	// 	$this->commit();
	// 	return true;
	// }

	// function DeleteData($ids) {
	// 	$sql = "DELETE from account_info where id IN({$ids})";
	// 	// echo $sql;
	// 	$this->begin();
	// 	$ins = $this->execute($sql);
	// 	if ($ins === false) {
	// 		$this->rollback();
	// 		return false;
	// 	}
	// 	$this->commit();
	// 	return true;
	// }
}
