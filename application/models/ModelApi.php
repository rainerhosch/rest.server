<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModelApi extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        // instansiasi tabel 
        $this->mhs_pt     = 'mahasiswa_pt';
        $this->mhs        = 'mahasiswa';
        $this->krs        = 'krs_new';
        $this->jurusan    = 'jurusan';
        $this->kls        = 'wastu_kelas';
        $this->dsn        = 'dosen';
        $this->dsn_pt     = 'dosen_pt';
        $dosen_pt         = 'dosen_pt';
    }

    function get_mhs($idMhs = null, $thnAjaran = null, $jurusan = null, $nipd = null, $limit = '10', $start = '')
    {
        // code here...
        $this->db->distinct();
        $this->db->select(
            // $this->mhs_pt . ".id_pd, " .
            $this->mhs_pt . ".nipd , " .
                $this->mhs . ".nm_pd as nama, " .
                $this->jurusan . ".nm_jur as prodi, " .
                $this->kls . ".nama_kelas as kelas"
        );
        $this->db->from($this->mhs_pt);

        // join tabel mahasiswa
        $this->db->join(
            $this->mhs,
            $this->mhs_pt . '.id_pd = ' . $this->mhs . '.id_pd',
            'left'
        );

        // join tabel krs_new
        $this->db->join(
            $this->krs,
            $this->mhs_pt . '.nipd = ' . $this->krs . '.nipd',
            'left'
        );

        // join tabel jurusan
        $this->db->join(
            $this->jurusan,
            $this->krs . '.id_jurusan = ' . $this->jurusan . '.id_jur',
            'left'
        );

        // join tabel wastu_kelas
        $this->db->join(
            $this->kls,
            $this->mhs_pt . '.id_kelas = ' . $this->kls . '.id_kelas',
            'left'
        );

        // $condition = [
        //     $this->krs . '.id_tahun_ajaran' => '20192',
        //     $this->krs . '.id_jurusan' => '5'
        // ];

        // $this->db->where($condition);

        // if idMhs provided
        if ($idMhs != null) {
            $this->db->where($this->mhs_pt . '.id_pd', $idMhs);
        }
        // if nipd provided
        if ($nipd != '') {
            $this->db->where($this->mhs_pt . '.nipd', $nipd);
        }

        // if limit and start provided
        if ($limit != "") {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by($this->mhs_pt . '.nipd', 'asc');
        $datas = $this->db->get();
        return $datas;
    }
}
