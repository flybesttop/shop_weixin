<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cart extends CI_Controller {

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

	public function insertIntoCart()
	{
		$this->load->model('cartModel');
		$openId=$_POST['openId'];
		$goodsId=$_POST['goodsId'];
		$goodsSelectNum=$_POST['goodsSelectNum'];
		$goodsImg=$_POST['goodsImg'];
		$goodsMoney=$_POST['goodsMoney'];
		$goodsDelmoney=$_POST['goodsDelmoney'];
		$goodsTypeId=$_POST['goodsTypeId'];
		$goodsType=substr(substr($_POST['goodsType'],1),0,-1);
		$goodsTitle=$_POST['goodsTitle'];
		$goodsExpress=$_POST['goodsExpress'];
		$goodsAddress=$_POST['goodsAddress'];
		$storeId=$_POST['storeId'];
		$storeName=$_POST['storeName'];

		$oldCart=$this->util->toCamel($this->cartModel->findByOpenIdAndGoodsIdAndGoodsTypeIdAndStatus($openId,$goodsId,$goodsTypeId));
		if (sizeof($oldCart)>0) {
			$oldCart[0]['goodsSelectNum']+=(int)$goodsSelectNum;
			$this->cartModel->update($oldCart[0]['id'],$oldCart[0]['goodsSelectNum'],$oldCart[0]['goodsNumStatus'],$oldCart[0]['isChoose'],$oldCart[0]['status']);
		}else{
			$q=$this->cartModel->insert($openId,$goodsId,$goodsSelectNum,$goodsImg,$goodsMoney,$goodsDelmoney,$goodsTypeId,$goodsType,$goodsTitle,$goodsExpress,$goodsAddress,$storeId,$storeName);
		}

		echo "加入购物车成功";

	}

	public function deleteCartGoods()
	{
		$cartId=$_POST['cartId'];
		$this->load->model('cartModel');
		$cartEntity=$this->util->toCamel($this->cartModel->findById($cartId));
		$cartEntity[0]['isChoose']=0;
		$cartEntity[0]['status']=0;
		$this->cartModel->update($cartEntity[0]['id'],$cartEntity[0]['goodsSelectNum'],$cartEntity[0]['goodsNumStatus'],$cartEntity[0]['isChoose'],$cartEntity[0]['status']);
        echo "删除成功";
	}

	public function deleteCartCheckGoods()
	{
		$openId=$_POST['openId'];
		$this->load->model('cartModel');
		$cartEntityList=$this->util->toCamel($this->cartModel->findByOpenIdAndStatusAndIsChoose($openId,1));
		
		for ($i=0; $i < sizeof($cartEntityList); $i++) { 
			$cartEntityList[$i]['status']=0;
			$this->cartModel->update($cartEntityList[$i]['id'],$cartEntityList[$i]['goodsSelectNum'],$cartEntityList[$i]['goodsNumStatus'],$cartEntityList[$i]['isChoose'],$cartEntityList[$i]['status']);
		}
        echo "删除成功";

	}

	public function addCartGoods()
	{
		$cartId=$_POST['cartId'];
		$this->load->model('cartModel');
		$cartEntity=$this->util->toCamel($this->cartModel->findById($cartId));
		$cartEntity[0]['goodsSelectNum']++;
		$this->cartModel->update($cartEntity[0]['id'],$cartEntity[0]['goodsSelectNum'],$cartEntity[0]['goodsNumStatus'],$cartEntity[0]['isChoose'],$cartEntity[0]['status']);
		echo "添加成功";
	}

	public function cutDownCartGoods()
	{
		$cartId=$_POST['cartId'];
		$this->load->model('cartModel');
		$cartEntity=$this->util->toCamel($this->cartModel->findById($cartId));
		$cartEntity[0]['goodsSelectNum']--;
		$this->cartModel->update($cartEntity[0]['id'],$cartEntity[0]['goodsSelectNum'],$cartEntity[0]['goodsNumStatus'],$cartEntity[0]['isChoose'],$cartEntity[0]['status']);
		echo "减少成功";
	}

	public function checkStore()
	{
		$openId=$_POST['openId'];
		$storeId=$_POST['storeId'];
		$storeCheck=$_POST['storeCheck'];
		$this->load->model('cartModel');
		$cartEntityList=$this->util->toCamel($this->cartModel->findByOpenIdAndStoreIdAndStatus($openId,$storeId));
		for ($i=0; $i < sizeof($cartEntityList); $i++) { 
			if ($storeCheck==1) {
				$cartEntityList[$i]['isChoose']=0;
			}else{
				$cartEntityList[$i]['isChoose']=1;
			}
			$this->cartModel->update($cartEntityList[$i]['id'],$cartEntityList[$i]['goodsSelectNum'],$cartEntityList[$i]['goodsNumStatus'],$cartEntityList[$i]['isChoose'],$cartEntityList[$i]['status']);
		}
		echo "选择成功";
	}

	public function checkCart()
	{
		$id=$_POST['cartId'];
		$this->load->model('cartModel');
		$cartEntity=$this->util->toCamel($this->cartModel->findById($id));
		$cartEntity[0]['isChoose']=abs((int)$cartEntity[0]['isChoose']-1);
		$this->cartModel->update($cartEntity[0]['id'],$cartEntity[0]['goodsSelectNum'],$cartEntity[0]['goodsNumStatus'],$cartEntity[0]['isChoose'],$cartEntity[0]['status']);
		echo "选择成功";
	}

	public function checkTotal()
	{
		$openId=$_POST['openId'];
		$totalCheck=$_POST['totalCheck'];
		$this->load->model('cartModel');
		$cartEntityList=$this->util->toCamel($this->cartModel->findByOpenIdAndStatus($openId));

		for ($i=0; $i < sizeof($cartEntityList); $i++) { 
			if ($totalCheck=='true') {
				$cartEntityList[$i]['isChoose']=0;
			}else{
				$cartEntityList[$i]['isChoose']=1;
			}
			$this->cartModel->update($cartEntityList[$i]['id'],$cartEntityList[$i]['goodsSelectNum'],$cartEntityList[$i]['goodsNumStatus'],$cartEntityList[$i]['isChoose'],$cartEntityList[$i]['status']);
		}
        echo "选择成功";
	}
}
?>