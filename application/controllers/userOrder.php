<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userOrder extends CI_Controller {

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

	public function sureGetOrder()
	{
		$orderId=$_POST['orderId'];
		$this->load->model('userOrderModel');
		$userOrderEntity=$this->util->toCamel($this->userOrderModel->findByIdAndStatusAndPayStatus($orderId,2));
		$userOrderEntity[0]['payStatus']=3;
		$this->userOrderModel->update($userOrderEntity[0]['id'],$userOrderEntity[0]['openId'],$userOrderEntity[0]['storeId'],$userOrderEntity[0]['storeName'],$userOrderEntity[0]['goodsTotalNum'],$userOrderEntity[0]['goodsTotalMoney'],$userOrderEntity[0]['payStatus'],$userOrderEntity[0]['express'],$userOrderEntity[0]['bill'],$userOrderEntity[0]['message'],$userOrderEntity[0]['addressId'],$userOrderEntity[0]['status']);
		echo "收货成功";
	}

	public function deleteOrder()
	{
		$orderId=$_POST['orderId'];
		$this->load->model('userOrderModel');
		$userOrderEntity=$this->util->toCamel($this->userOrderModel->findByIdAndStatusAndPayStatus($orderId,4));
		$userOrderEntity[0]['status']=0;
		$this->userOrderModel->update($userOrderEntity[0]['id'],$userOrderEntity[0]['openId'],$userOrderEntity[0]['storeId'],$userOrderEntity[0]['storeName'],$userOrderEntity[0]['goodsTotalNum'],$userOrderEntity[0]['goodsTotalMoney'],$userOrderEntity[0]['payStatus'],$userOrderEntity[0]['express'],$userOrderEntity[0]['bill'],$userOrderEntity[0]['message'],$userOrderEntity[0]['addressId'],$userOrderEntity[0]['status']);
		echo "删除成功";
	}

	public function sureBuyOrder()
	{
		$orderId=$_POST['orderId'];
		$this->load->model('userOrderModel');
		$this->load->model('goodsTypeUnionModel');
		$this->load->model('userOrderGoodsModel');
		$this->load->model('goodsModel');

		$userOrderEntity=$this->util->toCamel($this->userOrderModel->findByIdAndStatusAndPayStatus($orderId,4));
		$userOrderEntity[0]['payStatus']=1;
		$this->userOrderModel->update($userOrderEntity[0]['id'],$userOrderEntity[0]['openId'],$userOrderEntity[0]['storeId'],$userOrderEntity[0]['storeName'],$userOrderEntity[0]['goodsTotalNum'],$userOrderEntity[0]['goodsTotalMoney'],$userOrderEntity[0]['payStatus'],$userOrderEntity[0]['express'],$userOrderEntity[0]['bill'],$userOrderEntity[0]['message'],$userOrderEntity[0]['addressId'],$userOrderEntity[0]['status']);
		$userOrderGoodsEntities=$this->util->toCamel($this->userOrderGoodsModel->findByOrderIdAndStatus($orderId));
		for ($j=0; $j < sizeof($userOrderGoodsEntities); $j++) { 
			$goodsTypeUnionEntity=$this->util->toCamel($this->goodsTypeUnionModel->findByIdAndStatus($userOrderGoodsEntities[$j]['goodsTypeId']));
			$goodsTypeUnionEntity[0]['goodsSales']=(int)$goodsTypeUnionEntity[0]['goodsSales']+(int)$userOrderGoodsEntities[$j]['goodsNum'];
			$this->goodsTypeUnionModel->update($goodsTypeUnionEntity[0]['id'],$goodsTypeUnionEntity[0]['goodsNum'],$goodsTypeUnionEntity[0]['goodsSales'],$goodsTypeUnionEntity[0]['status']);

			$goodsEntity=$this->util->toCamel($this->goodsModel->findByIdAndStatus($userOrderGoodsEntities[$j]['goodsId']));
			$goodsEntity[0]['goodsSales']=(int)$goodsEntity[0]['goodsSales']+(int)$userOrderGoodsEntities[$j]['goodsNum'];
			$this->goodsModel->update($goodsEntity[0]['id'],$goodsEntity[0]['goodsSales'],$goodsEntity[0]['goodsLike'],$goodsEntity[0]['goodsView'],$goodsEntity[0]['status']);
		}
		
		echo "支付成功";
	}

	public function payOrders()
	{
		$orderIds=json_decode($_POST['orderIds'],true);
		$this->load->model('userOrderModel');
		$this->load->model('goodsTypeUnionModel');
		$this->load->model('userOrderGoodsModel');
		$this->load->model('goodsModel');

		for ($i=0; $i < sizeof($orderIds); $i++) { 
			$userOrderEntity=$this->util->toCamel($this->userOrderModel->findByIdAndStatus((int)$orderIds[$i]));
			$userOrderEntity[0]['payStatus']=1;
			$this->userOrderModel->update($userOrderEntity[0]['id'],$userOrderEntity[0]['openId'],$userOrderEntity[0]['storeId'],$userOrderEntity[0]['storeName'],$userOrderEntity[0]['goodsTotalNum'],$userOrderEntity[0]['goodsTotalMoney'],$userOrderEntity[0]['payStatus'],$userOrderEntity[0]['express'],$userOrderEntity[0]['bill'],$userOrderEntity[0]['message'],$userOrderEntity[0]['addressId'],$userOrderEntity[0]['status']);
			$userOrderGoodsEntities=$this->util->toCamel($this->userOrderGoodsModel->findByOrderIdAndStatus((int)$orderIds[$i]));
			for ($j=0; $j < sizeof($userOrderGoodsEntities); $j++) { 
				$goodsTypeUnionEntity=$this->util->toCamel($this->goodsTypeUnionModel->findByIdAndStatus($userOrderGoodsEntities[$j]['goodsTypeId']));
				$goodsTypeUnionEntity[0]['goodsSales']=(int)$goodsTypeUnionEntity[0]['goodsSales']+(int)$userOrderGoodsEntities[$j]['goodsNum'];
				$this->goodsTypeUnionModel->update($goodsTypeUnionEntity[0]['id'],$goodsTypeUnionEntity[0]['goodsNum'],$goodsTypeUnionEntity[0]['goodsSales'],$goodsTypeUnionEntity[0]['status']);

				$goodsEntity=$this->util->toCamel($this->goodsModel->findByIdAndStatus($userOrderGoodsEntities[$j]['goodsId']));
				$goodsEntity[0]['goodsSales']=(int)$goodsEntity[0]['goodsSales']+(int)$userOrderGoodsEntities[$j]['goodsNum'];
				$this->goodsModel->update($goodsEntity[0]['id'],$goodsEntity[0]['goodsSales'],$goodsEntity[0]['goodsLike'],$goodsEntity[0]['goodsView'],$goodsEntity[0]['status']);
			}
		}
		echo "支付成功";
	}


	public function createOrder()
	{
		$this->load->model('userOrderModel');
		$this->load->model('userOrderGoodsModel');
		$this->load->model('otherModel');
		$this->load->model('goodsTypeUnionModel');
		$this->load->model('cartModel');
		$finaldata=json_decode($_POST['finaldata'],true);
		// var_dump($finaldata);
		$openId=$finaldata['openId'];
		$userOrderStores=$finaldata['userOrderStores'];
		$addressId=$finaldata['addressId'];
		$orderIds=array();        

		// var_dump($userOrderStores);
		

		$list=$this->util->toCamel($this->otherModel->createOrderMessage($openId));
		for ($i=0; $i < sizeof($list); $i++) { 
			if ($list[$i]['goodsNum']==0) {
				$allmessage = array(
		            "status" => 1,
		            "orderIds"=>$orderIds
		        );
		        echo json_encode($allmessage);
		        return;
			}
		}

		for ($i=0; $i < sizeof($list); $i++) { 
			$goodsTypeUnionEntity=$this->util->toCamel($this->goodsTypeUnionModel->findByIdAndStatus($list[$i]['goodsTypeId']));
			$goodsTypeUnionEntity[0]['goodsNum']--;
			$this->goodsTypeUnionModel->update($goodsTypeUnionEntity[0]['id'],$goodsTypeUnionEntity[0]['goodsNum'],$goodsTypeUnionEntity[0]['goodsSales'],$goodsTypeUnionEntity[0]['status']);

			$this->cartModel->update($list[$i]['id'],$list[$i]['goodsSelectNum'],$list[$i]['goodsNumStatus'],$list[$i]['isChoose'],0);
		}

		for ($i=0; $i < sizeof($userOrderStores); $i++) { 
			$q=$this->userOrderModel->insert($openId,$userOrderStores[$i]['storeId'],$userOrderStores[$i]['storeName'],$userOrderStores[$i]['goodsTotalNum'],$userOrderStores[$i]['goodsTotalMoney'],4,$userOrderStores[$i]['express'],$userOrderStores[$i]['bill'],$userOrderStores[$i]['message'],"",$addressId);
			array_push($orderIds, $q);
			$userOrderGoodsList=$userOrderStores[$i]['goodsList'];
			// var_dump($userOrderGoodsList);
			for ($j=0; $j < sizeof($userOrderGoodsList); $j++) { 
				// var_dump($userOrderGoodsList[$j]['goodsType']);
				// var_dump(json_encode($userOrderGoodsList[$j]['goodsType']));
				$this->userOrderGoodsModel->insert($q,$openId,$userOrderGoodsList[$j]['goodsId'],$userOrderGoodsList[$j]['goodsTitle'],$userOrderGoodsList[$j]['goodsImg'],$userOrderGoodsList[$j]['goodsTypeId'],substr(substr(JSON($userOrderGoodsList[$j]['goodsType']),1),0,-1),$userOrderGoodsList[$j]['goodsMoney'],$userOrderGoodsList[$j]['goodsDelMoney'],$userOrderGoodsList[$j]['goodsNum'],$userOrderGoodsList[$j]['goodsExpress'],$userOrderGoodsList[$j]['goodsAddress']);
			}
		}
		$allmessage = array(
            "status" => 2,
            "orderIds"=>$orderIds
        );
        echo json_encode($allmessage);

	}

	public function selectGoods()
	{
		$keyWords=$_POST['keyWords'];
		$page=$_POST['page'];
		$this->load->model('goodsModel');
		$goodsEntities=$this->util->toCamel($this->goodsModel->selectGoods("%".$keyWords."%",$page*6));
		$goodsNum=$this->util->toCamel($this->goodsModel->selectGoodsNum("%".$keyWords."%"));
		// var_dump($goodsNum);
		$totalPage=(int)((int)$goodsNum[0]['COUNT(distinct a.id)']/6);
		if ((int)((int)$goodsNum[0]['COUNT(distinct a.id)']%6)>0) {
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

	
}

function JSON($array)
{
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode(json_encode(json_encode($array)));
    return urldecode($json);
}

function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }

        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}

?>