<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class prolistModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findAllByStatus()
	{
		$q=$this->db->query("select * from prolist where status=1 ");
		return $q->result();
	}

	public function findByIdAndStatus($id)
	{
		$q=$this->db->query("select * from prolist where id='$id' and status=1 ");
		return $q->result();
	}

	public function findLevel1()
	{
		$q=$this->db->query("SELECT * FROM prolist WHERE status=1 AND prolist_level=1");
		return $q->result();
	}

	public function insert($code,$typeName,$prolistImg,$prolistLevel,$viewNum)
	{
		$q=$this->db->query("insert into prolist(code,type_name,prolist_img,prolist_level,view_num,status,create_time) values('$code','$storeId','$typeName','$prolistImg','$prolistLevel','$viewNum',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$code,$typeName,$prolistImg,$prolistLevel,$viewNum,$status)
	{
		$q=$this->db->query("UPDATE prolist set code='$code',type_name='$typeName',prolist_img='$prolistImg',prolist_level='$prolistLevel',view_num='$viewNum',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

	public function findLevel2ByCode($code)
	{
		// var_dump($account);
		$q=$this->db->query("SELECT * FROM prolist WHERE status=1 AND prolist_level=2 AND code LIKE '$code'");
		return $q->result();
	}

	public function findLevel3ByCode($code)
	{
		$q=$this->db->query("SELECT * FROM prolist WHERE status=1 AND prolist_level=3 AND code LIKE '$code'");
		return $q->result();
	}

	public function findhot1()
	{
		$q=$this->db->query("SELECT * FROM prolist WHERE status=1 AND prolist_level=3 ORDER By view_num DESC LIMIT 0,9");
		return $q->result();
	}

	public function findhot2($code)
	{
		$q=$this->db->query("SELECT * FROM prolist WHERE status=1 AND prolist_level=3 AND code LIKE '$code' ORDER BY view_num DESC LIMIT 0,9");
		return $q->result();
	}

	public function findOneByCode($code)
	{
		$q=$this->db->query("SELECT * FROM prolist WHERE status=1 AND code = '$code'");
		return $q->result();
	}

}

?>