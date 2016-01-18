<?php
class ModelStaffWorkingOffset extends Model {
	public function addWorkingOffset($data) {
		$this->event->trigger('pre.admin.working_offset.add', $data);

		if (empty($data['is_full_day'])) {
			$data['is_full_day'] = false;
		} else {
			$data['from_hour'] = '0:00:00';
			$data['to_hour'] = '0:00:00';
		}

		$this->calculateOffset($data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "working_offset SET kind = '" . (int)$data['kind'] . "', staff_id = '" . $this->db->escape($data['staff_id']) . "', date = DATE('" . $data['date'] . "'), from_hour = TIME('" . $data['from_hour'] . "'), to_hour = TIME('" . $data['to_hour'] . "'), is_full_day = '" . (bool)$data['is_full_day'] . "'");

		$this->cache->Delete('working_offset');

		$this->event->trigger('post.admin.working_offset.add', $working_offset_id);

		return $working_offset_id;
	}

	public function editWorkingOffset($working_offset_id, $data) {
		$this->event->trigger('pre.admin.working_offset.edit', $data);

		if (empty($data['is_full_day'])) {
			$data['is_full_day'] = false;
		} else {
			$data['from_hour'] = '0:00:00';
			$data['to_hour'] = '0:00:00';
		}

		$this->calculateOffset($data);

		$this->db->query("UPDATE " . DB_PREFIX . "working_offset SET kind = '" . (int)$data['kind'] . "', from_hour = TIME('" . $data['from_hour'] . "'), to_hour = TIME('" . $data['to_hour'] . "'), is_full_day = '" . (bool)$data['is_full_day'] . "' WHERE working_offset_id = '" . (int)$working_offset_id . "'");

		$this->cache->Delete('working_offset');

		$this->event->trigger('post.admin.working_offset.edit', $working_offset_id);
	}

	public function deleteWorkingOffset($working_offset_id) {
		$this->event->trigger('pre.admin.working_offset.delete', $working_offset_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "working_offset WHERE working_offset_id = '" . (int)$working_offset_id . "'");

		$this->cache->Delete('working_offset');

		$this->event->trigger('post.admin.working_offset.delete', $working_offset_id);
	}

	public function getWorkingOffset($working_offset_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "working_offset c WHERE c.working_offset_id = '" . (int)$working_offset_id . "'");

		return $query->row;
	}

	public function getWorkingOffsets($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "working_offset wk LEFT JOIN " . DB_PREFIX . "staff st ON wk.staff_id = st.staff_id WHERE (is_full_day = '1' OR is_full_day = '0')";

		if (!empty($data['staff_id'])) {
			$sql .= " AND wk.staff_id = '" . (int)$data['staff_id'] . "'";
		}

		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
			$sql .= " AND wk.date >= DATE('" . $data['filter_date_start'] . "') AND wk.date <= DATE('" . $data['filter_date_end'] . "')";
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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalWorkingOffsets($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "working_offset wk LEFT JOIN " . DB_PREFIX . "staff st ON wk.staff_id = st.staff_id WHERE (is_full_day = '1' OR is_full_day = '0')";

		if (!empty($data['staff_id'])) {
			$sql .= " AND wk.staff_id = '" . (int)$data['staff_id'] . "'";
		}

		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
			$sql .= " AND wk.date >= DATE('" . $data['filter_date_start'] . "') AND wk.date <= DATE('" . $data['filter_date_end'] . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function calculateOffset($data, $is_delete = false) {
		$this->load->model('staff/working');
		$working = $this->model_staff_working->getWorkingByDateStaffId($data['staff_id'], $data['date']);
		if (empty($working)) {
			$this->load->model('staff/staff');
			$staff = $this->model_staff_staff->getStaff($data['staff_id']);
			$working = array(
				'staff_id' => $data['staff_id'],
				'date' => $data['date'],
				'working' => $staff['working']
			);
		}
		
		switch ($data['kind']) {
			case '1':
				$working['absent'] = 'NB';
				break;
			
			case '2':
				if ($data['is_full_day']) {
					$time = $working['working'];
				} else {
					$time = strtotime($data['to_hour']) - strtotime($data['from_hour']);
					$time = $time < 0 ? $time + 86400 : $time;
					$time = $this->model_staff_working->calculateOverTime($time);
				}
				if (!empty($working['under'])) $working['under'] -= $time;
				else $working['under'] = $time;
				$working['under'] = $working['under'] < 0 ? 0 : $working['under'];
				$working['absent'] = $time . 'CP';
				break;

			case '3':
				if ($data['is_full_day']) {
					$time = $working['working'];
				} else {
					$time = strtotime($data['to_hour']) - strtotime($data['from_hour']);
					$time = $time < 0 ? $time + 86400 : $time;
					$time = $this->model_staff_working->calculateOverTime($time);
				}
				$working['over'] = $time;
				break;

			case '4':
				$working['absent'] = 'PN';
				break;
		}

		if (empty($working['working_id'])) {
			$this->model_staff_working->addWorking($working);
		} else {
			$this->model_staff_working->editWorking($working['working_id'], $working);
		}
	}
}
