<?php
class ModelWarehouseReceipt extends Model {
	public function addReceipt($data) {
		$this->event->trigger('pre.admin.receipt.add', $data);

		$quantity = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$data['product_id'] . "'")->row['quantity'];

		$this->db->query("INSERT INTO " . DB_PREFIX . "receipt SET product_id = '" . (int)$data['product_id'] . "', quantity = '" . (int)$data['quantity'] . "', quantity_input = " . (int)$quantity . ", receipt_date = DATE('" . $data['receipt_date'] . "')");

		$quantity += $data['quantity'];

		$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE product_id = '" . $data['product_id'] . "'");

		$this->event->trigger('post.admin.receipt.add', $receipt_id);

		return $receipt_id;
	}

	public function editReceipt($receipt_id, $data) {
		$this->event->trigger('pre.admin.receipt.edit', $data);

		$receipt = $this->getReceipt($receipt_id);

		$this->db->query("UPDATE " . DB_PREFIX . "receipt SET quantity = '" . (int)$data['quantity'] . "' WHERE receipt_id = '" . (int)$receipt_id . "'");

		$quantity = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$receipt['product_id'] . "'")->row['quantity'];

		$quantity += $data['quantity'] - $receipt['quantity'];

		$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE product_id = '" . $data['product_id'] . "'");

		$this->event->trigger('post.admin.receipt.edit', $receipt_id);
	}

	public function deleteReceipt($receipt_id) {
		$this->event->trigger('pre.admin.receipt.delete', $receipt_id);

		$receipt = $this->getReceipt($receipt_id);

		$quantity = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$receipt['product_id'] . "'")->row['quantity'];

		$quantity -= $receipt['quantity'];

		$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE product_id = '" . $receipt['product_id'] . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "receipt WHERE receipt_id = '" . (int)$receipt_id . "'");

		$this->event->trigger('post.admin.receipt.delete', $receipt_id);
	}

	public function getReceipt($receipt_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "receipt rc, " . DB_PREFIX . "product_description pd WHERE rc.receipt_id = '" . (int)$receipt_id . "' AND rc.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getReceipts($data = array()) {
		$sql = "SELECT *, rc.quantity AS receipt_quantity FROM " . DB_PREFIX . "receipt rc, " . DB_PREFIX . "product p, " . DB_PREFIX . "product_description pd WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND rc.product_id = p.product_id AND p.product_id = pd.product_id";

		if (!empty($data['filter_product_id'])) {
			$sql .= " AND rc.product_id = '" . (int)$data['filter_product_id'] . "'";
		}

		if (!empty($data['filter_receipt_date'])) {
			$sql .= " AND DATE(rc.receipt_date) = DATE('" . $data['filter_receipt_date'] . "')";
		}

		$sort_data = array(
			'pd.name',
			'p.receipt_date'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY rc.receipt_date";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalReceipts() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "receipt");

		return $query->row['total'];
	}
}