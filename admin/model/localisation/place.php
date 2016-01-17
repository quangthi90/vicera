<?php
class ModelLocalisationPlace extends Model {
	public function addPlace($data) {
		$this->event->trigger('pre.admin.place.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "place SET name = '" . (string)$data['name'] . "'");

		$this->cache->Delete('place');

		$this->event->trigger('post.admin.place.add', $place_id);

		return $place_id;
	}

	public function editPlace($place_id, $data) {
		$this->event->trigger('pre.admin.place.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "place SET name = '" . (string)$data['name'] . "' WHERE place_id = '" . (int)$place_id . "'");

		$this->cache->Delete('place');

		$this->event->trigger('post.admin.place.edit', $place_id);
	}

	public function deletePlace($place_id) {
		$this->event->trigger('pre.admin.place.Delete', $place_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "place WHERE place_id = '" . (int)$place_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "place_description WHERE place_id = '" . (int)$place_id . "'");

		$this->cache->Delete('place');

		$this->event->trigger('post.admin.place.Delete', $place_id);
	}

	public function getPlace($place_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "place c WHERE c.place_id = '" . (int)$place_id . "'");

		return $query->row;
	}

	public function getPlaces($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "place";

		$sql .= " GROUP BY place_id";

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

	public function getTotalPlaces() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "place");

		return $query->row['total'];
	}
	
	public function getTotalPlacesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "place_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
