<?php

namespace App\Models;

use App\Models\BaseModel;

class PlannedInboundModel extends BaseModel
{
    // protected $DBGroup          = 'default';
    protected $table            = 'planned_inbound';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ip_code',
        'ip_seven',
        'cost_center',
        'brand',
        'mch_type',
        'rim',
        'p_date',
        'week',
        'qty',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = ['beforeDelete'];
    protected $afterDelete    = [];

    public $logId = true;

    public function getDataInbound($tahun = null, $bulan = 1, $week = 0, $brand = null, $rim = null, $cost_center = null, $mch_type = null, $date = null, $get = null)
    {
        $tahun = ($tahun == null) ? date('Y') : $tahun;
        $builder = $this->db->table($this->table);
        $builder->select('SUM(qty) as INBOUND');
        $builder->where('MONTH(p_date)', $bulan);

        $weeknow = idate('W', strtotime(date('Y-m-d')));
        if ($week != 0) {
            // $builder->where('week', $week);
            $builder->where('DATEPART(iso_week, p_date)', $week);
            if ($weeknow == $week) {
                // jika sama maka filter sebelum hari ini
                // $builder->where("CONVERT(date, p_date) < CONVERT(date, GETDATE())");
                $builder->where("CONVERT(date, p_date) < '" . date('Y-m-d') . "'");
            }
        }

        $bulannow = date('m');
        if ($bulan == $bulannow) {
            // jika sama maka filter sebelum hari ini

            if ($week != null) {
                if ($week >= $weeknow) {
                    $builder->where("CONVERT(date, p_date) < '" . date('Y-m-d') . "'");
                    // jika sama maka filter sebelum hari ini
                }
            }
        }


        if ($brand != null) {
            $builder->where('brand', strtoupper($brand));
        }

        if ($get != null) {
            //    ada dua chart dan weekly biasa
            if ($bulan == date('m')) {
                $builder->where("CONVERT(date, p_date) < '" . date('Y-m-d') . "'");
            }
        }


        if ($rim != null) {
            $builder->where('rim', $rim);
        }

        if ($date != null) {
            $builder->where('p_date', $date);
        }

        if ($tahun != null) {
            $builder->where('YEAR(p_date)', $tahun);
        }

        if ($mch_type != null) {
            $mch_type = strtoupper($mch_type);
            if ($mch_type == 'BTU') {
                // karena ada BTU DAN SBTU
                // $builder->where("mch_type IN ('BTU', 'SBTU')");
                $builder->where("mch_type IN ('BTUM', 'SBTU')");
                // $builder->where('mch_type', 'SBTU');
            } else {
                $builder->where("mch_type LIKE '%$mch_type%'");
            }
        }

        if ($cost_center != null) {
            $builder->where('cost_center', $cost_center);
        }


        $data = $builder->get()->getRowArray();
        return $data;
    }
}
