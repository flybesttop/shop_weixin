<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class userOrderGoodsModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findByOrderIdAndStatus($orderId)
	{
		$q=$this->db->query("select * from user_order_goods where order_id='$openId' and status=1 ");
		return $q->result();
	}

	public function findByOpenIdAndStatus($openId)
	{
		$q=$this->db->query("SELECT * FROM user_order_goods WHERE open_id='$openId' and status=1 ");
		return $q->result();
	}

	public function insert($orderId,$openId,$goodsId,$goodsName,$goodsImg,$goodsTypeId,$goodsType,$goodsMoney,$goodsDelmoney,$goodsNum,$goodsExpress,$goodsAddress)
	{
		$q=$this->db->query("insert into user_order_goods(order_id,open_id,goods_id,goods_name,goods_img,goods_type_id,goods_type,goods_money,goods_delmoney,goods_num,goods_express,goods_address,status,create_time) values('$orderId','$openId','$goodsId','$goodsName','$goodsImg','$goodsTypeId','$goodsType','$goodsMoney','$goodsDelmoney','$goodsNum','$goodsExpress','$goodsAddress',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$orderId,$openId,$goodsId,$goodsName,$goodsImg,$goodsTypeId,$goodsType,$goodsMoney,$goodsDelmoney,$goodsNum,$goodsExpress,$goodsAddress,$status)
	{
		$q=$this->db->query("UPDATE goods set order_id='$orderId',open_id='$openId',goods_id='$goodsId',goods_name='$goodsName',goods_img='$goodsImg',goods_type_id='$goodsTypeId',goods_type='$goodsType',goods_money='$goodsMoney',goods_delmoney='$goodsDelmoney',goods_num='$goodsNum',goods_express='$goodsExpress',goods_address='$goodsAddress',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

}

?>