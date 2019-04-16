<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of Order
 *
 * @author admin
 */
class Order extends BaseModel {

    protected $autoWriteTimestamp = true;
    protected $hidden = ['user_id', 'delete_time', 'update_time'];

}
