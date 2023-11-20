<?php
class index extends Controller {
	public function home() {
		// $account_info = $this->database('account_info', 'M2');
		// $this->data = (new M2\account_info())
		// 	->tableCol('id', 'account', 'user_name', 'birth', 'gender')
		// 	->where("account like '%2%'")
		// 	->orderby('account', 'asc', 'id', 'desc')
		// 	->query();

		// $this->test = (new sms\_msg_mo())
		// 	->tableCol('id', 'company_id', 'from_num', 'handler_id', 'msg')
		// 	->orderby('id', 'desc')
		// 	->limit(0, 100)
		// 	->query();

		$this->view('index/home');
		// dd($this);
	}
}
?>