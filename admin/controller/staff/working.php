<?php
class ControllerStaffWorking extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('staff/working');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/working');

		$this->getList();
	}

	public function add() {
		$this->load->language('staff/working');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/working');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_working->addWorking($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_code'])) {
				$url .= '&filter_code=' . $this->request->get['filter_code'];
			}

			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}

			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}

			if (isset($this->request->get['filter_department_id'])) {
				$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
			}

			if (isset($this->request->get['filter_part_id'])) {
				$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
			}

			if (isset($this->request->get['filter_error'])) {
				$url .= '&filter_error=' . $this->request->get['filter_error'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('staff/working', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('staff/working');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/working');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_working->editWorking($this->request->get['working_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_code'])) {
				$url .= '&filter_code=' . $this->request->get['filter_code'];
			}

			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}

			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}

			if (isset($this->request->get['filter_department_id'])) {
				$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
			}

			if (isset($this->request->get['filter_part_id'])) {
				$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
			}

			if (isset($this->request->get['filter_error'])) {
				$url .= '&filter_error=' . $this->request->get['filter_error'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('staff/working', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('staff/working');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/working');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $working_id) {
				$this->model_staff_working->deleteWorking($working_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_code'])) {
				$url .= '&filter_code=' . $this->request->get['filter_code'];
			}

			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}

			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}

			if (isset($this->request->get['filter_department_id'])) {
				$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
			}

			if (isset($this->request->get['filter_part_id'])) {
				$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
			}

			if (isset($this->request->get['filter_error'])) {
				$url .= '&filter_error=' . $this->request->get['filter_error'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('staff/working', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_code'])) {
			$filter_code = $this->request->get['filter_code'];
		} else {
			$filter_code = '';
		}

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['filter_department_id'])) {
			$filter_department_id = $this->request->get['filter_department_id'];
		} else {
			$filter_department_id = '';
		}

		if (isset($this->request->get['filter_part_id'])) {
			$filter_part_id = $this->request->get['filter_part_id'];
		} else {
			$filter_part_id = '';
		}

		if (isset($this->request->get['filter_error'])) {
			$filter_error = $this->request->get['filter_error'];
		} else {
			$filter_error = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['filter_part_id'])) {
			$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
		}

		if (isset($this->request->get['filter_error'])) {
			$url .= '&filter_error=' . $this->request->get['filter_error'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('staff/working', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['add'] = $this->url->link('staff/working/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('staff/working/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['workings'] = array();

		$this->load->model('staff/staff');
		$staff = $this->model_staff_staff->getStaffByCode($filter_code);
		$staff_id = '';
		if (!empty($staff)) {
			$staff_id = $staff['staff_id'];
		}

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin'),
			'staff_id' => $staff_id,
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_department_id' 	 => $filter_department_id,
			'filter_part_id' 		 => $filter_part_id,
			'filter_error' 			 => $filter_error
		);

		$working_total = $this->model_staff_working->getTotalWorkings($filter_data);

		$results = $this->model_staff_working->getWorkings($filter_data);

		foreach ($results as $result) {
			$is_friday = false;
			if (date('l', strtotime($result['date'])) == "Friday") {
				$is_friday = true;
			}

			$data['workings'][] = array(
				'working_id'  => $result['working_id'],
				'code'        => $result['code'],
				'working_code' => $result['working_code'],
				'fullname'    => $result['fullname'],
				'date'        => $result['date'],
				'checkin'     => $result['checkin'],
				'checkout'    => $result['checkout'],
				'over'    	  => $result['over'] . 'h',
				'under'    	  => $result['under'] . 'h',
				'working_time' => $result['working_time'],
				'absent' 	  => $result['absent'],
				'part' 	  	  => $result['part_name'],
				'edit'        => $this->url->link('staff/working/edit', 'token=' . $this->session->data['token'] . '&working_id=' . $result['working_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_code'] = $this->language->get('text_code');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_true'] = $this->language->get('text_true');
		$data['text_false'] = $this->language->get('text_false');

		$data['column_code'] = $this->language->get('column_code');
		$data['column_working_code'] = $this->language->get('column_working_code');
		$data['column_fullname'] = $this->language->get('column_fullname');
		$data['column_date'] = $this->language->get('column_date');
		$data['column_checkin'] = $this->language->get('column_checkin');
		$data['column_checkout'] = $this->language->get('column_checkout');
		$data['column_over'] = $this->language->get('column_over');
		$data['column_under'] = $this->language->get('column_under');
		$data['column_working_time'] = $this->language->get('column_working_time');
		$data['column_absent'] = $this->language->get('column_absent');
		$data['column_department'] = $this->language->get('column_department');
		$data['column_part'] = $this->language->get('column_part');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_error'] = $this->language->get('column_error');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_working1'] = $this->language->get('button_working1');
		$data['button_working2'] = $this->language->get('button_working2');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['filter_part_id'])) {
			$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
		}

		if (isset($this->request->get['filter_error'])) {
			$url .= '&filter_error=' . $this->request->get['filter_error'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('staff/working', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('staff/working', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['filter_part_id'])) {
			$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
		}

		if (isset($this->request->get['filter_error'])) {
			$url .= '&filter_error=' . $this->request->get['filter_error'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $working_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('staff/working', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($working_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($working_total - $this->config->get('config_limit_admin'))) ? $working_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $working_total, ceil($working_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('department/department');
		$departments = $this->model_department_department->getDepartments(array(
			'start' => 0,
			'limit' => 100
		));
		$data['departments'] = array();
		foreach ($departments as $department) {
			$data['departments'][] = array(
				'id' => $department['department_id'],
				'name' => $department['name']
			);
		}
		$data['parts'] = array();
		if (!empty($filter_department_id)) {
			$this->load->model('department/part');
			$parts = $this->model_department_part->getParts(array(
				'filter_department_id' => $filter_department_id,
				'start' => 0,
				'limit' => 100
			));
			foreach ($parts as $part) {
				$data['parts'][] = array(
					'id' => $part['part_id'],
					'name' => $part['name']
				);
			}
		}

		$data['filter_code'] = $filter_code;
		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_department_id'] = $filter_department_id;
		$data['filter_part_id'] = $filter_part_id;
		$data['filter_error'] = $filter_error;

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/working_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['working_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_date'] = $this->language->get('entry_date');
		$data['entry_checkin'] = $this->language->get('entry_checkin');
		$data['entry_checkout'] = $this->language->get('entry_checkout');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}
		
		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['filter_part_id'])) {
			$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
		}

		if (isset($this->request->get['filter_error'])) {
			$url .= '&filter_error=' . $this->request->get['filter_error'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('staff/working', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		if (!isset($this->request->get['working_id'])) {
			$data['action'] = $this->url->link('staff/working/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('staff/working/edit', 'token=' . $this->session->data['token'] . '&working_id=' . $this->request->get['working_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('staff/working', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['working_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$working_info = $this->model_staff_working->getWorking($this->request->get['working_id']);
		}

		$data['token'] = $this->session->data['token'];

		// staff id
		if (isset($this->request->post['staff_id'])) {
			$data['staff_id'] = $this->request->post['staff_id'];
		} elseif (!empty($working_info)) {
			$data['staff_id'] = $working_info['staff_id'];
		} else {
			$data['staff_id'] = '';
		}
		$data['code'] = '';
		if (!empty($data['staff_id'])) {
			$this->load->model('staff/staff');
			$staff = $this->model_staff_staff->getStaff($data['staff_id']);
			$data['code'] = !empty($staff) ? $staff['code'] : '';
		}

		// date
		if (isset($this->request->post['date'])) {
			$data['date'] = $this->request->post['date'];
		} elseif (!empty($working_info)) {
			$data['date'] = $working_info['date'];
		} else {
			$data['date'] = '';
		}

		// checkin
		if (isset($this->request->post['checkin'])) {
			$data['checkin'] = $this->request->post['checkin'];
		} elseif (!empty($working_info)) {
			$data['checkin'] = $working_info['checkin'];
		} else {
			$data['checkin'] = '';
		}

		// checkout
		if (isset($this->request->post['checkout'])) {
			$data['checkout'] = $this->request->post['checkout'];
		} elseif (!empty($working_info)) {
			$data['checkout'] = $working_info['checkout'];
		} else {
			$data['checkout'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/working_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'staff/working')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('staff/staff');
		$staffs = $this->model_staff_staff->getStaffs(array(
			'filter_code' => $this->request->post['code']
		));
		if (empty($staffs)) {
			$this->error['warning'] = $this->language->get('error_code');
		} elseif (empty($this->request->post['staff_id']) || $staffs[0]['staff_id'] != $this->request->post['staff_id']) {
			$this->request->post['staff_id'] = $staffs[0]['staff_id'];
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'staff/working')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function import() {
		$this->load->language('staff/working');
		$this->load->model('staff/working');

		$this->document->setTitle('Upload file chấm công');

		// breadcrumbs
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home' ),
			'href'      => $this->url->link( 'common/home', 'token=' . $this->session->data['token'], 'sSL' ),
      		'separator' => false
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title' ),
			'href'      => $this->url->link( 'staff/working/import', 'token=' . $this->session->data['token'], 'sSL' ),
      		'separator' => ' :: '
   		);

   		// Heading title
		$data['heading_title'] = 'Upload file chấm công';

		$data['text_form'] = 'Upload file chấm công';

		$data['entry_file'] = $this->language->get('entry_file');
		$data['button_submit'] = $this->language->get('button_submit');

		// request
		if ( ($this->request->server['REQUEST_METHOD'] == 'POST') && !empty($this->request->files['file']) ){
			if ( $this->model_staff_working->import($this->request->files['file']) ){
				$data['success'] = 'Thành công: Bạn đã Upload file chấm công!';
			}else{
				$data['error_warning'] = 'Upload file bị lỗi, vui lòng liên hệ 0904 803 779';
			}
		}

		$data['action'] = $this->url->link( 'staff/working/import', 'token=' . $this->session->data['token'], 'SSL');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/working_import.tpl', $data));
	}

	public function exportWorking1() {
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (!empty($filter_date_start) && !empty($filter_date_end)) {
			$this->load->model('staff/working');

			$this->load->language('staff/working');

			// Heading title of excel file
			$arr_data = array(
				'A1-A2' => 'STT',
				'B1-B2' => $this->language->get('excel_code'),
				'C1-C2' => $this->language->get('excel_firstname'),
				'D1-D2' => $this->language->get('excel_lastname'),
				'E1-E2' => $this->language->get('excel_position'),
				'F1-F2' => $this->language->get('excel_working_time'),
				'BQ1-BQ2' => 'NT(h)',
				'BR1-BR2' => 'NN(h)'
			);

			$col = "G"; // List working time
			for ($i = $filter_date_start; $i <= $filter_date_end; $i++) {
				$next_col = $col;
				$next_col++;

				$arr_data[$col . '1-' . $next_col . '1'] = date('d', strtotime($i));
				$arr_data[$col . '2'] = $this->language->get('excel_work');
				$arr_data[$next_col . '2'] = $this->language->get('excel_over');
				
				$col++;
				$col++;
			}

			$this->load->model('department/department');
			$this->load->model('department/part');
			$this->load->model('staff/staff');
			$this->load->model('staff/working');
			$this->load->model('staff/working_offset');
			
			// Get all departments
			$departments = $this->model_department_department->getDepartments(array(
				'start' => 0,
				'limit' => 100
			));
			$row = 3;
			foreach ($departments as $department) {
				// Get all parts
				$parts = $this->model_department_part->getParts(array(
					'filter_department_id' => $department['department_id'],
					'start' => 0,
					'limit' => 100
				));
				foreach ($parts as $part) {
					// Part name
					$arr_data['A' . $row . '-D' . $row] = mb_strtoupper($part['name'], 'UTF-8');
					$row++;
					// Get all staffs
					$staffs = $this->model_staff_staff->getStaffs(array(
						'start' => 0,
						'limit' => 10000,
						'filter_part_id' => $part['part_id']
					));
					foreach ($staffs as $key => $staff) {
						// Staff info
						$arr_data['A' . $row] = $key + 1;
						$arr_data['B' . $row] = $staff['code'];
						$arr_data['C' . $row] = $staff['firstname'];
						$arr_data['D' . $row] = $staff['lastname'];
						$arr_data['E' . $row] = $staff['position_name'];
						$arr_data['F' . $row] = $staff['working'];
						// Get all workings
						$results = $this->model_staff_working->getWorkings(array(
							'start' 				=> 0,
							'limit' 				=> 1000000,
							'staff_id' 				=> $staff['staff_id'],
							'filter_date_start'	    => $filter_date_start,
							'filter_date_end'	    => $filter_date_end
						));
						// Format workings with date is key
						$workings = array();
						foreach ($results as $result) {
							$workings[$result['date']][] = $result;
						}
						// Get all working offsets
						$results = $this->model_staff_working_offset->getWorkingOffsets(array(
							'start' => 0,
							'limit' => 50,
							'staff_id' 				=> $staff['staff_id'],
							'filter_date_start'	    => $filter_date_start,
							'filter_date_end'	    => $filter_date_end
						));
						// Format working offsets with date is key
						$working_offsets = array();
						foreach ($results as $result) {
							$working_offsets[$result['date']][$result['kind']] = $result;
						}
						// Add working content to array for excel file
						$col = 'G';
						$under_time = 0;
						for ($i = $filter_date_start; $i <= $filter_date_end; $i++) {
							$next_col = $col;
							$next_col++;

							$working = empty($workings[$i]) ? null : $workings[$i];
							$working_offset = empty($working_offsets[$i]) ? null : $working_offsets[$i];

							// Lương khoán
							if ($staff['special']) $arr_data[$col . $row] = $staff['working'];
							// Nghỉ không phép
							elseif (empty($working)) {
								$arr_data[$col . $row] = 0;
								$arr_data[$next_col . $row] = 'KP';
							// Tăng ca
							} elseif (!empty($working['over'])) $arr_data[$next_col . $row] = $working['over'];
							// Thiếu giờ
							elseif (!empty($working['under']))

							// Không chấm công & không ngoại lệ
							if (empty($working) && empty($working_offset)) {
								// Nghỉ bù chủ nhật
								if (date('l', strtotime($i)) == 'Sunday') $arr_data[$col . $row] = 'NB';
								// Lương khoán
								elseif ($staff['special']) $arr_data[$col . $row] = $staff['working'];
								// Nghỉ ko phép
								else $arr_data[$col . $row] = 'KP';
							}
							// Không chấm công & có ngoại lệ
							elseif (empty($working)) {
								// Nghỉ bù ko phải chủ nhật
								if (!empty($working_offset[1])) $arr_data[$col . $row] = 'NB';
								// Nghỉ có phép
								elseif (!empty($working_offset[2])) {
									// Nghỉ phép cả ngày
									if ($working_offset[2]['is_full_day']) $_offset_hours = '';
									// Nghỉ phép giờ
									else {
										$_offset_time = strtotime($working_offset[2]['to_hour']) - strtotime($working_offset[2]['from_hour']);
										if ($_offset_time < 0) $_offset_time += 86400;
										$_offset_hours = $this->model_staff_working->formatToHour($_offset_time);
									}
									$arr_data[$col . $row] = $_offset_hours . 'CP';
								// Nghỉ phép năm
								} elseif (!empty($working_offset[4])) $arr_data[$col . $row] = 'PN';
								// Nghỉ ko phép
								else $arr_data[$col . $row] = 'KP';
							// Có chấm công
							} else {
								// Làm 2 ca 1 ngày
								if ($staff['working'] == 12 && date('l', strtotime($i)) == 'Friday' && count($working) > 1) {
									// Nghỉ bù
									if (!empty($working_offset[1])) $arr_data[$col . $row] = 'NB';
									// Ngày thường
									else $arr_data[$col . $row] = '16';
									$_over_hours = 0;
									foreach ($working as $result) {
										// Có giấy tăng ca
										if (!empty($working_offset[3])) {
											$_over_time = strtotime($working_offset[3]['to_hour']) - strtotime($working_offset[3]['from_hour']);
											if ($_over_time < 0) $_over_time += 86400;
											$_over_hours += $this->model_staff_working->formatToHour($_over_time);
										}
									}
									$arr_data[$next_col . $row] = $_over_hours == 0 ? '' : $_over_hours;
								// Làm ngày thường
								} else {
									$working = $working[0];
									// Chủ nhật hoặc nghỉ bù
									if (!empty($working_offset[1]) || date('l', strtotime($i)) == 'Sunday') $arr_data[$col . $row] = 'NB';
									// Ngày thường
									else $arr_data[$col . $row] = $staff['working'];
									// Có giấy tăng ca
									if (!empty($working_offset[3])) {
										$_over_time = strtotime($working_offset[3]['to_hour']) - strtotime($working_offset[3]['from_hour']);
										if ($_over_time < 0) $_over_time += 86400;
										$arr_data[$next_col . $row] = $this->model_staff_working->formatToHour($_over_time);
									}
								}
								// Nếu có tăng ca
								if (!empty($arr_data[$next_col . $row])) {
									// Ngày nghỉ bù
									if ($arr_data[$col . $row] == 'NB') $arr_data[$next_col . $row] .= 'NN';
									// Ngày thường
									else $arr_data[$next_col . $row] .= 'NT';
								}
							}

							$col++;
							$col++;
						}

						$row++;
					}
				}
			}
			
			$filename = 'chamcong';
			$file = DIR_DOWNLOAD . $filename . '.xlsx';
			$sheetname = $filter_date_start . '_' . $filter_date_end;

			$this->load->model('tool/excel');
			$this->model_tool_excel->modifyExcelFile($arr_data, $file, $sheetname);

			print "COMPLETED!";
			$this->response->redirect(HTTP_CATALOG . 'system/download/' . $filename . '.xlsx');
		}

		exit;
	}
}