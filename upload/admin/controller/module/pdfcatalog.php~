<?php
class ControllerModulePdfcatalog extends Controller {
	private $error = array();

	public function index() {
		/* Load language file. */
		$this->load->language('module/pdfcatalog');

		$this->document->setTitle($this->language->get('heading_title'));

		/* Check if data has been posted back. */
		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('pdfcatalog', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->cache->delete('pdfcatalog');

					}

		/* Load language strings. */
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_module'] = $this->language->get('text_module');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		/* Loading up some URLS. */
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['form_action'] = $this->url->link('module/pdfcatalog', 'token=' . $this->session->data['token'], 'SSL');

		/* Present error messages to users. */
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


		/* Initial values for form. */
		if (isset($this->request->post['offer_title'])) {
			$data['offer_title'] = $this->request->post['offer_title'];
		} else {
			$data['offer_title'] = $this->config->get('offer_title');
		}
		
		if (isset($this->request->post['File'])) {
			$data['File'] = $this->request->post['File'];
		} else {
			$data['File'] = $this->config->get('File');
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} else {
			$data['status'] = $this->config->get('status');
		}

		/* Breadcrumb. */
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/pdfcatalog', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['token']=$this->session->data['token'];
		$data['form_url'] = $this->url->link('module/pdfcatalog/save', 'token=' . $this->session->data['token'], 'SSL');
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
     $data['base'] = $this->config->get('config_ssl');
  } else {
     $data['base'] = $this->config->get('config_url');
  }
		$this->load->model('module/pdfcatalog');
		
		$data['offer_datas']=$this->model_module_pdfcatalog->get_data();
		/* Render some output. */
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/pdfcatalog.tpl', $data));
	}

	/* Check user input. */
	private function validate() {
		if (strlen($this->request->post['offer_title']) <= 3) {
			$this->error['warning'] = $this->language->get('error_title');
		}

		if ($this->error) {
			return false;
		} else {
			return true;
		}
	}
	
	
	public function save(){
	
		$data['offer_file'] = '';
		$uploads_dir = '../upload/'; // set you upload path here
		if (is_uploaded_file($this->request->files['offer_file']['tmp_name'])) {

		move_uploaded_file($this->request->files['offer_file']['tmp_name'],$uploads_dir.$this->request->files['offer_file']['name']);
		$data['file_name'] = $this->request->files['offer_file']['name'];
		}
		else
		{
//print_r(is_uploaded_file($this->request->files['offer_file']['tmp_name']));exit;
		$data['file_name'] ='';
		}
		$data['status']=$this->request->post['status'];
		$data['offer_title']=$this->request->post['offer_title'];
	
		$this->load->model('module/pdfcatalog');
		$this->model_module_pdfcatalog->save($data);
		$this->response->redirect($this->url->link('module/pdfcatalog', 'token=' . $this->session->data['token'], 'SSL'));

		
	}
	public function delete($catalog_id){
	$id=$_GET['catalog_id'];
	$this->load->model('module/pdfcatalog');
	$this->model_module_pdfcatalog->delete_data($id);
	$this->response->redirect($this->url->link('module/pdfcatalog', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	public function edit_save(){
	
		$data['offer_file'] = '';
		$uploads_dir = '../upload/'; // set you upload path here
		if (is_uploaded_file($this->request->files['offer_file']['tmp_name'])) {

		move_uploaded_file($this->request->files['offer_file']['tmp_name'],$uploads_dir.$this->request->files['offer_file']['name']);
		$data['file_name'] = $this->request->files['offer_file']['name'];
		}
		else
		{

		$data['file_name'] =$this->request->post['offer_filename'];
		}
		$data['status']=$this->request->post['status'];
		$data['offer_title']=$this->request->post['offer_title'];
		$data['catalog_id']=$this->request->post['catalog_id'];
	//print_r($data);exit;
		$this->load->model('module/pdfcatalog');
		$this->model_module_pdfcatalog->edit_data_save($data);
		$this->response->redirect($this->url->link('module/pdfcatalog', 'token=' . $this->session->data['token'], 'SSL'));

		
	}
	
	public function edit($catalog_id){
	$id=$_GET['catalog_id'];//echo $id;exit;

	$this->load->language('module/pdfcatalog');

		$this->document->setTitle($this->language->get('heading_title'));

		/* Check if data has been posted back. */
		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('pdfcatalog', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->cache->delete('pdfcatalog');

					}

		/* Load language strings. */
		$data['text_edit'] = $this->language->get('edit_text');
		$data['text_module'] = $this->language->get('text_module');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		/* Loading up some URLS. */
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['form_action'] = $this->url->link('module/pdfcatalog', 'token=' . $this->session->data['token'], 'SSL');

		/* Present error messages to users. */
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


		

		/* Breadcrumb. */
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/pdfcatalog', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['catalog_id']=$id;
		$data['form_url'] = $this->url->link("module/pdfcatalog/edit_save", 'token=' . $this->session->data['token'], 'SSL');//echo $data['form_url'];exit;
		$this->load->model('module/pdfcatalog');
		/* Editing details  */
		$data['edit_data']=$this->model_module_pdfcatalog->edit_data($id);//print_r($data['edit_data']);exit;
		
		
		//$data['edit_data_save']=$this->model_module_pdfcatalog->edit_data_save($datas,$id);
		/* Render some output. */
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/pdfcatalog_edit.tpl', $data));
	}

	
	
	
	
	public function install() {
		$this->load->model('module/pdfcatalog');
		$this->model_module_pdfcatalog->db_install();
	}
	
	public function uninstall() {
		$this->load->model('module/pdfcatalog');
		$this->model_module_pdfcatalog->db_uninstall();
	}
}
