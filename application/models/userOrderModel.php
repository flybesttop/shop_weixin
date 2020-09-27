<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class userOrderModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findByIdAndStatus($id)
	{
		$q=$this->db->query("select * from user_order where id='$id' and  status=1 ");
		return $q->result();
	}

	public function findByIdAndStatusAndPayStatus($id,$payStatus)
	{
		$q=$this->db->query("SELECT * FROM user_order WHERE id='$id' and pay_status='$payStatus' and status=1 ");
		return $q->result();
	}

	public function insert($openId,$storeId,$storeName,$goodsTotalNum,$goodsTotalMoney,$payStatus,$express,$bill,$message,$logistics,$addressId)
	{
		$q=$this->db->query("insert into user_order(open_id,store_id,store_name,goods_total_num,goods_total_money,pay_status,express,bill,message,logistics,address_id,status,create_time) values('$openId','$storeId','$storeName','$goodsTotalNum','$goodsTotalMoney','$payStatus','$express','$bill','$message','$logistics','$addressId',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$openId,$storeId,$storeName,$goodsTotalNum,$goodsTotalMoney,$payStatus,$express,$bill,$message,$addressId,$status)
	{
		$q=$this->db->query("UPDATE user_order set open_id='$openId',store_id='$storeId',store_name='$storeName',goods_total_num='$goodsTotalNum',goods_total_money='$goodsTotalMoney',pay_status='$payStatus',express='$express',bill='$bill',message='$message',address_id='$addressId',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

}

?>