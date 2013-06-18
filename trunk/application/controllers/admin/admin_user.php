<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_user extends MY_Controller {
	/*public function index()
	{
        //show_error('asf',300);
        $this->_error('aaaa');
	}*/
    protected function _filter($map){
        $keywords = $this->input->get_post('keywords');
        if(!empty($keywords)){
            $map['like']=array('username'=>$keywords);
        }
        return $map;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */