<?php
//	namespace application\core;

	class Router{
		protected $routes=[];
		protected $params=[];

		function __construct(){
		$arr=require 'application/config/routes.php';

		foreach($arr as $key => $val){
			$this->add($key,$val);
		       }
		}

		public function add($route,$params){
			$item='#^'.$route.'$#';
			$this->routes[$item]=$params;
		}

		public function match(){
			
			$url=trim($_SERVER['REQUEST_URI'],'/');
			foreach($this->routes as $route => $params){
				if(preg_match($route,$url,$matches)){
					print_r($matches);	
					$this->params=$params;
					return true;
				}
			    }
		      return false;	
		}
		
		public function run(){
			echo 'run server';
			echo '<hr>';

			if($this->match()){
				echo '<p>controller: <b>'.$this->params['controller'].'</b></p>';
				echo '<p>action: <b>'.$this->params['action'].'</b></p>';
				$path='application\controllers\\'.ucfirst($this->params['controller']).'Controller.php';
				if(class_exists($path)){
				  $action=$this->params['action'].'Action';
					if(method_exists($path,$action)){
				  		echo $action;
						$controller=new $path;
						$controller->$action();
					}
					else{
						echo 'Action не найден'.$action;
					}
				}
				else{
				  echo 'Controller Не найден: '.$path;
				}
			}
			else{
				echo 'Маршрут не найден';
			}
	

			//$my_arr=array(1,4,3,'hi',5);
			//foreach($my_arr as $key=>$value){
			//	echo '[$'.$key.']=>',$value,'<br>';
			//}
		}
	}
?>
