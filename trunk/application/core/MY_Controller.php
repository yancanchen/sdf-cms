<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 后台操作公共控制器
 *
 * 包含常用数据库操作和权限验证
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
class MY_Controller extends CI_Controller{
	protected  $M = '';//当前访问的方法名
    protected $C = '';//当前访问的类名
    protected $D = '';//当前访问的模块名
	public function __construct()
	{
        parent::__construct();
        $this->C = $this->router->fetch_class();
        $this->M = $this->router->fetch_method();
        $this->D = $this->router->fetch_directory();
        $this->load->helper('url');
        $this->load->helper('form');
        define('__URL__', base_url($this->D.$this->C));
    }
    protected function _error($message){
        show_error($message,300,'操作失败!');
    }
    protected function _success($message){
        show_error($message,200,'操作成功!');
    }

    public function index()
    {
        $this->load->model($this->D.$this->C.'_model',"Model");
        $this->Model->_from($this->C);
        /*echo current_url();exit;
        echo $product_id = $this->uri->ruri_string();
        echo site_url($this->uri->ruri_string());exit;
        echo $product_id;exit;*/
        $data['list'] = $this->_list();//数据列表
        $data['list_fields'] = $this->_list_fields();//字段列表
        //$data['field_data'] = $this->_field_data();


        //$pageNum//当前第几页


        $this->load->view($this->D.$this->C.'/'.$this->M,$data);
    }
    public function add(){
        $this->load->view($this->D.$this->C.'/'.$this->M);
    }
    public function insert(){
        $this->load->model($this->D.$this->C.'_model',"Model");
        $this->Model->_from($this->C);
        $data = $this->input->post('DATA');
        $id = $this->Model->_insert($data);
        if(empty($id)){
            $this->_error('添加数据失败！');
        }
        $this->_success('ok');
    }

    public function edit($id){
        $this->load->model($this->D.$this->C.'_model',"Model");
        $this->Model->_from($this->C);
        $_REQUEST['PK'] = $this->Model->_get_pk();
        $row = $this->Model->_row(array($_REQUEST['PK']=>$id));
        $this->load->view($this->D.$this->C.'/'.$this->M,array('DATA'=>$row));
    }
    public function update(){
        $this->load->model($this->D.$this->C.'_model',"Model");
        $this->Model->_from($this->C);
        $pk = $this->Model->_get_pk();

        $where=array($pk=>$this->input->post($pk));
        $data = $this->input->post('DATA');
        //print_r($where);print_r($data);exit;
        $affected_rows = $this->Model->_update($where,$data);
        $this->_success('成功修改条【'.$affected_rows.'】数据！');
    }

    public function delete($ids){
        $this->load->model($this->D.$this->C.'_model',"Model");
        $this->Model->_from($this->C);
        $list_fields = $this->_list_fields();
        $affected_rows = $this->Model->_delete(array($list_fields[0]=>$ids));
        $this->_success('更新的成功，影响到行数为：'.$affected_rows);
    }

    /**
     * 获取数据列表
     * @return mixed
     */
    public function _list(){
        $map = $this->_search();//生成查询map
        if (method_exists ( $this, '_filter' )) {
            $map = $this->_filter($map);//对查询map加工处理
        }

        $_POST['pageNum'] = intval($this->input->get_post('pageNum'))>0?intval($this->input->get_post('pageNum')):1; //<!--【必须】value=1可以写死-->
        $_POST['numPerPage'] = intval($this->input->get_post('numPerPage'))>0?intval($this->input->get_post('numPerPage')):20;//<!--【可选】每页显示多少条-->
        $_POST['orderField'] = $this->input->get_post('orderField')?$this->input->get_post('orderField'):$this->Model->_get_pk();//<!--【可选】查询排序字段-->
        $_POST['orderDirection'] = in_array($this->input->get_post('orderDirection'),array('desc','asc'))?$this->input->get_post('orderDirection'):'desc';//<!--【可选】升序降序-->

        $list = $this->Model->_map($map)->_limit($_POST['numPerPage'],($_POST['pageNum']-1)*$_POST['numPerPage'])->_order_by($_POST['orderField'],$_POST['orderDirection'])->_list();
        //echo $this->Model->db->last_query();
        $_POST['totalCount'] = $this->Model->_map($map)->_from($this->C)->_count();//总共多少条【服务器获取返回】
        return $list;
    }

    /**
     * 加工搜索条件这个方法用户实现复杂的搜索，次放吧必须被实现
     * @param $map
     * @return mixed
     */
    //abstract protected function _filter($map);
    /*public function _filter($map){
        $keywords = $this->input->get_post('keywords');
        if(!empty($keywords)){
            $map['like']=array('username'=>$keywords);
        }
        return $map;
    }*/
    public function _search() {
        $map = array();
        foreach ( $this->_list_fields() as $k ) {
            $v = $this->input->get_post($k);
            if ($v !== FALSE and $v !==''){
                $map['where'] = array($k=>$v);
            }
        }
        return $map;
    }
    /*
     * 获取字段列表
     */
    public function _list_fields(){
        return $list_fields = $this->Model->_list_fields();
    }
    /*public function _field_data(){
        return $this->Model->db->field_data($this->C);
    }*/



/**
     * 格式化输出
     * @param $message
     * @param int $statusCode
     * @param string $data
     * @param null $data_type
     * @param int $callback
     */
/*    public static function format_output($message,$statusCode=200,$data='',$data_type = null,$callback=0)
    {
        $CI = self::get_instance();
        $data_type = strtolower($data_type);
        if(!in_array($data_type,array('xml','json','zip'))){
            $CI->load->helper('url');
            $current_url = current_url();
            $data_type = strtolower(substr($current_url, -3));
            if(!in_array($data_type,array('xml','json','zip'))){
                $data_type = 'json';
            }
        }

        $d = array(
            'statusCode' => $statusCode,
            'message' => $message,
            'data' =>$data,
            'navTabId' => '',
            'callbackType'=>'',
            'forwardUrl' => ''
        );

        //异步提交返回的值
        if(!empty($callback)){
            $result = json_encode($d);
            echo  $callback."($result)";
            exit;
        }

        if ($data_type == 'xml') {
            header( 'Content-Type:text/html;charset=utf-8 ');
            echo xml_encode($d);
        } elseif ($data_type == 'zip') {
            $CI->load->library('zip');
            $data = xml_encode($d);
            $CI->zip->add_data('xml.xml', $data);
            $CI->zip->download('xml');
        } else {
            header( 'Content-Type:text/html;charset=utf-8 ');
            echo json_encode($d);
        }
        exit;
    }*/


}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */