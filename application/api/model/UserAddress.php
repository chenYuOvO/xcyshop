<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of UserAddress
 *
 * @author admin
 */
class UserAddress extends BaseModel{
    //put your code here
    protected $hidden = ['id','delete_time','user_id'];
}
