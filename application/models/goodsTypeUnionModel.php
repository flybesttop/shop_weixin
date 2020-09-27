<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class goodsTypeUnionModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findAllByGoodsIdAndStatus($goodsId)
	{
		$q=$this->db->query("select * from goods_type_union where goods_id='$goodsId' and status=1 ");
		return $q->result();
	}

	public function findByIdAndStatus($id)
	{
		$q=$this->db->query("SELECT * FROM goods_type_union WHERE id='$id' and status=1 ");
		return $q->result();
	}

	public function insert($goodsId,$unionId,$unionName,$goodsNum,$goodsMoney,$goodsSales,$goodsDelmoney,$goodsImg)
	{
		$q=$this->db->query("insert into goods_type_union(goods_id,union_id,union_name,goods_num,goods_money,goods_sales,goods_delmoney,goods_img,status,create_time) values('$goodsId','$unionId','$unionName','$goodsNum','$goodsMoney','$goodsSales','$goodsDelmoney','$goodsImg',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$goodsNum,$goodsSales,$status)
	{
		$q=$this->db->query("UPDATE goods_type_union set goods_num='$goodsNum',goods_sales='$goodsSales',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

}

?>