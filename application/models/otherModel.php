<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class otherModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

	public function createOrderMessage($openId)
	{
		$q=$this->db->query("SELECT a.*,b.goods_num FROM cart a LEFT JOIN goods_type_union b ON a.goods_type_id=b.id WHERE a.goods_num_status=1 and a.is_choose=1 and a.status=1 and a.open_id='$openId'");
		return $q->result();
	}
	
	public function getAllCartMessage($openId)
	{
		$q=$this->db->query("SELECT a.*,b.goods_num FROM cart a LEFT JOIN goods_type_union b ON a.open_id='$openId' WHERE a.status=1 and a.goods_type_id=b.id");
		return $q->result();
	}

	public function getMyOrder1($orderType,$openId)
	{
		$q=$this->db->query("SELECT a.*,b.username,b.phone,b.address,b.shengfen,b.chengshi,b.qu FROM user_order a LEFT JOIN address b ON a.address_id=b.id WHERE a.status=1 and a.pay_status='$orderType' and a.status=1 and a.open_id='$openId' ORDER BY a.create_time DESC");
		return $q->result();
	}

	public function getMyOrder2($openId)
	{
		$q=$this->db->query("SELECT a.*,b.username,b.phone,b.address,b.shengfen,b.chengshi,b.qu FROM user_order a LEFT JOIN address b ON a.address_id=b.id WHERE a.status=1 and a.status=1 and a.open_id='$openId' ORDER BY a.create_time DESC");
		return $q->result();
	}

}

?>