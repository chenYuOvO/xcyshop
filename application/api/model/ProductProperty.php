<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of ProductProperty
 *
 * @author admin
 */
class ProductProperty extends BaseModel {

    protected $hidden = ['id', 'delete_time', 'product_id', 'update_time'];

}
