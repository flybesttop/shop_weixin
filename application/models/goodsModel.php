<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class goodsModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function selectGoodsIndex()
	{
		$q=$this->db->query("select * from goods where status=1 ORDER BY goods_sales DESC limit 0,6");
		return $q->result();
	}

	public function selectBestSale()
	{
		$q=$this->db->query("SELECT * FROM goods WHERE status=1 ORDER BY goods_view DESC LIMIT 0,3");
		return $q->result();
	}

	public function insert($goodHeadImg,$storeId,$goodsMoney,$goodsDelmoney,$goodsTitle,$goodsExpress,$goodsSales,$goodsArea,$goodsLike,$goodsView)
	{
		$q=$this->db->query("insert into goods(goods_head_img,store_id,goods_money,goods_delmoney,goods_title,goods_express,goods_sales,goods_area,goods_like,goods_view,status,create_time) values('$goodHeadImg','$storeId','$goodsMoney','$goodsDelmoney','$goodsTitle','$goodsExpress','$goodsSales','$goodsArea','$goodsLike','$goodsView',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$goodsSales,$goodsLike,$goodsView,$status)
	{
		$q=$this->db->query("UPDATE goods set goods_sales='$goodsSales',goods_like='$goodsLike',goods_view='$goodsView',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

	public function selectNiceGoods()
	{
		// var_dump($account);
		$q=$this->db->query("SELECT * FROM goods WHERE status=1 ORDER BY goods_like DESC LIMIT 0,2");
		return $q->result();
	}

	public function findByIdAndStatus($id)
	{
		$q=$this->db->query("SELECT * FROM goods WHERE status=1 AND id='$id'");
		return $q->result();
	}

	public function findByStoreIdAndStatus($storeId)
	{
		$q=$this->db->query("SELECT * FROM goods WHERE status=1 AND store_id='$storeId'");
		return $q->result();
	}

	public function selectGoodsByCollection($openId)
	{
		$q=$this->db->query("select a.* from goods a,collection b where a.id=b.to_id and b.type=2 and b.open_id='$openId' and a.status=1 and b.status=1");
		return $q->result();
	}

	public function selectGoods($keyWords,$pageGoodsNum)
	{
		$q=$this->db->query("SELECT distinct a.* FROM goods a,prolist_goods b WHERE (b.prolist_name LIKE '$keyWords' AND a.id=b.goods_id) or a.goods_title LIKE '$keyWords' ORDER BY a.goods_view DESC LIMIT 0,$pageGoodsNum");
		return $q->result();
	}

	public function selectGoodsNum($keyWords)
	{
		$q=$this->db->query("SELECT COUNT(distinct a.id)  FROM goods a,prolist_goods b WHERE (b.prolist_name LIKE '$keyWords' AND a.id=b.goods_id) or a.goods_title LIKE '$keyWords'");
		return $q->result();
	}

	public function findRecentTwoDayFootPoint($openId,$visitDate)
	{
		$q=$this->db->query("SELECT a.* FROM goods a,foot_point b WHERE b.open_id='$openId' AND b.visit_data='$visitDate' AND a.id=b.goods_id AND a.status=1 AND b.status=1 ORDER BY b.visit_time DESC LIMIT 0,4");
		return $q->result();
	}

	public function selectByOrderId($openId)
	{
		$q=$this->db->query("SELECT a.* FROM goods a,user_order_goods b WHERE a.status=1 AND b.status=1 AND b.order_id='$openId' AND a.id=b.goods_id");
		return $q->result();
	}

}

?>