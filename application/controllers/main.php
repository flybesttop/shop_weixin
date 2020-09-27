<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main extends CI_Controller {

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

	public function getFootPoint()
	{
		$openId=$_POST['openId'];
		$this->load->model('footPointModel');
		$this->load->model('goodsModel');
		$footMessage=array();
		$dataLists=$this->util->toCamel($this->footPointModel->findRecentTwoDay($openId));
		// var_dump($dataLists);
		for ($i=0; $i < sizeof($dataLists); $i++) { 
			$goodsEntityList=$this->util->toCamel($this->goodsModel->findRecentTwoDayFootPoint($openId,$dataLists[$i]['visitData']));
			$message = array(
	            "date" => $dataLists[$i]['visitData'],
	            "footGoods" => $goodsEntityList
	        );
	        array_push($footMessage, $message);
		}
		$allmessage = array(
            "footMessage" => $footMessage
        );
        echo json_encode($allmessage);

	}

	public function selectGoods()
	{
		$keyWords=$_POST['keyWords'];
		$page=$_POST['page'];
		$this->load->model('goodsModel');
		$goodsEntities=$this->util->toCamel($this->goodsModel->selectGoods("%".$keyWords."%",$page*4));
		$goodsNum=$this->util->toCamel($this->goodsModel->selectGoodsNum("%".$keyWords."%"));
		// var_dump($goodsNum);
		$totalPage=(int)((int)$goodsNum[0]['COUNT(distinct a.id)']/4);
		if ((int)((int)$goodsNum[0]['COUNT(distinct a.id)']%4)>0) {
			$totalPage++;
		}
		$allmessage = array(
            "selectGoodsMessage" => $goodsEntities,
            "totalPage" => $totalPage
        );
        echo json_encode($allmessage);

	}

	public function prolist()
	{
		$this->load->model('prolistModel');
		$prolistEntityList=$this->util->toCamel($this->prolistModel->findLevel1());
		$prolistEntityHot=$this->util->toCamel($this->prolistModel->findhot1());

		$allmessage = array(
            "prolistEntityList" => $prolistEntityList,
            "prolistEntityHot" => $prolistEntityHot
        );
        echo json_encode($allmessage);

	}

	public function getMyOrder()
	{
		$openId=$_POST['openId'];
		$orderType=$_POST['orderType'];
		$this->load->model('otherModel');
		$this->load->model('userOrderGoodsModel');
		if ($orderType!=0) {
			$userOrderUtilList=$this->util->toCamel($this->otherModel->getMyOrder1($orderType,$openId));
		}else{
			$userOrderUtilList=$this->util->toCamel($this->otherModel->getMyOrder2($openId));
		}
		$userOrderGoodsEntities=$this->util->toCamel($this->userOrderGoodsModel->findByOpenIdAndStatus($openId));
		$allmessage = array(
            "orderMessage" => $userOrderUtilList,
            "orderGoodsMessage" => $userOrderGoodsEntities
        );
		echo json_encode($allmessage);
	}

	public function cart()
	{
		$openId=$_POST['openId'];
		$this->load->model('otherModel');
		$this->load->model('cartModel');
		$cartGoodsUtilList=$this->util->toCamel($this->otherModel->getAllCartMessage($openId));
		for ($i=0; $i < sizeof($cartGoodsUtilList); $i++) { 
			if ($cartGoodsUtilList[$i]['goodsNum']==0) {
				$cart=$this->util->toCamel($this->cartModel->findById($cartGoodsUtilList[$i]['id']));
				$cart[0]['goodsNumStatus']=0;
				$this->cartModel->update($cartGoodsUtilList[$i]['id'],$cartGoodsUtilList[$i]['goodsSelectNum'],$cartGoodsUtilList[$i]['goodsNumStatus'],$cartGoodsUtilList[$i]['isChoose'],1);
			}
		}
		echo json_encode($cartGoodsUtilList);
	}

	public function collection()
	{
		$openId=$_POST['openId'];
		$type=$_POST['type'];
		$this->load->model('goodsModel');
		$this->load->model('storeModel');
		if ($type==1) {
			$collectionList=$this->util->toCamel($this->storeModel->selectStoresByCollection($openId));
		}else if ($type==2) {
			$collectionList=$this->util->toCamel($this->goodsModel->selectGoodsByCollection($openId));
		}
		echo json_encode($collectionList);
	}

	public function address()
	{
		$openId=$_POST['openId'];
		$this->load->model('addressModel');
		$addressEntityList=$this->util->toCamel($this->addressModel->findAllByOpenIdAndStatus($openId));
		echo json_encode($addressEntityList);
	}

	public function index()
	{
		$this->load->model('goodsModel');
		$this->load->model('storeModel');
		// $this->util->toCamel($this->storeModel->selectHotStores());
		$goodsListIndex=$this->util->toCamel($this->goodsModel->selectGoodsIndex());
		$salesBest=$this->util->toCamel($this->goodsModel->selectBestSale());
		$niceGoods=$this->util->toCamel($this->goodsModel->selectNiceGoods());
		$hotStore=$this->util->toCamel($this->storeModel->selectHotStores());

		$allmessage = array(
            "goodsListIndex" => $goodsListIndex,
            "salesBest" => $salesBest,
            "niceGoods" => $niceGoods,
            "hotStore"=>$hotStore
        );

        echo json_encode($allmessage);
	}

	public function store()
	{
		$this->load->model('storeModel');
		$this->load->model('goodsModel');
		$this->load->model('storeImgModel');
		$storeId=$_POST['storeId'];
		$store=$this->util->toCamel($this->storeModel->findByIdAndStatus($storeId));
		// var_dump($store);
		$store[0]['storeLike']++;
		$this->storeModel->update($store[0]['id'],$store[0]['storeName'],$store[0]['storeContext'],$store[0]['storeHeadImg'],$store[0]['storeLike'],$store[0]['storeView'],1);
		$goodsList=$this->util->toCamel($this->goodsModel->findByStoreIdAndStatus($storeId));
		$storeImgList=$this->util->toCamel($this->storeImgModel->findByStoreIdAndStatus($storeId));
		$allmessage = array(
            "goodsList" => $goodsList,
            "store" => $store,
            "storeImgList" => $storeImgList
        );
        echo json_encode($allmessage);
	}

	public function goods()
	{
		$this->load->model('footPointModel');
		$this->load->model('goodsModel');
		$this->load->model('goodsImgModel');
		$this->load->model('storeModel');
		$this->load->model('goodsTypeModel');
		$this->load->model('goodsTypeUnionModel');
		$goodsId=$_POST['goodsId'];
		if ($_POST['openId']!='') {
			$oldFoot=$this->util->toCamel($this->footPointModel->findByOpenIdAndGoodsIdAndStatus($_POST['openId'],$goodsId));
			if (sizeof($oldFoot)!=0) {
				$this->footPointModel->update($oldFoot[0]['id'],$oldFoot[0]['openId'],$oldFoot[0]['goodsId'],1);
			}else{
				$footId=$this->footPointModel->insert($_POST['openId'],$goodsId);
			}
		}

		$goods=$this->util->toCamel($this->goodsModel->findByIdAndStatus($goodsId));
		$goods[0]['goodsView']++;
		$this->goodsModel->update($goods[0]['id'],$goods[0]['goodsSales'],$goods[0]['goodsLike'],$goods[0]['goodsView'],1);
		$goodsSlideImgList=$this->util->toCamel($this->goodsImgModel->findByGoodsIdAndImgTypeAndStatus($goodsId,1));
		$goodsDetilImgList=$this->util->toCamel($this->goodsImgModel->findByGoodsIdAndImgTypeAndStatus($goodsId,2));
		$store=$this->util->toCamel($this->storeModel->findByIdAndStatus($goods[0]['storeId']));
		$goodsTypeListLevel1=$this->util->toCamel($this->goodsTypeModel->findAllByFromIdAndStatusAndLevel($goodsId,1));
		$goodsTypeUnionEntityList=$this->util->toCamel($this->goodsTypeUnionModel->findAllByGoodsIdAndStatus($goodsId));

		$goodsTypeList=array();
		for ($i=0; $i < sizeof($goodsTypeListLevel1); $i++) { 
			$goodsType = array(
	            "typeId" => $goodsTypeListLevel1[$i]['id'],
	            "typeName" => $goodsTypeListLevel1[$i]['goodsType'],
	            "goodsTypeListLevel2" => $this->util->toCamel($this->goodsTypeModel->findAllByFromIdAndStatusAndLevel($goodsTypeListLevel1[$i]['id'],2))
        	);
        	array_push($goodsTypeList, $goodsType);
		}

		$allmessage = array(
            "goods" => $goods,
            "store" => $store,
            "goodsSlideImgList" => $goodsSlideImgList,
            "goodsDetilImgList" => $goodsDetilImgList,
            "goodsTypeList" => $goodsTypeList,
            "goodsTypeUnionList" => $goodsTypeUnionEntityList
        );

        echo json_encode($allmessage);
	}
}
?>