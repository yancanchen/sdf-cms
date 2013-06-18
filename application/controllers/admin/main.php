<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

    /**
     * 后台主界面
     */
    public function index()
	{
        $this->load->view($this->D.$this->C.'/'.$this->M);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */