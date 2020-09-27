<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class footPointModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findByOpenIdAndGoodsIdAndStatus($openId,$goodsId)
	{
		$q=$this->db->query("select * from foot_point where open_id='$openId' and goods_id='$goodsId' and status=1");
		return $q->result();
	}

	public function findRecentTwoDay($openId)
	{
		$q=$this->db->query("SELECT distinct visit_data FROM foot_point WHERE open_id='$openId' AND status=1 ORDER BY visit_time DESC Limit 0,2");
		return $q->result();
	}

	public function insert($openId,$goodsId)
	{
		$q=$this->db->query("insert into foot_point(open_id,goods_id,visit_time,visit_data,status,create_time) values('$openId','$goodsId','".time()."','".date("y/m/d")."',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$openId,$goodsId,$status)
	{
		$this->db->query("UPDATE foot_point set open_id='$openId',goods_id='$goodsId',visit_time='".time()."',visit_data='".date("y/m/d")."',status='$status',modified_time='".time()."' WHERE id='$id'");
	}
}
?>