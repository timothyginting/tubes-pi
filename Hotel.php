<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

class Hotel extends RestController
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('Hotel_model', 'htl');
	}

	public function index_get()
	{
		$id = $this->get('id');
		if($id === null){
			$page = $this->get('page');
			$page = (empty($page) ? 1 : $page);
			$total_data = $this->htl->count();
			$total_page = ceil($total_data/5);
			$start = ($page - 1) * 5;
			$list = $this->htl->get(null, 5, $start);
			if($list){
				$data = [
					'status' => true,
					'page' => $page,
					'total_page' => $total_page,
					'data' => $list
				];
			}
			else{
				$data = [
					'status' => false,
					'msg' => 'Data tidak ditemukan'
				];
			}
			$this->response($data, RestController::HTTP_OK);
		}
		else {
			$data = $this->htl->get($id);	
			if($data){
				$this->response(['status' => true, 'data'=> $data ],RestController::HTTP_OK);
			}
			else {
				$this->response(['status' => false, 'msg' => $id. ' tidak ditemukan'],RestController::HTTP_NOT_FOUND);
			}
		}
	}

	public function index_post()
	{
		$data = [
			'id'=>$this->post('id'),
			'nama_hotel'=>$this->post('nama'),
			'kota_hotel'=>$this->post('kota'),
			'alamat_hotel'=>$this->post('alamat'),
			'no_telp_hotel'=>$this->post('no_telp'),
		];
		$simpan = $this->htl->add($data);
		if($simpan['status']){
			$this->response(['status' => true, 'msg' => $simpan['data']. ' Data telah ditambahkan'], RestController::HTTP_CREATED);
		}
		else{
			$this->response(['status' => false, 'msg' => $simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
		}
	}

	public function index_put()
	{
		$data = [
			'id'=>$this->put('id'),
			'nama_hotel'=>$this->put('nama'),
			'kota_hotel'=>$this->put('kota'),
			'alamat_hotel'=>$this->put('alamat'),
			'no_telp_hotel'=>$this->put('no_telp'),
		];
		$id = $this->put('id');
		if($id === null){
			$this->response(['status' => false, 'msg' => 'Masukkan ID yang akan di rubah'], RestController::HTTP_BAD_REQUEST);
		}
		$simpan = $this->htl->update($id, $data);
		if($simpan['status']){
			$status = (int)$simpan['data'];
			if($status > 0){
				$this->response(['status' => true, 'msg' => $simpan['data']. ' Data telah dirubah'], RestController::HTTP_OK);
			}
			else{
				$this->response(['status' => false, 'msg' => 'Tidak ada data yang diubah'], RestController::HTTP_BAD_REQUEST);
			}
		}
		else{
			$this->response(['status' => false, 'msg' => $simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
		}
	}

	public function index_delete()
	{
		$id = $this->delete('id');
		if($id === null){
			$this->response(['status' => false, 'msg' => 'Masukkan ID yang akan di hapus'], RestController::HTTP_BAD_REQUEST);
		}
		$hapus = $this->htl->delete($id);
		if($hapus['status']){
			$status = (int)$hapus['data'];
			if($status > 0){
				$this->response(['status' => true, 'msg' => $id. ' Data telah dihapus'], RestController::HTTP_OK);
			}
			else{
				$this->response(['status' => false, 'msg' => 'Tidak ada data yang di hapus'], RestController::HTTP_BAD_REQUEST);
			}
		}
		else{
			$this->response(['status' => false, 'msg' => $hapus['msg']], RestController::HTTP_INTERNAL_ERROR);
		}
	}



}
