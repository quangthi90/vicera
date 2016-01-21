<?php
class ModelStaffWorking extends Model {
	public function addWorking($data) {
		$this->event->trigger('pre.admin.working.add', $data);

		$data['checkin'] = empty($data['checkin']) ? '00:00:00' : $data['checkin'];
		$data['checkout'] = empty($data['checkout']) ? '00:00:00' : $data['checkout'];

		$outsides = $this->calculateWorking($data);
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "working SET staff_id = '" . $this->db->escape($data['staff_id']) . "', date = DATE('" . $data['date'] . "'), checkin = TIME('" . $data['checkin'] . "'), checkout = TIME('" . $data['checkout'] . "'), absent = '" . (string)$outsides['absent'] . "', under = '" . (float)$outsides['under'] . "', error = '" . (bool)$outsides['error'] . "'");

		$this->cache->Delete('working');

		$this->event->trigger('post.admin.working.add', $working_id);

		return $working_id;
	}

	public function editWorking($working_id, $data) {
		$this->event->trigger('pre.admin.working.edit', $data);

		$data['checkin'] = empty($data['checkin']) ? '00:00:00' : $data['checkin'];
		$data['checkout'] = empty($data['checkout']) ? '00:00:00' : $data['checkout'];

		$outsides = $this->calculateWorking($data);
		
		$this->db->query("UPDATE " . DB_PREFIX . "working SET staff_id = '" . $this->db->escape($data['staff_id']) . "', date = DATE('" . $data['date'] . "'), checkin = TIME('" . $data['checkin'] . "'), checkout = TIME('" . $data['checkout'] . "'), absent = '" . (string)$outsides['absent'] . "', under = '" . (float)$outsides['under'] . "', error = '" . (bool)$outsides['error'] . "' WHERE working_id = '" . (int)$working_id . "'");

		$this->cache->Delete('working');

		$this->event->trigger('post.admin.working.edit', $working_id);
	}

	public function deleteWorking($working_id) {
		$this->event->trigger('pre.admin.working.delete', $working_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "working WHERE working_id = '" . (int)$working_id . "'");

		$this->cache->Delete('working');

		$this->event->trigger('post.admin.working.delete', $working_id);
	}

	public function getWorking($working_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "working c WHERE c.working_id = '" . (int)$working_id . "'");

		return $query->row;
	}

	public function getWorkings($data = array()) {
		$sql = "SELECT *, prd.name AS part_name, ps.working AS working_time FROM " . DB_PREFIX . "working wk LEFT JOIN " . DB_PREFIX . "staff st ON wk.staff_id = st.staff_id LEFT JOIN " . DB_PREFIX . "position ps ON ps.position_id = st.position_id LEFT JOIN " . DB_PREFIX . "part pr ON ps.part_id = pr.part_id LEFT JOIN " . DB_PREFIX . "part_description prd ON pr.part_id = prd.part_id LEFT JOIN department dp ON pr.department_id = dp.department_id WHERE (wk.status = true OR wk.status = false)";

		if (!empty($data['staff_id'])) {
			$sql .= " AND wk.staff_id = '" . (int)$data['staff_id'] . "'";
		}

		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date) >= '" . $data['filter_date_start'] . "' AND DATE(date) <= '" . $data['filter_date_end'] . "'";
		}

		if (!empty($data['filter_error'])) {
			$sql .= " AND (wk.error = true OR wk.under >= 8)";
		}

		if (!empty($data['filter_department_id'])) {
			$sql .= " AND dp.department_id = '" . (int)$data['filter_department_id'] . "'";
		}

		if (!empty($data['filter_part_id'])) {
			$sql .= " AND pr.part_id = '" . (int)$data['filter_part_id'] . "'";
		}

		$sql .= " ORDER BY wk.date DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		/*$sql = "SELECT * FROM working";
		$query = $this->db->query($sql);
		$results = $query->rows;
		foreach ($results as $result) {
			$this->editWorking($result['working_id'], $result);
		}
		print("completed");
		exit;*/

		/*$sql = "SELECT * FROM staff";
		$query = $this->db->query($sql);
		$staffs = $query->rows;
		foreach ($staffs as $staff) {
			$working_code = str_pad($staff['working_code'], 4, '0', STR_PAD_LEFT);
			$this->db->query("UPDATE staff SET working_code = '" . $working_code . "' WHERE staff_id = '" . $staff['staff_id'] . "'");
		}
		print("completed");
		exit;*/

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getWorkingByDateStaffId($staff_id, $date) {
		$sql = "SELECT * FROM " . DB_PREFIX . "working wk LEFT JOIN " . DB_PREFIX . "staff st ON wk.staff_id = st.staff_id LEFT JOIN position pt ON st.position_id = pt.position_id WHERE wk.staff_id = '" . (int)$staff_id . "' AND wk.date = ('" . (string)$date . "')";

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getTotalWorkings($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "working wk LEFT JOIN " . DB_PREFIX . "staff st ON wk.staff_id = st.staff_id LEFT JOIN " . DB_PREFIX . "position ps ON ps.position_id = st.position_id LEFT JOIN " . DB_PREFIX . "part pr ON ps.part_id = pr.part_id LEFT JOIN " . DB_PREFIX . "part_description prd ON pr.part_id = prd.part_id LEFT JOIN department dp ON pr.department_id = dp.department_id WHERE (wk.status = true OR wk.status = false)";

		if (!empty($data['staff_id'])) {
			$sql .= " AND wk.staff_id = '" . (int)$data['staff_id'] . "'";
		}

		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date) >= '" . $data['filter_date_start'] . "' AND DATE(date) <= '" . $data['filter_date_end'] . "'";
		}

		if (!empty($data['filter_error'])) {
			$sql .= " AND (wk.error = true OR wk.under >= 8)";
		}

		if (!empty($data['filter_department_id'])) {
			$sql .= " AND dp.department_id = '" . (int)$data['filter_department_id'] . "'";
		}

		if (!empty($data['filter_part_id'])) {
			$sql .= " AND pr.part_id = '" . (int)$data['filter_part_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function calculateWorking($data = array()) {
		$time_standard_1 = 30600; // 8,5h
		$time_standard_2 = 43200; // 12h
		$time_standard_3 = 28800; // 8h
		$time_pending = 1200; // 20m
		$time_show = 3600; // 1h
		$time_a_day = 86400; // 24h

		$_data = array(
			'under' => '',
			'over' => '',
			'absent' => empty($data['absent']) ? '' : $data['absent'],
			'error' => false
		);
		
		// Check error data
		if ($data['checkin'] == "00:00:00" || $data['checkout'] == "00:00:00") {
			$_data['error'] = true;
			return $_data;
		}

		// Get staff info
		$this->load->model('staff/staff');
		$staff = $this->model_staff_staff->getStaff($data['staff_id']);
		if (empty($staff)) return false;

		// To timestamp
		$_checkin = strtotime($data['checkin']);
		$_checkout = strtotime($data['checkout']);
		$_date = strtotime($data['date']);

		// Check Sunday
		if (date('l', $_date) == 'Sunday' && $staff['working'] != 12) {
			$_data['absent'] = 'NB';
			return $_data;
		}

		// Calculate working time
		$_working = $_checkout - $_checkin;
		// Case checkin day 1 & checkout day 2
		if ($_working < 0) {
			$_working += $time_a_day;
		}
		// Time actual after sub pending time (20 minutes)
		$_virtual_time = $_working + $time_pending;
		
		// Check Friday (1 person can work in 2 time with total 16h)
		$_is_friday = false;
		if (date('l', $_date) == 'Friday') $_is_friday = true;

		// Calculate work outside standard time
		if ($_is_friday && $staff['working_change']) $_over_virtual_time = $_virtual_time - $time_standard_3; // Friday
		elseif ($staff['working'] == 12) $_over_virtual_time = $_virtual_time - $time_standard_2; // 12h
		elseif ($staff['working'] == 8) $_over_virtual_time = $_virtual_time - $time_standard_1; // 8h

		// Actual outside time
		$_outside_actual_time = $_over_virtual_time - $time_pending;
		if ($_over_virtual_time < 0) { // Check under time
			$_data['under'] = $this->formatToHour(abs($_outside_actual_time)); // Format under time by hours
			$_data['absent'] = 'KP';
		} else {
			if ($_is_friday && $staff['working_change']) $_data['absent'] = 8;
			elseif ($staff['working'] == 12) $_data['absent'] = 12;
			elseif ($staff['working'] == 8) $_data['absent'] = 8;
		}
		
		return $_data;
	}

	public function subTimeForWorking($fromTime, $toTime) {
		$time = strtotime($toTime) - strtotime($fromTime);
		$time = $time < 0 ? $time + 86400 : $time;
		return $this->formatToHour($time);
	}

	public function formatToHour($timestamp_over) {
		$_number_hours = ($timestamp_over - ($timestamp_over % 3600)) / 3600; // To hours
		$_number_minutes = ($timestamp_over % 3600) / 60; // To minutes

		if ($_number_minutes >= 15 && $_number_minutes <= 45) { // Over 0.5h
			$_number_hours += 0.5;
		} elseif ($_number_minutes > 45) { // Over 1h
			$_number_hours += 1;
		}
		
		return $_number_hours;
	}

	public function import($files) {
		$this->load->model('tool/excel');

		$link_files = $files['tmp_name'];

		$this->load->model('staff/staff');
		$staffs = array();

		foreach ($link_files as $file) {
			$arrData = $this->model_tool_excel->readExcelFile($file);

			foreach ($arrData as $data) {
				$data[0] = str_pad($data[0], 4, '0', STR_PAD_LEFT);

				if (empty($staffs[$data[0]])) {
					$staff = $this->db->query("SELECT * FROM " . DB_PREFIX . "staff WHERE working_code = '" . $data[0] . "'")->row;
					if (empty($staff) || empty($staff['staff_id'])) continue;
					$staffs[$data[0]] = $staff['staff_id'];
				}
				
				$date = date('Y-m-d', $this->model_tool_excel->excelDateFormat($data[1]));
				$checkin = date('H:i', $this->model_tool_excel->excelTimeFormat($data[2]));
				$checkout = date('H:i', $this->model_tool_excel->excelTimeFormat($data[3]));

				$working = $this->db->query("SELECT * FROM " . DB_PREFIX . "working WHERE date = DATE('" . $date . "') AND staff_id = '" . (int)$staffs[$data[0]] . "'")->row;
				if (empty($working) || date('l', strtotime($date)) == 'Friday') {
					$data = array(
						'date' => $date,
						'checkin' => $checkin,
						'checkout' => $checkout,
						'staff_id' => $staffs[$data[0]]
					);
					$this->addWorking($data);
				} else {
					$working['date'] = $date;
					$working['checkin'] = $checkin;
					$working['checkout'] = $checkout;
					$this->editWorking($working['working_id'], $working);
				}
			}
		}

		return true;
	}
}
