<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get($id=null, $limit = 5, $offset = 0)
	{
		if($id === null){
			return $this->db->get('hotel_indonesia', $limit, $offset)->result();
		}
		else{
			return $this->db->get_where('hotel_indonesia', ['id' => $id])->result_array();
		}
	}
	
	public function count()
	{
		return $this->db->get('hotel_indonesia')->num_rows();
	}

	public function add($data)
	{
		try {
			$this->db->insert('hotel_indonesia', $data);
			$error = $this->db->error();
			if(!empty($error['code'])){
				throw new Exception('Terjadi kesalahan: '.$error['message']);
				return false;
			}
			return ['status' => true, 'data' => $this->db->affected_rows()];
		} catch (Exception $ex) {
			return ['status' => false, 'msg' => $ex->getMessage()];
		}
	}

	public function update($id, $data)
	{
		try {
			$this->db->update('hotel_indonesia', $data, ['id' => $id]);
			$error = $this->db->error();
			if(!empty($error['code'])){
				throw new Exception('Terjadi kesalahan: '.$error['message']);
				return false;
			}
			return ['status' => true, 'data' => $this->db->affected_rows()];
		} catch (Exception $ex) {
			return ['status' => false, 'msg' => $ex->getMessage()];
		}
	}

	public function delete($id)
	{
		try {
			$this->db->delete('hotel_indonesia', ['id' => $id]);
			$error = $this->db->error();
			if(!empty($error['code'])){
				throw new Exception('Terjadi kesalahan: '.$error['message']);
				return false;
			}
			return ['status' => true, 'data' => $this->db->affected_rows()];
		} catch (Exception $ex) {
			return ['status' => false, 'msg' => $ex->getMessage()];
		}
	}




}
