<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of Product
 *
 * @author admin
 */
class Product extends BaseModel {

    protected $hidden = ['update_time', 'create_time', 'delete_time', 'category_id', 'from', 'pivot'];

}
