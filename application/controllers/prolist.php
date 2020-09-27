<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class prolist extends CI_Controller {

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

	public function chooseProlist()
	{
		$prolistId=$_POST['prolistId'];
		$this->load->model('prolistModel');
		$prolistEntity=$this->util->toCamel($this->prolistModel->findByIdAndStatus($prolistId));
		$prolistEntityList2=$this->util->toCamel($this->prolistModel->findLevel2ByCode($prolistEntity[0]['code']."%"));
		$prolistLevel2List=array();
		for ($i=0; $i < sizeof($prolistEntityList2); $i++) { 
			$prolistEntityList3=$this->util->toCamel($this->prolistModel->findLevel3ByCode($prolistEntityList2[$i]['code']."%"));
			$message = array(
	            "message" => $prolistEntityList2[$i],
	            "prolist" => $prolistEntityList3
	        );
	        array_push($prolistLevel2List, $message);
		}
		$prolistEntityHot=$this->util->toCamel($this->prolistModel->findhot2($prolistEntity[0]['code']."%"));
		$allmessage = array(
            "prolistMessage" => $prolistLevel2List,
            "prolistEntityHot" => $prolistEntityHot
        );
 		echo json_encode($allmessage);
	}

	public function insertProlistView()
	{
		$prolistId=$_POST['prolistId'];
		$this->load->model('prolistModel');
		
		$ppp=$this->util->toCamel($this->prolistModel->findByIdAndStatus($prolistId));
		$ppp[0]['viewNum']++;
		$this->prolistModel->update($ppp[0]['id'],$ppp[0]['code'],$ppp[0]['typeName'],$ppp[0]['prolistImg'],$ppp[0]['prolistLevel'],$ppp[0]['viewNum'],$ppp[0]['status']);

		$pp=$this->util->toCamel($this->prolistModel->findOneByCode(substr($ppp[0]['code'], 0,4)));
		$pp[0]['viewNum']++;
		$this->prolistModel->update($pp[0]['id'],$pp[0]['code'],$pp[0]['typeName'],$pp[0]['prolistImg'],$pp[0]['prolistLevel'],$pp[0]['viewNum'],$pp[0]['status']);

		$p=$this->util->toCamel($this->prolistModel->findOneByCode(substr($ppp[0]['code'], 0,2)));
		$p[0]['viewNum']++;
		$this->prolistModel->update($p[0]['id'],$p[0]['code'],$p[0]['typeName'],$p[0]['prolistImg'],$p[0]['prolistLevel'],$p[0]['viewNum'],$p[0]['status']);

		echo "访问量添加成功";
	}

	public function selectHotProlist()
	{
		$this->load->model('prolistModel');
		$prolistEntityHot=$this->util->toCamel($this->prolistModel->findhot1());


		$allmessage = array(
            "prolistEntityHot" => $prolistEntityHot
        );
        echo json_encode($allmessage);
	}
}
?>