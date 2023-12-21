<?php

namespace App\Models;

use CodeIgniter\Model;

class PcsModel extends Model
{
    protected $table            = 'pcs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected $pcs;
    protected $db;
    public function __construct()
    {
        $this->pcs = db_connect('pcs');
        $this->db = db_connect('default');
    }

    public function getMaterial()
    {
        $builder = $this->pcs->table('MD_MATERIALS');
        $builder->select('MAT_CODE, MAT_SAP_CODE');
        $builder->where('SFC_CODE', 'AL');
        $builder->where('MAT_OUT_MNG IS NULL');
        return $builder->get()->getResultArray();
    }

    public function findMaterial($mat_code)
    {
        $builder = $this->pcs->table('MD_MATERIALS');
        $builder->select('MAT_CODE, MAT_DESC, MAT_SAP_CODE');
        $builder->where('MAT_CODE', $mat_code);
        $builder->where('SFC_CODE', 'AL');
        $builder->where('MAT_OUT_MNG IS NULL');
        return $builder->get()->getRowArray();
    }


    function getMachine($mt_code = null)
    {
        $builder = $this->pcs->table('MD_MACHINES');
        $builder->select('MCH_CODE,PP_CODE,MCH_NUMBER,MCH_DESC,MT_CODE');
        // BTUM SBTU, STUM
        if ($mt_code != null) {
            $mt_code = strtoupper($mt_code);
            if ($mt_code == 'BTUM' || $mt_code == 'SBTU') {
                $builder->where('MT_CODE', 'BTUM');
                $builder->orWhere('MT_CODE', 'SBTU');
            } else {
                $builder->where('MT_CODE', $mt_code);
            }
        }
        $builder->where('PP_CODE', 'B02');
        return $builder->get()->getResultArray();
    }

    public function shiftCek()
    {
        $timeNow = intval(date('H'));

        //         id	waktu_mulai	waktu_selesai	nama_shift
        // 1	00:00:00.0000000	07:59:59.0000000	1
        // 2	08:00:00.0000000	15:59:59.0000000	2
        // 3	16:00:00.0000000	23:59:59.0000000	3

        $res = [
            [
                'nama_shift' => '1',
                'waktu_mulai' => '00:00:00.0000000',
                'waktu_selesai' => '07:59:59.0000000',
            ],
            [
                'nama_shift' => '2',
                'waktu_mulai' => '08:00:00.0000000',
                'waktu_selesai' => '15:59:59.0000000',
            ],
            [
                'nama_shift' => '3',
                'waktu_mulai' => '16:00:00.0000000',
                'waktu_selesai' => '23:59:59.0000000',
            ]
        ];

        $shiftPertama = intVal(explode(':', $res[0]['waktu_mulai'])[0]);
        $shiftKedua = intVal(explode(':', $res[1]['waktu_mulai'])[0]);
        $shiftKetiga = intVal(explode(':', $res[2]['waktu_mulai'])[0]);

        // d($shiftKetiga);
        if ($timeNow >= $shiftKetiga) {
            $shiftMulai = explode('.', $res[2]['waktu_mulai'])[0];
            $shiftMulai = $shiftMulai . ".00";

            $shiftSelesai = explode('.', $res[2]['waktu_selesai'])[0];
            $shiftSelesai = $shiftSelesai . ".00";

            $data = [
                'shift' => $res[2]['nama_shift'],
                'waktu_mulai' => $shiftMulai,
                'waktu_selesai' => $shiftSelesai,
            ];
        } else if ($timeNow >= $shiftKedua && $timeNow < $shiftKetiga) {
            $shiftMulai = explode('.', $res[1]['waktu_mulai'])[0];
            $shiftMulai = $shiftMulai . ".00";

            $shiftSelesai = explode('.', $res[1]['waktu_selesai'])[0];
            $shiftSelesai = $shiftSelesai . ".00";

            $data = [
                'shift' => $res[1]['nama_shift'],
                'waktu_mulai' => $shiftMulai,
                'waktu_selesai' => $shiftSelesai,
            ];
        } else if ($timeNow >= $shiftPertama && $timeNow < $shiftKedua) {
            $shiftMulai = explode('.', $res[0]['waktu_mulai'])[0];
            $shiftMulai = $shiftMulai . ".00";

            $shiftSelesai = explode('.', $res[0]['waktu_selesai'])[0];
            $shiftSelesai = $shiftSelesai . ".00";

            $data = [
                'shift' => $res[0]['nama_shift'],
                'waktu_mulai' => $shiftMulai,
                'waktu_selesai' => $shiftSelesai,
            ];
        }

        return $data;
    }

