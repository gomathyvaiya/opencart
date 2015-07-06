<?php
/*
 * Full Page Cache developed by Alexandre PIEL
 * alexandre.piel@gmail.com
 */
class FPC
{
  protected static $instance;

  protected $_key;
  protected $_page;
  protected $_forceRefresh = false;
  protected $_routes = array(
      'product/product',
      'product/category',
  );
  protected $_patternStart = '<!-- fpc %';
  protected $_patternVar = '% -->';
  protected $_patternEnd = '<!-- fpc end -->';
  protected $_globalMemoryFolder = 'fpc';

  public static function instance() {
    if (!isset(self::$instance)) {
      $className = __CLASS__;
      self::$instance = new $className;
    }
    return self::$instance;
  }

  public function  __construct() {
    $this->_initMemory();
    $this->_initSession();
  }

  protected function _initSession() {
    session_start();
    if (!isset($_SESSION['fpc'])) {
      $_SESSION['fpc'] = array(
        'data' => array(),
      );
    }
  }

  protected function _initMemory() {
    $this->_globalMemoryFolder = DIR_SYSTEM . $this->_globalMemoryFolder;
    if (!file_exists($this->_globalMemoryFolder)) {
      mkdir($this->_globalMemoryFolder, 0777, true);
    }
  }

  public function run() {
    if (isset($_COOKIE['language']) && isset($_COOKIE['currency'])) {
      $key = $this->_globalMemoryFolder . '/page/'
              . $_COOKIE['language'] . '/' . $_COOKIE['currency'];

      if (isset($_REQUEST['route'])) {
        $route = $_REQUEST['route'];
        if ($route === 'product/product' && isset($_REQUEST['product_id'])) {
          $this->_key = $key . '/product/' . $_REQUEST['product_id'];
        }
        else if ($route === 'product/category' && isset($_REQUEST['path'])) {
          $this->_key = $key . '/category/' . $_REQUEST['path'];
        }
      }
    }
    if (isset($this->_key)) {
      $this->_key .= '/' . md5($_SERVER['REQUEST_URI']) . '/file.php';
      $this->_loadPage();
    }
  }

  protected function _loadPage() {
    $this->_page = $this->_getGlobalData($this->_key);
    if ($this->_page) {
      $page = $this->_page;
      if (!$this->_forceRefresh) {
        //var_dump('use cache');
        echo $page;
        exit();
      }
    }
  }

  protected function _getGlobalData($key) {
    $ret = null;
    if (file_exists($key)) {
      ob_start();
      include($key);
      $ret = ob_get_contents();
      ob_end_clean();
    }
    return $ret;
  }

