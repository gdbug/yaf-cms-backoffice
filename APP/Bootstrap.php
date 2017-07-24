<?php
class Bootstrap extends Yaf_Bootstrap_Abstract {
	protected $config;

	public function _initConfig(Yaf_Dispatcher $dispatcher) {
		$this->config = Yaf_Application::app()->getConfig();		
		Yaf_Registry::set('config', $this->config);		
		//判断请求方式，命令行请求应跳过一些HTTP请求使用的初始化操作，如模板引擎初始化		
	}

	public function _initError(Yaf_Dispatcher $dispatcher) {
		if ($this->config->application->debug)
		{
			define('DEBUG_MODE', true);
			ini_set('display_errors', 'On');
		}
		else
		{
			define('DEBUG_MODE', false);
			ini_set('display_errors', 'Off');
		}
	}

	public function _initPlugin(Yaf_Dispatcher $dispatcher) {
		if (isset($this->config->application->benchmark) && $this->config->application->benchmark == true)
		{
			$benchmark = new BenchmarkPlugin();
			$dispatcher->registerPlugin($benchmark);
		}
		//cookie涉及HTTP请求，命令行下应禁用
		if (REQUEST_METHOD != 'CLI')
		{			
			$auth	= new AuthPlugin();
			$dispatcher->registerPlugin($auth);
			
			$antizy = new AntizyPlugin();
			$dispatcher->registerPlugin($antizy);
		}
	}

	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		$routes = $this->config->routes;
		if (!empty($routes))
		{
			$router = $dispatcher->getRouter();
			$router->addConfig($routes);
		}
	}

	public function _initMemcache() {
		if (!empty($this->config->cache->caching_system))
		{
			Yaf_Registry::set('cache_exclude_table', explode('|', $this->config->cache->cache_exclude_table));
			Yaf_Loader::import(APP_PATH . '/library/Cache/Cache.php');
			if (isset($this->config->cache->prefix))
			{
				define('CACHE_KEY_PREFIX', $this->config->cache->prefix);
			}
			if (isset($this->config->cache->object_cache_enable) && $this->config->cache->object_cache_enable)
			{
				define('OBJECT_CACHE_ENABLE', true);
			}
			else
			{
				define('OBJECT_CACHE_ENABLE', false);
			}
		}
		else
		{
			define('OBJECT_CACHE_ENABLE', false);
		}
	}

	public function _initDatabase() {
		$capsule = new Capsule;
	}

	public function _initView(Yaf_Dispatcher $dispatcher) {
		//命令行下基本不需要使用smarty
		if (REQUEST_METHOD != 'CLI')
		{
			$smarty = new Smarty_Adapter(null, $this->config->smarty);
			$smarty->registerFunction('function', 'truncate', array('Tools', 'truncate'));
			$dispatcher->setView($smarty);
		}
	}
		
}