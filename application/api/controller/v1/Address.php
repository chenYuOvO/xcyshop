<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller\v1;

use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\UserException;
use app\lib\exception\SuccessMassage;
use app\api\controller\BaseController;

/**
 * Description of Address
 *
 * @author admin
 */
class Address extends BaseController {

    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress'],
    ];

    public function createOrUpdateAddress() {
        $validate = new AddressNew();
        $validate->goCheck();
        //获取用户token
        //根据用户的uid找到用户，如果未找到，抛出异常
        //获取从客户端传过来的地址信息
        //根据用户地址信息是否存在，从而判断是添加还是更新
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException;
        }
        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if (!$userAddress) {
            $user->address()->save($dataArray);
        } else {
            $user->address->save($dataArray);
        }
        return json((new SuccessMassage()), 201);
    }

}
