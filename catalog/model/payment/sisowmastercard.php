<?php 

class ModelPaymentsisowMastercard extends Model {
	public function getMethod($address = false, $total = false) {
		if (!$this->config->get('sisowmastercard_status')) {
			return false;
		}
		
		/*if ($this->currency->getCode() != 'EUR') {
			return false;
		}*/
		
		if ($this->config->get('sisowmastercard_geo_zone_id')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('sisowmastercard_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			if (!$query->num_rows) {
     	  		return false;
			}	
		}

		if ($total) {
			if ($this->config->get('sisowmastercard_total') && $total < $this->config->get('sisowmastercard_total')) {
				return false;
			}
			if ($this->config->get('sisowmastercard_totalmax') && $total > $this->config->get('sisowmastercard_totalmax')) {
				return false;
			}
		}

		$this->load->language('payment/sisowmastercard');
		$data = array(
			'id'		=> 'sisowmastercard', // tbv 1.4.x
			'code'		=> 'sisowmastercard',
			'title'		=> $this->language->get('text_title'),
			'sort_order'	=> $this->config->get('sisowmastercard_sort_order')
			);
		return $data;
	}
}
?>
