<?php
date_default_timezone_set('PRC');
/**
 * 
 */
class storeModel extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

	public function findByIdAndStatus($id)
	{
		$q=$this->db->query("select * from store where status=1 and id='$id'");
		return $q->result();
	}
	
	public function selectHotStores()
	{
		$q=$this->db->query("select * from store where status=1 ORDER BY store_like DESC LIMIT 0,2");
		return $q->result();
	}

	public function selectStoresByCollection($openId)
	{
		$q=$this->db->query("select a.* from store a,collection b where a.id=b.to_id and b.type=1 and b.open_id='$openId' and a.status=1 and b.status=1");
		return $q->result();
	}

	public function insert($storeName,$storeContext,$storeHeadImg,$storeLike,$storeView)
	{
		$q=$this->db->query("insert into store(store_name,store_context,store_head_img,store_like,store_view,status,create_time) values('$storeName','$storeContext','$storeHeadImg','$storeLike','$storeView',1,'".time()."')");
		return $this->db->insert_id();
	}

	public function update($id,$storeName,$storeContext,$storeHeadImg,$storeLike,$storeView,$status)
	{
		// var_dump($account);
		$this->db->query("UPDATE store set store_name='$storeName',store_context='$storeContext',store_head_img='$storeHeadImg',store_like='$storeLike',store_view='$storeView',status='$status',modified_time='".time()."'  where id='$id'");
	}
}

?>