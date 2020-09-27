<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class collectionModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function countByOpenIdAndToIdAndTypeAndStatus($openId,$toId,$type)
	{
		$q=$this->db->query("select * from collection where status=1 and open_id='$openId' and to_id='$toId' and type='$type'");
		return $q->result();
	}

	public function findByOpenIdAndToIdAndTypeAndStatus($openId,$toId,$type)
	{
		$q=$this->db->query("SELECT * FROM collection WHERE open_id='$openId' and to_id='$toId' and type='$type' and status=1");
		return $q->result();
	}

	public function insert($type,$toId,$openId)
	{
		$q=$this->db->query("insert into collection(type,to_id,open_id,status,create_time) values('$type','$toId','$openId',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$type,$toId,$openId,$status)
	{
		$q=$this->db->query("UPDATE collection set type='$type',to_id='$toId',open_id='$openId',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

	public function deleteById($id)
	{
		$this->db->query("DELETE FROM collection WHERE id='$id'");
	}

}

?>