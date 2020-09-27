<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class goodsImgModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findByGoodsIdAndImgTypeAndStatus($goodsId,$imgType)
	{
		$q=$this->db->query("select * from goods_img where status=1 and img_type='$imgType' and goods_id='$goodsId'");
		return $q->result();
	}


	public function insert($goodsId,$img,$imgType)
	{
		$q=$this->db->query("insert into goods_img(goods_id,img,img_type,status,create_time) values('$goodsId','$img','$imgType',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$goodsId,$img,$imgType,$status)
	{
		$q=$this->db->query("UPDATE goods_img set goods_id='$goodsId',img='$img',img_type='$imgType',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

	
}

?>