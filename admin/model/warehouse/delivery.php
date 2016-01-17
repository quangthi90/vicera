<?php
class ModelWarehouseDelivery extends Model {
	public function addDelivery($data) {
		$this->event->trigger('pre.admin.delivery.add', $data);

		if (empty($data['part_id'])) {
			$data['part_id'] = 0;
		}

		$this->db->query("INSERT INTO " . DB_PREFIX . "delivery SET product_id = '" . (int)$data['product_id'] . "', quantity = '" . (int)$data['quantity'] . "', department_id = '" . (int)$data['department_id'] . "', delivery_date = DATE('" . $data['delivery_date'] . "'), part_id = '" . (int)$data['part_id'] . "'");

		$quantity = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$data['product_id'] . "'")->row['quantity'];

		$quantity -= $data['quantity'];

		$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE product_id = '" . $data['product_id'] . "'");

		$this->event->trigger('post.admin.delivery.add', $delivery_id);

		return $delivery_id;
	}

	public function editDelivery($delivery_id, $data) {
		$this->event->trigger('pre.admin.delivery.edit', $data);

		$delivery = $this->getDelivery($delivery_id);

		if (empty($data['part_id'])) {
			$data['part_id'] = 0;
		}

		$this->db->query("UPDATE " . DB_PREFIX . "delivery SET quantity = '" . (int)$data['quantity'] . "', department_id = '" . (int)$data['department_id'] . "', part_id = '" . (int)$data['part_id'] . "' WHERE delivery_id = '" . (int)$delivery_id . "'");

		$quantity = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$delivery['product_id'] . "'")->row['quantity'];

		$quantity = $quantity - $data['quantity'] + $delivery['quantity'];
		
		$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE product_id = '" . $data['product_id'] . "'");

		$this->event->trigger('post.admin.delivery.edit', $delivery_id);
	}

	public function deleteDelivery($delivery_id) {
		$this->event->trigger('pre.admin.delivery.delete', $delivery_id);

		$delivery = $this->getDelivery($delivery_id);

		$quantity = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$delivery['product_id'] . "'")->row['quantity'];

		$quantity += $delivery['quantity'];

		$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE product_id = '" . $delivery['product_id'] . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "delivery WHERE delivery_id = '" . (int)$delivery_id . "'");

		$this->event->trigger('post.admin.delivery.delete', $delivery_id);
	}

	public function getDelivery($delivery_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery dl, " . DB_PREFIX . "product_description pd WHERE dl.delivery_id = '" . (int)$delivery_id . "' AND dl.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getDeliveries($data = array()) {
		$sql = "SELECT *, pd.name AS product_name, dl.quantity AS delivery_quantity, dd.name AS department_name, prd.name AS part_name FROM " . DB_PREFIX . "delivery dl LEFT JOIN " . DB_PREFIX . "part_description prd ON prd.part_id = dl.part_id, " . DB_PREFIX . "product p, " . DB_PREFIX . "product_description pd, " . DB_PREFIX . "department_description dd WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND dl.product_id = p.product_id AND p.product_id = pd.product_id AND dd.language_id = pd.language_id AND dd.department_id = dl.department_id";

		if (!empty($data['filter_product_id'])) {
			$sql .= " AND dl.product_id = '" . (int)$data['filter_product_id'] . "'";
		}

		if (!empty($data['filter_delivery_date'])) {
			$sql .= " AND DATE(dl.delivery_date) = DATE('" . $data['filter_delivery_date'] . "')";
		}

		$sort_data = array(
			'pd.name',
			'p.delivery_date'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dl.delivery_date";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
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

	public function getTotalDeliveries() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "delivery");

		return $query->row['total'];
	}
}