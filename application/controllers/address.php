<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class address extends CI_Controller {

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

	public function updataDefault()
	{
		$id=$_POST['id'];
		$this->load->model('addressModel');
		$addressEntity=$this->util->toCamel($this->addressModel->findByIdAndStatus($id));
		$oldDefAddress=$this->util->toCamel($this->addressModel->findByOpenIdAndIsDefAndStatus($addressEntity[0]['openId'],1));
		var_dump($oldDefAddress);
		if (sizeof($oldDefAddress)>0) {
		$this->addressModel->update($oldDefAddress[0]['id'],$oldDefAddress[0]['openId'],$oldDefAddress[0]['username'],$oldDefAddress[0]['phone'],$oldDefAddress[0]['address'],0,$oldDefAddress[0]['shengfen'],$oldDefAddress[0]['chengshi'],$oldDefAddress[0]['qu'],1);
		}
		$this->addressModel->update($id,$addressEntity[0]['openId'],$addressEntity[0]['username'],$addressEntity[0]['phone'],$addressEntity[0]['address'],1,$addressEntity[0]['shengfen'],$addressEntity[0]['chengshi'],$addressEntity[0]['qu'],1);
		
		echo "保存成功";
	}

	public function saveAddress()
	{
		$this->load->model('addressModel');
		$id=$_POST['id'];
		var_dump($id);
		$openId=$_POST['openId'];
		$username=$_POST['username'];
		$phone=$_POST['phone'];
		$address=$_POST['address'];
		$isDef=$_POST['isDef'];
		$shengfen=$_POST['shengfen'];
		$chengshi=$_POST['chengshi'];
		$qu=$_POST['qu'];
		if ($id=="undefined") {
			$q=$this->addressModel->insert($openId,$username,$phone,$address,$isDef,$shengfen,$chengshi,$qu);
		}else{
			$this->util->toCamel($this->addressModel->update($id,$openId,$username,$phone,$address,$isDef,$shengfen,$chengshi,$qu,1));
		}

		echo "保存成功";
		
	}

	public function deleteAddress()
	{
		$id=$_POST['id'];
		$this->load->model('addressModel');
		$addressEntity=$this->util->toCamel($this->addressModel->findByIdAndStatus($id));
		$addressEntity[0]['isDef']=0;
		$addressEntity[0]['status']=0;
		$this->addressModel->update($id,$addressEntity[0]['openId'],$addressEntity[0]['username'],$addressEntity[0]['phone'],$addressEntity[0]['address'],0,$addressEntity[0]['shengfen'],$addressEntity[0]['chengshi'],$addressEntity[0]['qu'],0);
		echo "删除成功";
	}

	public function selectAddressByOpenId()
	{
		$openId=$_POST['openId'];
		$this->load->model('addressModel');
		$addressEntity=$this->util->toCamel($this->addressModel->findByOpenIdAndIsDefAndStatus($openId,1));
        echo json_encode($addressEntity[0]);
	}

	public function selectAddress()
	{
		$id=$_POST['id'];
		$this->load->model('addressModel');
		$addressEntity=$this->util->toCamel($this->addressModel->findByIdAndStatus($id));
        echo json_encode($addressEntity[0]);
	}
}
?>