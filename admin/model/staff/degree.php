<?php
class ModelStaffDegree extends Model {
	public function addDegree($data) {
		$this->event->trigger('pre.admin.degree.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "degree SET name = '" . $this->db->escape($data['name']) . "'");

		$this->cache->Delete('degree');

		$this->event->trigger('post.admin.degree.add', $degree_id);

		return $degree_id;
	}

	public function editDegree($degree_id, $data) {
		$this->event->trigger('pre.admin.degree.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "degree SET name = '" . $this->db->escape($data['name']) . "' WHERE degree_id = '" . (int)$degree_id . "'");

		$this->cache->Delete('degree');

		$this->event->trigger('post.admin.degree.edit', $degree_id);
	}

	public function deleteDegree($degree_id) {
		$this->event->trigger('pre.admin.degree.delete', $degree_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "degree WHERE degree_id = '" . (int)$degree_id . "'");

		$this->cache->Delete('degree');

		$this->event->trigger('post.admin.degree.Delete', $degree_id);
	}

	public function getDegree($degree_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "degree c WHERE c.degree_id = '" . (int)$degree_id . "'");

		return $query->row;
	}

	public function getDegrees($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "degree";

		$sort_data = array(
			'name'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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

	public function getTotalDegrees() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "degree");

		return $query->row['total'];
	}
}
