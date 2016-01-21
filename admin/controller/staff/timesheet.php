<?php
class ControllerStaffTimesheet extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('staff/timesheet');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function add() {
		$this->load->language('staff/timesheet');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_timesheet->addtimesheet($this->request->post);

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

			$this->response->redirect($this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('staff/timesheet');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_timesheet->edittimesheet($this->request->get['timesheet_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('staff/timesheet');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $timesheet_id) {
				$this->model_staff_timesheet->deletetimesheet($timesheet_id);
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

			$this->response->redirect($this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href' => $this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['add'] = $this->url->link('staff/timesheet/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('staff/timesheet/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['timesheets'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin'),
			'filter_code' => $filter_code,
			'filter_department_id' 	 => $filter_department_id,
			'filter_part_id' 		 => $filter_part_id
		);

		$this->load->model('staff/staff');

		$timesheet_total = $this->model_staff_staff->getTotalStaffs($filter_data);

		$results = $this->model_staff_staff->getStaffs($filter_data);

		foreach ($results as $result) {
			$timesheets = $this->calculateTimesheet($result['staff_id'], $filter_date_start, $filter_date_end);
			
			$data['staffs'][] = array(
				'staff_id'  	=> $result['staff_id'],
				'code'        	=> $result['code'],
				'fullname'    	=> $result['fullname'],
				'working' 		=> $result['working'],
				'department'    => $result['position_name'] . '<br>' . $result['part_name'],
				'timesheets'	=> $timesheets
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
		$data['column_fullname'] = $this->language->get('column_fullname');
		$data['column_working'] = $this->language->get('column_working');
		$data['column_department'] = $this->language->get('column_department');
		$data['column_part'] = $this->language->get('column_part');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');

		$data['button_filter'] = $this->language->get('button_filter');

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

		$data['sort_name'] = $this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

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
		$pagination->total = $timesheet_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($timesheet_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($timesheet_total - $this->config->get('config_limit_admin'))) ? $timesheet_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $timesheet_total, ceil($timesheet_total / $this->config->get('config_limit_admin')));

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

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/timesheet_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['timesheet_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
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
			'href' => $this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		if (!isset($this->request->get['timesheet_id'])) {
			$data['action'] = $this->url->link('staff/timesheet/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('staff/timesheet/edit', 'token=' . $this->session->data['token'] . '&timesheet_id=' . $this->request->get['timesheet_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('staff/timesheet', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['timesheet_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$timesheet_info = $this->model_staff_timesheet->getTimesheet($this->request->get['timesheet_id']);
		}

		$data['token'] = $this->session->data['token'];

		// staff id
		if (isset($this->request->post['staff_id'])) {
			$data['staff_id'] = $this->request->post['staff_id'];
		} elseif (!empty($timesheet_info)) {
			$data['staff_id'] = $timesheet_info['staff_id'];
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
		} elseif (!empty($timesheet_info)) {
			$data['date'] = $timesheet_info['date'];
		} else {
			$data['date'] = '';
		}

		// checkin
		if (isset($this->request->post['checkin'])) {
			$data['checkin'] = $this->request->post['checkin'];
		} elseif (!empty($timesheet_info)) {
			$data['checkin'] = $timesheet_info['checkin'];
		} else {
			$data['checkin'] = '';
		}

		// checkout
		if (isset($this->request->post['checkout'])) {
			$data['checkout'] = $this->request->post['checkout'];
		} elseif (!empty($timesheet_info)) {
			$data['checkout'] = $timesheet_info['checkout'];
		} else {
			$data['checkout'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/timesheet_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'staff/timesheet')) {
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
		if (!$this->user->hasPermission('modify', 'staff/timesheet')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function calculateTimesheet($staff_id, $filter_date_start, $filter_date_end) {
		$this->load->model('staff/working');
		$this->load->model('staff/working_offset');
		$this->load->model('staff/staff');

		$data = array(
			'start' => 0,
			'limit' => 10000,
			'staff_id' => $staff_id,
			'filter_date_start' => $filter_date_start,
			'filter_date_end' => $filter_date_end
		);

		$staff = $this->model_staff_staff->getStaff($staff_id);
		if (empty($staff)) return false;

		// working
		$workings = array();
		$results = $this->model_staff_working->getWorkings($data);
		foreach ($results as $result) {
			if (empty($workings[$result['date']]))
				$workings[$result['date']] = array();
			$workings[$result['date']][] = $result;
		}

		// working offset
		$working_offsets = array();
		$results = $this->model_staff_working_offset->getWorkingOffsets($data);
		foreach ($results as $result) {
			if (empty($working_offsets[$result['date']]))
				$working_offsets[$result['date']] = array();
			$working_offsets[$result['date']][] = $result;
		}
		
		// create timesheet
		$return = array();
		for ($date = $filter_date_start; $date <= $filter_date_end; $date++) {
			$NgC = 0;
			$ThC_CP = 0;
			$ThC_KP = 0;
			$TgC_NT = 0;
			$TgC_NN = 0;
			$f_date = strtotime($date);

			// 8h & sunday
			if (date('l', $f_date) == 'Sunday' && $staff['working'] != 12) {
				$NgC = 'NB';
			}

			if (!empty($working_offsets[$date])) {
				$results = $working_offsets[$date];
				foreach ($results as $result) {
					switch ($result['kind']) {
						case '1':
							$NgC = 'NB';
							break;
						
						case '2':
							if ($result['is_full_day']) {
								$ThC_CP += $staff['working'];
								break;
							}
							$ThC_CP += $this->model_staff_working->subTimeForWorking($result['to_hour'], $result['from_hour']);
							break;

						case '3':
							if ($NgC === 'NB')
								if (!$result['is_full_day'])
									$TgC_NN += $this->model_staff_working->subTimeForWorking($result['to_hour'], $result['from_hour']);
								else
									$TgC_NN += $staff['working'];
							else
								if (!$result['is_full_day'])
									$TgC_NT += $this->model_staff_working->subTimeForWorking($result['to_hour'], $result['from_hour']);
								else
									$TgC_NT += $staff['working'];
							break;
					}
				}
			}

			// Lương khoán
			if ($staff['special']) {
				if ($NgC !== 'NB') {
					$NgC = $staff['working'];
				}
			} elseif (empty($workings[$date])) {
				if ($NgC !== 'NB')
					$ThC_KP = $staff['working'] - $ThC_CP;
			} else {
				$resutls = $workings[$date];
				foreach ($resutls as $resutl) {
					$time_KP = $ThC_CP - $resutl['under'];
					$ThC_KP += $time_KP < 0 ? abs($time_KP) : 0;
					if ($NgC !== 'NB') {
						$NgC += $staff['working'] - $ThC_CP - $ThC_KP;
					}
				}
			}

			$return[$date] = array(
				'NgC' => $NgC < 0 ? 0 : $NgC,
				'ThC' => (($ThC_CP != 0 ? $ThC_CP . 'CP+' : '') . ($ThC_KP != 0 ? $ThC_KP . 'KP' : '')) == '' ? 0 : ($ThC_CP != 0 ? $ThC_CP . 'CP+' : '') . ($ThC_KP != 0 ? $ThC_KP . 'KP' : ''),
				'TgC' => $TgC_NN != 0 ? $TgC_NN : $TgC_NT
			);
		}

		return $return;
	}
}