<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fenglangyj
 * Date: 13-5-29
 * Time: 下午7:03
 * To change this template use File | Settings | File Templates.
 */
class admin_user_model extends  Common_model
{

    var $title = '';
    var $content = '';
    var $date = '';

    function __construct()
    {
        $this->load->database();
        parent::__construct();
    }
}
