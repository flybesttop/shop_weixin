<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class collection extends CI_Controller {

	private $util;

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/   
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->util=new utilHelper();
	}

	public function selectCollection()
	{
		$openId=$_POST['openId'];
		$toId=$_POST['toId'];
		$type=$_POST['type'];
		$this->load->model('collectionModel');
		$dataLists=$this->util->toCamel($this->collectionModel->countByOpenIdAndToIdAndTypeAndStatus($openId,$toId,$type));
		if (sizeof($dataLists)==1) {
			echo "true";
		}else{
			echo "false";
		}
	}

	public function deleteCollection()
	{
		$openId=$_POST['openId'];
		$toId=$_POST['toId'];
		$type=$_POST['type'];
		$this->load->model('collectionModel');
		$dataLists=$this->util->toCamel($this->collectionModel->findByOpenIdAndToIdAndTypeAndStatus($openId,$toId,$type));
		$dataLists[0]['status']=0;
		$this->collectionModel->update($dataLists[0]['id'],$dataLists[0]['type'],$dataLists[0]['toId'],$dataLists[0]['openId'],$dataLists[0]['status']);
		echo "删除成功";
	}

	public function insertCollection()
	{
		$openId=$_POST['openId'];
		$toId=$_POST['toId'];
		$type=$_POST['type'];
		$this->load->model('collectionModel');
		$this->load->model('goodsModel');
		$this->load->model('storeModel');
		$collectionEntity=$this->util->toCamel($this->collectionModel->findByOpenIdAndToIdAndTypeAndStatus($openId,$toId,$type));
		if (sizeof($collectionEntity)>0) {
			$collectionEntity[0]['status']=0;
			$this->collectionModel->update($collectionEntity[0]['id'],$collectionEntity[0]['type'],$collectionEntity[0]['toId'],$collectionEntity[0]['openId'],$collectionEntity[0]['status']);
		}else{
			if ($type==1) {
				$storeEntity=$this->util->toCamel($this->storeModel->findByIdAndStatus($toId));
				$storeEntity[0]['storeLike']++;
				$this->storeModel->update($storeEntity[0]['id'],$storeEntity[0]['storeName'],$storeEntity[0]['storeContext'],$storeEntity[0]['storeHeadImg'],$storeEntity[0]['storeLike'],$storeEntity[0]['storeView'],$storeEntity[0]['status']);
			}else{
				$goodsEntity=$this->util->toCamel($this->goodsModel->findByIdAndStatus($toId));
				$goodsEntity[0]['goodsLike']++;
				$this->goodsModel->update($goodsEntity[0]['id'],$goodsEntity[0]['goodsSales'],$goodsEntity[0]['goodsLike'],$goodsEntity[0]['goodsView'],$goodsEntity[0]['status']);
			}
			$q=$this->collectionModel->insert($type,$toId,$openId);
		}
		echo "添加成功";
	}
}
?>