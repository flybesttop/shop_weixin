<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class cartModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findById($id)
	{
		$q=$this->db->query("select * from cart where id='$id'");
		return $q->result();
	}

	public function findByOpenIdAndGoodsIdAndGoodsTypeIdAndStatus($openId,$goodsId,$goodsTypeId)
	{
		$q=$this->db->query("SELECT * FROM cart WHERE open_id='$openId' and goods_type_id='$goodsTypeId' and goods_id='$goodsId' and status=1");
		return $q->result();
	}

	public function insert($openId,$goodsId,$goodsSelectNum,$goodsImg,$goodsMoney,$goodsDelmoney,$goodsTypeId,$goodsType,$goodsTitle,$goodsExpress,$goodsAddress,$storeId,$storeName)
	{
		$q=$this->db->query("insert into cart(open_id,goods_id,goods_select_num,goods_img,goods_money,goods_delmoney,goods_type_id,goods_type,goods_title,goods_express,goods_address,goods_num_status,store_id,store_name,is_choose,status,create_time) values('$openId','$goodsId','$goodsSelectNum','$goodsImg','$goodsMoney','$goodsDelmoney','$goodsTypeId','$goodsType','$goodsTitle','$goodsExpress','$goodsAddress',1,'$storeId','$storeName',0,1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$goodsSelectNum,$goodsNumStatus,$isChoose,$status)
	{
		$q=$this->db->query("UPDATE cart set goods_select_num='$goodsSelectNum',goods_num_status='$goodsNumStatus',is_choose='$isChoose',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

	public function findByOpenIdAndStoreIdAndStatus($openId,$storeId)
	{
		$q=$this->db->query("SELECT * FROM cart WHERE open_id='$openId' and store_id='$storeId' and status=1");
		return $q->result();
	}

	public function findByOpenIdAndStatus($openId)
	{
		$q=$this->db->query("SELECT * FROM cart WHERE status=1 AND open_id='$openId'");
		return $q->result();
	}

	public function findByOpenIdAndStatusAndIsChoose($openId,$isChoose)
	{
		$q=$this->db->query("SELECT * FROM cart WHERE status=1 AND open_id='$openId' and is_choose='$isChoose'");
		return $q->result();
	}

}

?>