  protected function _setGlobalData($key, $value) {
    $dir = dirname($key);
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }
    file_put_contents($key, $value);
  }

  protected function _getUserData($key) {
    $ret = false;
    if (isset($_SESSION['fpc']['data'][$key])) {
      $ret = $_SESSION['fpc']['data'][$key];
    }
    return $ret;
  }

  protected function _setUserData($key, $data) {
    $_SESSION['fpc']['data'][$key] = $data;
  }

  public function userBlock($key) {
    $block = $this->_getUserData($key);
    if ($block === false) {
      $this->_forceRefresh = true;
    }
    else {
      echo $block;
    }
  }

  public function setPage($page) {
    $page = str_replace('?>', '<?php echo \'?>\'; ?>', $page);
    $page = str_replace('<?xml', '<?php echo \'<?xml\'; ?>', $page);
    while (true) {
      $pStart = strpos($page, $this->_patternStart);
      $pVar = strpos($page, $this->_patternVar);
      $pEnd = strpos($page, $this->_patternEnd);
      if ($pStart !== false && $pVar !== false && $pEnd !== false) {
        $varStart = $pStart+strlen($this->_patternStart);
        $blockStart = $pVar+strlen($this->_patternVar);
        $blockEnd = $pEnd-$blockStart;

        $start = substr($page, 0, $pStart);
        $var = substr($page, $varStart, $pVar-$varStart);
        $block = substr($page, $blockStart, $blockEnd);
        $end = substr($page, $pEnd+strlen($this->_patternEnd));

//        var_dump($var);
//        var_dump($block);
        $this->_setUserData($var, $block);
        $page = $start . '<?php ' . __CLASS__ . '::instance()->userBlock(\'' . $var . '\'); ?>' . $end; // or may be something else
      }
      else {
        break;
      }
    }
    if ($this->_key) {
      $this->_setGlobalData($this->_key, $page);
    }
  }

  public static function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir); 
  }

  protected function _delDir($path) {
    $rmdir = glob($path);
    foreach($rmdir as $dir) {
      self::delTree($dir);
    }
  }

  protected function _delDirCategory($category_id) {
    $this->_delDir($this->_globalMemoryFolder . '/page/*/*/category/' . $category_id . '*');
    $this->_delDir($this->_globalMemoryFolder . '/page/*/*/category/*_' . $category_id);
    $this->_delDir($this->_globalMemoryFolder . '/page/*/*/category/*_' . $category_id . '_*');
  }

  public function refresh($type) {
    if ($type === 'product' || $type === 'category') {
      global $registry;
      $db = $registry->get('db');
      $fileLastUpdate = $this->_globalMemoryFolder . 'lastUpdate';
      $lastUpdate = '0000-00-00 00:00:00';
      if (file_exists($fileLastUpdate)) {
        $lastUpdate = file_get_contents($fileLastUpdate);
      }
      $newLastUpdate = $lastUpdate;
      $query = $db->query('SELECT product_id, date_modified FROM '.DB_PREFIX.'product WHERE date_modified>"' . $lastUpdate.'"');
      $products = array();
      foreach($query->rows as $product) {
        $products[] = $product['product_id'];
        $this->_delDir($this->_globalMemoryFolder . '/page/*/*/product/' . $product['product_id']);
        if ($product['date_modified'] > $newLastUpdate) {
          $newLastUpdate = $product['date_modified'];
        }
      }
      $query = $db->query('SELECT * FROM '.DB_PREFIX.'product_to_category;');
      foreach($query->rows as $relation) {
        if (in_array($relation['product_id'], $products)) {
          $this->_delDirCategory($relation['category_id']);
        }
      }
      $query = $db->query('SELECT category_id, date_modified FROM '.DB_PREFIX.'category WHERE date_modified>"' . $lastUpdate.'"');
      foreach($query->rows as $category) {
        $this->_delDirCategory($category['category_id']);
        if ($category['date_modified'] > $newLastUpdate) {
          $newLastUpdate = $category['date_modified'];
        }
      }
      file_put_contents($fileLastUpdate, $newLastUpdate);
    }
  }

  public function addToCart($data) {
    if (isset($data['total'])) {
      $block = $this->_getUserData('cart');
      if ($block !== false) {
        $patternStart = '<a><span id="cart-total">';
        $patternEnd = '</span></a></div>';
        $pStart = strpos($block, $patternStart);
        $pEnd = strpos($block, $patternEnd);
        $newBlock = false;
        if ($pStart !== false && $pEnd !== false) {
          $start = substr($block, 0, $pStart);
          $end = substr($block, $pEnd+strlen($patternEnd));
          $newBlock = $start . $patternStart . $data['total'] . $patternEnd . $end;
        }
        $this->_setUserData('cart', $newBlock);
      }
    }
  }

/*  protected function _evalPhp($page) { // for shared memory cache like memcache or redis
    while (true) {
      $pStart = strpos($page, '<?php');
      $pEnd = strpos($page, '?>');
      if ($pStart !== false && $pEnd !== false) {
        $evalStart = $pStart+5;
        $start = substr($page, 0, $pStart);
        $eval = substr($page, $evalStart, $pEnd-$evalStart);
        $end = substr($page, $pEnd+2);

        $block = eval('return ' . $eval);
        $page = $start . $block . $end; // or may be something else
      }
      else {
        break;
      }
    }
    return $page;
  }*/
}
FPC::instance()->run();
