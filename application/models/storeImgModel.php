<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class storeImgModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findByStoreIdAndStatus($storeId)
	{
		$q=$this->db->query("select * from store_img where store_id='$storeId' and status=1 ");
		return $q->result();
	}

	// public function insert($goodHeadImg,$storeId,$goodsMoney,$goodsDelmoney,$goodsTitle,$goodsExpress,$goodsSales,$goodsArea,$goodsLike,$goodsView)
	// {
	// 	$q=$this->db->query("insert into goods(goods_head_img,store_id,goods_money,goods_delmoney,goods_title,goods_express,goods_sales,goods_area,goods_like,goods_view,status,create_time) values('$goodHeadImg','$storeId','$goodsMoney','$goodsDelmoney','$goodsTitle','$goodsExpress','$goodsSales','$goodsArea','$goodsLike','$goodsView',1,'".time()."')");
	// 	return $this->db->insert_id();
	// }

	// public function update($id,$goodHeadImg,$storeId,$goodsMoney,$goodsDelmoney,$goodsTitle,$goodsExpress,$goodsSales,$goodsArea,$goodsLike,$goodsView,$status)
	// {
	// 	$q=$this->db->query("UPDATE goods set good_head_img='$goodHeadImg',store_id='$storeId',goods_money='$goodsMoney',goods_delmoney='$goodsDelmoney',goods_title='$goodsTitle',goods_express='$goodsExpress',goods_sales='$goodsSales',goods_area='$goodsArea',goods_like='$goodsLike',goods_view='$goodsView',status='$status',modified_time='".time()."' WHERE id='$id'");
	// }
}
?>