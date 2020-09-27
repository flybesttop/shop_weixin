<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class addressModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	
	public function findByIdAndStatus($id)
	{
		$q=$this->db->query("select * from address where status=1 and id='$id'");
		return $q->result();
	}

	public function findAllByOpenIdAndStatus($openId)
	{
		$q=$this->db->query("SELECT * FROM address WHERE open_id='$openId' and status=1");
		return $q->result();
	}

	public function findByOpenIdAndIsDefAndStatus($openId,$isDef)
	{
		$q=$this->db->query("SELECT * FROM address WHERE open_id='$openId'and is_def='$isDef' and status=1");
		return $q->result();
	}

	public function insert($openId,$username,$phone,$address,$isDef,$shengfen,$chengshi,$qu)
	{
		$q=$this->db->query("insert into address(open_id,username,phone,address,is_def,shengfen,chengshi,qu,status,create_time) values('$openId','$username','$phone','$address','$isDef','$shengfen','$chengshi','$qu','1','".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$openId,$username,$phone,$address,$isDef,$shengfen,$chengshi,$qu,$status)
	{
		$q=$this->db->query("UPDATE address set open_id='$openId',username='$username',phone='$phone',address='$address',is_def='$isDef',shengfen='$shengfen',chengshi='$chengshi',qu='$qu',status='$status',modified_time='".time()."' WHERE id='$id'");
	}

}

?>