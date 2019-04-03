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
use think\Controller;
use app\lib\enum\ScopeEnum;
use app\lib\exception\forbiddenException;
use app\lib\exception\TokenException;

/**
 * Description of Address
 *
 * @author admin
 */
class Address extends Controller {

    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress'],
    ];

    protected function checkPrimaryScope() {
        $scope = TokenService::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return TRUE;
            } else {
                throw new forbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

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
