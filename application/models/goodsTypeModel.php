<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class goodsTypeModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findAllByFromIdAndStatusAndLevel($fromId,$level)
	{
		$q=$this->db->query("select * from goods_type where from_id='$fromId' and level='$level' and status=1");
		return $q->result();
	}

	public function insert($fromId,$level,$goodsType)
	{
		$q=$this->db->query("insert into goods_type(from_id,level,goods_type,status,create_time) values('$fromId','$level','$goodsType',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$fromId,$level,$goodsType,$status)
	{
		$q=$this->db->query("UPDATE goods_type set from_id='$fromId',level='$level',goods_type='$goodsType',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

}

?>