    public function filterMatsapCode($shift, $m)
    {
        $sql = "SELECT MAT_SAP_CODE, COUNT(MAT_SAP_CODE) as GT FROM ( 
            SELECT MAT_SAP_CODE FROM [PCS].[dbo].[DC_EVENTS] 
            where EV_CODE = 'PROD' and EV_SUBCODE = 'MACH' AND EVS_STATUS = 1 and PP_CODE ='B02'
            and CONVERT (datetime,EVS_START) >= '" . date('Y-m-d ') . $shift['waktu_mulai'] . "' 
            and CONVERT (datetime,EVS_START) <= '" . date('Y-m-d ') . $shift['waktu_selesai'] . "' 
            and MCH_CODE = '" . $m['MCH_NUMBER'] . "' 
            ) data_events GROUP BY MAT_SAP_CODE
        ";

        $data = $this->pcs->query($sql)->getResultArray();

        return $data;
    }

    public function getChartHours($mt_code)
    {

        $machine = $this->getMachine($mt_code);

        $local = $this->db->table('planned_materials');

        $row = [];
        $a = 0;

        foreach ($machine as $m) {

            $shift = $this->shiftCek();

            $b = 0;

            $result = $this->filterMatsapCode($shift, $m);

            if (count($result) > 0) {

                foreach ($result as $key => $value) {

                    $matSapCode = $value['MAT_SAP_CODE'];
                    $tyress = $value['GT'];

                    $local->where('MAT_SAP_CODE', $matSapCode);

                    $planning = $local->get()->getRowArray();

                    if ($planning == null) {
                        $planning = 0;
                    } else {
                        $planning = $planning;
                    }

                    // get waktu mulai ganti ip_code
                    $sqlWhereDate = "SELECT * FROM [PCS].[dbo].[DC_EVENTS]
                    where EV_CODE = 'PROD' and EV_SUBCODE = 'MACH' AND EVS_STATUS = 1
                    and PP_CODE ='B02' and CONVERT (datetime,EVS_START) >= '" . date('Y-m-d ') . $shift['waktu_mulai'] . "' and CONVERT (datetime,EVS_START) <= '" . date('Y-m-d ') . $shift['waktu_selesai'] . "' 
                    and MCH_CODE = '" . $m['MCH_NUMBER'] . "' and MAT_SAP_CODE = '" . $matSapCode . "' order by EVS_START asc";

                    $dateMulaiIpCode = $this->pcs->query($sqlWhereDate)->getResultArray();

                    // $t1 =  strtotime($shift['waktu_mulai']);
                    $timeStart = $dateMulaiIpCode[0]['EVS_START'];
                    $timeEnd = end($dateMulaiIpCode)['EVS_START'];

                    if ($planning == 0) {
                        $row['result'][$a][$b]['actual'] = $tyress;
                        $row['result'][$a][$b]['mat_sap_code'] = $matSapCode;
                        $row['result'][$a][$b]['ip_code'] = 'Not Planned(' . $matSapCode . ')';
                        $row['result'][$a][$b]['hours'] = 0;
                        $row['result'][$a][$b]['planning'] = 0;
                        $row['result'][$a][$b]['machine'] =  $m['MCH_NUMBER'];
                        $row['result'][$a][$b]['time_start'] =  $timeStart;
                        $row['result'][$a][$b]['time_end'] =  $timeEnd;
                    } else {


                        $diff = strtotime($timeEnd) - strtotime($timeStart);
                        // get hours + minutes decimal
                        $hours = $diff / 60 / 60;

                        if ($hours >= 0 && $hours < 1) {
                            $hours = 1;
                        }

                        $row['result'][$a][$b]['actual'] = $tyress;

                        $row['result'][$a][$b]['planning'] = $planning['target_hour'];

                        $row['result'][$a][$b]['hours'] = number_format(($tyress / ($planning['target_hour'] * $hours)) * 100, 2);
                        $row['result'][$a][$b]['mat_sap_code'] = $matSapCode;
                        $row['result'][$a][$b]['ip_code'] = $planning['ip_code'];
                        $row['result'][$a][$b]['machine'] =  $m['MCH_NUMBER'];
                        $row['result'][$a][$b]['time_start'] =  $timeStart;
                        $row['result'][$a][$b]['time_end'] =  $timeEnd;
                    }
                    $b++;
                }
            } else {
                $row['result'][$a][$b]['actual'] = 0;
                $row['result'][$a][$b]['mat_sap_code'] = 'Not Running';
                $row['result'][$a][$b]['ip_code'] = 'Not Running';
                $row['result'][$a][$b]['hours'] = 0;
                $row['result'][$a][$b]['planning'] = 0;
                $row['result'][$a][$b]['machine'] =  $m['MCH_NUMBER'];
                $row['result'][$a][$b]['time_start'] = '----';
                $row['result'][$a][$b]['time_end'] =  '----';
            }

            $row['label'][] = $m['MCH_NUMBER'];


            $a++;
        }

        return $row;
    }

    public function getChartAjax($mch = null)
    {
        $chart = $this->getChartHours($mch);
        $row = [];

        $countMesin = count($chart['result']);
        $count = [];
        foreach ($chart['result'] as $key) {
            $count[] = count($key);
        }

        // cabang ipcode terbanyak adalah 2
        $count = max($count);

        for ($i = 0; $i < $countMesin; $i++) {
            for ($a = 0; $a < $count; $a++) {

                if (count($chart['result'][$i]) == $count) {


                    $row['actual'][$a][] = $chart['result'][$i][$a]['actual'];
                    $row['mat_sap_code'][$a][] = $chart['result'][$i][$a]['mat_sap_code'];
                    $row['ip_code'][$a][] = $chart['result'][$i][$a]['ip_code'];
                    $row['time_start'][$a][] = $chart['result'][$i][$a]['time_start'];
                    $row['time_end'][$a][] = $chart['result'][$i][$a]['time_end'];
                    $row['res'][$a][] = number_format($chart['result'][$i][$a]['hours'], 0);
                } else {
                    // $b = 0;
                    $countIs = count($chart['result'][$i]);
                    if ($countIs != $count) {

                        if ($a < $countIs) {
                            $row['ip_code'][$a][] = $chart['result'][$i][$a]['ip_code'];
                            $row['actual'][$a][] = $chart['result'][$i][$a]['actual'];
                            $row['mat_sap_code'][$a][] = $chart['result'][$i][$a]['mat_sap_code'];
                            $row['res'][$a][] = number_format($chart['result'][$i][$a]['hours'], 0);
                            $row['time_start'][$a][] = $chart['result'][$i][$a]['time_start'];
                            $row['time_end'][$a][] = $chart['result'][$i][$a]['time_end'];
                        } else {
                            $row['ip_code'][$a][] = '|';
                            $row['actual'][$a][] = '|';
                            $row['mat_sap_code'][$a][] = '|';
                            $row['res'][$a][] = '|';
                            $row['time_start'][$a][] = '|';
                            $row['time_end'][$a][] = '|';
                        }
                    }
                }
            }
        }
        $row['label'] = $chart['label'];

        return $row;
    }
}
