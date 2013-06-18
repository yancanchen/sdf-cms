<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Model Class 扩展model类，加入缓存方法
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class MY_Model extends CI_Model{
    function S($name,$value='',$options=null){
        $this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file'));
        if($this->cache->redis->is_supported()){
            if(''=== $value){ // 获取缓存
                return $this->cache->redis->get($name);
            }elseif(is_null($value)) { // 删除缓存
                return $this->cache->redis->delete($name);
            }else { // 缓存数据
                $expire     =   is_numeric($options)?$options:config_item('cache_time');
                return $this->cache->redis->save($name, $value, $expire);
            }
        }
        if(''=== $value){ // 获取缓存
            return $this->cache->get($name);
        }elseif(is_null($value)) { // 删除缓存
            return $this->cache->delete($name);
        }else { // 缓存数据
            $expire     =   is_numeric($options)?$options:NULL;
            return $this->cache->save($name, $value, $expire);
        }
    }
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */