<?php
class ModelDepartmentPosition extends Model {
	public function addPosition($data) {
		$this->event->trigger('pre.admin.position.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "position SET working = '" . (int)$data['working'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW(), part_id = '" . (int)$data['part_id'] . "'");

		$position_id = $this->db->getLastId();

		foreach ($data['position_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "position_description SET position_id = '" . (int)$position_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->Delete('position');

		$this->event->trigger('post.admin.position.add', $position_id);

		return $position_id;
	}

	public function editPosition($position_id, $data) {
		$this->event->trigger('pre.admin.position.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "position SET working = '" . (int)$data['working'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), part_id = '" . (int)$data['part_id'] . "' WHERE position_id = '" . (int)$position_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "position_description WHERE position_id = '" . (int)$position_id . "'");

		foreach ($data['position_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "position_description SET position_id = '" . (int)$position_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->Delete('position');

		$this->event->trigger('post.admin.position.edit', $position_id);
	}

	public function deletePosition($position_id) {
		$this->event->trigger('pre.admin.position.Delete', $position_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "position WHERE position_id = '" . (int)$position_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "position_description WHERE position_id = '" . (int)$position_id . "'");

		$this->cache->Delete('position');

		$this->event->trigger('post.admin.position.delete', $position_id);
	}

	public function getPosition($position_id) {
		$query = $this->db->query("SELECT *, c.sort_order AS position_sort_order FROM " . DB_PREFIX . "position c, " . DB_PREFIX . "position_description cd, " . DB_PREFIX . "part pr WHERE c.position_id = cd.position_id AND c.position_id = '" . (int)$position_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pr.part_id = c.part_id");

		return $query->row;
	}

	public function getPositions($data = array()) {
		$sql = "SELECT *, c.position_id AS position_id, cd.name AS name, c.sort_order, dd.name AS department_name, prd.name AS part_name FROM " . DB_PREFIX . "position c LEFT JOIN " . DB_PREFIX . "position_description cd ON (c.position_id = cd.position_id) LEFT JOIN " . DB_PREFIX . "part pr ON c.part_id = pr.part_id LEFT JOIN " . DB_PREFIX . "department_description dd ON dd.department_id = pr.department_id LEFT JOIN " . DB_PREFIX . "part_description prd ON prd.part_id = c.part_id WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_part_id'])) {
			$sql .= " AND pr.part_id = '" . (int)$data['filter_part_id'] . "'";
		}

		$sort_data = array(
			'c.name',
			'c.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c.sort_order";
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

	public function getPositionDescriptions($position_id) {
		$position_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "position_description WHERE position_id = '" . (int)$position_id . "'");

		foreach ($query->rows as $result) {
			$position_description_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}

		return $position_description_data;
	}

	public function getTotalPositions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "position");

		return $query->row['total'];
	}
	
	public function getTotalPositionsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "position_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
