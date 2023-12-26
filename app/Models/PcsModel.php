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


    function getDataCuring($bulan = null, $tahun = null)
    {
        $date_first = $tahun . '-' . $bulan . '-01';
        // $date_last = date('Y-m-d', strtotime('-1 Days', strtotime(date('Y-m-d'))));
        if ($bulan < date('m') && $tahun <= date('Y')) {
            // jika bulan yang di pilih lebih kecil dari bulan sekarang
            // $date_last = $tahun . '-' . $bulan . $date;
            $date_last = date("Y-m-t", strtotime("$tahun-$bulan-01"));
        } else {
            $date_last = $tahun . '-' . $bulan . date('-d');
        }


        $sql_group = "SELECT MD.MAT_CODE
                        ,SUM(PS_QUANTITY) as PS_QUANTIY
                    FROM [PCS].[dbo].[DC_PRODUCTION_DATA] as DC
                LEFT JOIN MD_MATERIALS AS MD ON MD.MAT_SAP_CODE = DC.MAT_SAP_CODE
                    LEFT JOIN MD_MACHINES as MDM ON MDM.MCH_CODE = DC.MCH_CODE
                    WHERE DC.PP_CODE = 'V01' 
                    --AND MD.MAT_CODE = '36272'
                    AND CONVERT(date, PS_DATE) >= '" . $date_first . "'
                    AND CONVERT(date, PS_DATE) <= '" . $date_last . "'   GROUP BY MD.MAT_CODE";
        $data_act = $this->pcs->query($sql_group)->getResultArray();


        $new_data = [];
        $old_data = [];
        $a = 0;
        foreach ($data_act as $key => $value) {

            $data_plan = $this->db->table('planned_curing')->select('ip_code, mch_type, SUM( CASE WHEN p_date = CONVERT(date, GETDATE()) THEN 
                    ROUND( (qty * ROUND( CAST( (DATEPART(hour, GETDATE()) * 60 + DATEPART(minute, GETDATE()) ) as FLOAT) / 60 , 1) / 24), 0 )
                ELSE qty
            END ) as qty')->where('ip_code', $value['MAT_CODE'])->where('p_date >=', $date_first)->where('p_date <=', $date_last)->groupBy('ip_code, mch_type')->get()->getRowArray();

            $plan = ($data_plan) ? $data_plan['qty'] : 0;
            $mch = ($data_plan) ? $data_plan['mch_type'] : '';
            $gap = $value['PS_QUANTIY'] - $plan;
            $old_data[$a]['MAT_CODE'] = $value['MAT_CODE'];
            $old_data[$a]['MCH_TYPE'] = $mch;
            $old_data[$a]['ACT'] = $value['PS_QUANTIY'];
            $old_data[$a]['PLAN'] = $plan;
            // $new_data[$a]['MAT_CODE'] = $value['MAT_CODE'];
            $new_data[$a]['GAP'] = $gap;
            $a++;
        }

        // krsort($new_data);
        arsort($new_data);
        $data = [];
        $a = 0;
        $mru1 = 0;
        $btum = 0;
        $stum = 0;
        $sbtu = 0;
        foreach ($new_data as $key => $value) {

            if ($old_data[$key]['MCH_TYPE'] == 'MRU1') {
                $data['MRU1'][$mru1]['MAT_CODE'] = $old_data[$key]['MAT_CODE'];
                $data['MRU1'][$mru1]['MCH_TYPE'] = $old_data[$key]['MCH_TYPE'];
                $data['MRU1'][$mru1]['ACT'] = $old_data[$key]['ACT'];
                $data['MRU1'][$mru1]['PLAN'] = $old_data[$key]['PLAN'];
                $data['MRU1'][$mru1]['GAP'] = $value['GAP'];
                $mru1++;
            } else  if ($old_data[$key]['MCH_TYPE'] == 'BTUM') {
                $data['BTUM'][$btum]['MAT_CODE'] = $old_data[$key]['MAT_CODE'];
                $data['BTUM'][$btum]['MCH_TYPE'] = $old_data[$key]['MCH_TYPE'];
                $data['BTUM'][$btum]['ACT'] = $old_data[$key]['ACT'];
                $data['BTUM'][$btum]['PLAN'] = $old_data[$key]['PLAN'];
                $data['BTUM'][$btum]['GAP'] = $value['GAP'];
                $btum++;
            } else  if ($old_data[$key]['MCH_TYPE'] == 'STUM') {
                $data['STUM'][$stum]['MAT_CODE'] = $old_data[$key]['MAT_CODE'];
                $data['STUM'][$stum]['MCH_TYPE'] = $old_data[$key]['MCH_TYPE'];
                $data['STUM'][$stum]['ACT'] = $old_data[$key]['ACT'];
                $data['STUM'][$stum]['PLAN'] = $old_data[$key]['PLAN'];
                $data['STUM'][$stum]['GAP'] = $value['GAP'];
                $stum++;
            } else if ($old_data[$key]['MCH_TYPE'] == 'SBTU') {
                $data['SBTU'][$sbtu]['MAT_CODE'] = $old_data[$key]['MAT_CODE'];
                $data['SBTU'][$sbtu]['MCH_TYPE'] = $old_data[$key]['MCH_TYPE'];
                $data['SBTU'][$sbtu]['ACT'] = $old_data[$key]['ACT'];
                $data['SBTU'][$sbtu]['PLAN'] = $old_data[$key]['PLAN'];
                $data['SBTU'][$sbtu]['GAP'] = $value['GAP'];
                $sbtu++;
            }

            $a++;
        }

        return $data;
    }

    function getDataCuringDetail($ip, $bulan = null, $tahun = null)
    {
        $date_first = $tahun . '-' . $bulan . '-01';
        // $date_last = date('Y-m-d', strtotime('-1 Days', strtotime(date('Y-m-d'))));
        if ($bulan < date('m')) {
            // jika bulan yang di pilih lebih kecil dari bulan sekarang
            $date_last = date("Y-m-t", strtotime("$tahun-$bulan-01"));
        } else {
            $date_last = $tahun . '-' . $bulan . date('-d');
        }
        $range_date = getDatesFromRange($date_first, $date_last);
        arsort($range_date);


        $new_data = [];
        $a = 0;
        foreach ($range_date as $d) {
            $sql_group = "SELECT MD.MAT_CODE, CONVERT(date, PS_DATE) as PS_DATE
                        ,SUM(PS_QUANTITY) as PS_QUANTIY
                    FROM [PCS].[dbo].[DC_PRODUCTION_DATA] as DC
                LEFT JOIN MD_MATERIALS AS MD ON MD.MAT_SAP_CODE = DC.MAT_SAP_CODE
                    LEFT JOIN MD_MACHINES as MDM ON MDM.MCH_CODE = DC.MCH_CODE
                    WHERE DC.PP_CODE = 'V01' 
                    AND MD.MAT_CODE = '" . $ip . "'
                    AND CONVERT(date, PS_DATE) = '" . $d . "'  GROUP BY MD.MAT_CODE, CONVERT(date, PS_DATE) ORDER BY PS_DATE DESC";
            $data_act = $this->pcs->query($sql_group)->getRowArray();

            $data_plan = $this->db->table('planned_curing')->select('ip_code, mch_type, status, CASE WHEN p_date = CONVERT(date, GETDATE()) THEN 
                    ROUND( (qty * ROUND( CAST( (DATEPART(hour, GETDATE()) * 60 + DATEPART(minute, GETDATE()) ) as FLOAT) / 60 , 1) / 24), 0 )
                ELSE qty
            END as qty')->where('ip_code', $ip)->where('p_date', $d)->get()->getRowArray();


            $plan = ($data_plan) ? $data_plan['qty'] : 0;
            $PS_QUANTIY = ($data_act) ? $data_act['PS_QUANTIY'] : 0;
            $mch = ($data_plan) ? $data_plan['mch_type'] : '';
            $status = ($data_plan) ? $data_plan['status'] : '';
            $gap = $PS_QUANTIY - $plan;
            $new_data[$a]['MAT_CODE'] = $ip;
            $new_data[$a]['PS_DATE'] = $d;
            $new_data[$a]['MCH_TYPE'] = $mch;
            $new_data[$a]['STATUS'] = $status;
            $new_data[$a]['ACT'] = $PS_QUANTIY;
            $new_data[$a]['PLAN'] = $plan;
            $new_data[$a]['GAP'] = $gap;
            $a++;
        }
        return $new_data;
    }

    function getChartBuildingDate($start, $end)
    {
        $start = ($start == null) ? date('Y-m-d') : $start;
        $end = ($end == null) ? date('Y-m-d') : $end;
        $sql = "  SELECT CONVERT(date, PS_DATE) as DATE, SUM(PS_QUANTITY) as JUMLAH FROM [PCS].[dbo].[DC_PRODUCTION_DATA]
        WHERE PS_DATE >= '" . $start . "'
        AND PS_DATE <= '" . $end . "'
        AND PP_CODE = 'B02'
        GROUP BY PS_DATE ORDER BY PS_DATE ASC";
        $data = $this->pcs->query($sql)->getResultArray();

        $label = [];
        $count = [];
        foreach ($data as $val) {
            $label[] = $val['DATE'];
            $count[] = $val['JUMLAH'];
        }

        $res['label'] = $label;
        $res['data'] = $count;
        return $res;
    }

    function getDataCuringDate($start, $end)
    {
        $start = ($start == null) ? date('Y-m-d') : $start;
        $end = ($end == null) ? date('Y-m-d') : $end;
        $sql = "SELECT SUM(PS_QUANTITY) as jumlah
                FROM [PCS].[dbo].[DC_PRODUCTION_DATA] WHERE PP_CODE = 'V01' AND CONVERT(date, PS_DATE) >= '" . $start . "' 
                AND CONVERT(date, PS_DATE) <= '" . $end . "'";
        return $this->pcs->query($sql)->getRowArray();
    }

    function getDataInboundDate($start, $end)
    {
        $start = ($start == null) ? date('Y-m-d') : $start;
        $end = ($end == null) ? date('Y-m-d') : $end;
        $sql = "SELECT
        SUM(CMV_PALLET_QTY) AS jumlah
        FROM (SELECT 
        CNT_CODE,
        MAT_VARIANT,
        MAT_SAP_CODE,
        MAT_PART_CLASS,
        COST_CENTER,
        PALLET_TYPE_CODE,
            CMV_BARCODE,
            CMV_CREATE_DATETIME,
            CMV_READ1_DATETIME,
            CMV_READ2_DATETIME,
            CMV_CONSIGNMENT_DATETIME,
            CMV_CONSIGNMENT_FLAG,
            CMV_PALLET_QTY 
            
            FROM CMS_MOVEMENTS 
            UNION ALL
            SELECT 
            CNT_CODE,
        MAT_VARIANT,
        MAT_SAP_CODE,
        MAT_PART_CLASS,
        COST_CENTER,
        PALLET_TYPE_CODE,
            CMV_BARCODE,
            CMV_CREATE_DATETIME,
            CMV_READ1_DATETIME,
            CMV_READ2_DATETIME,
            CMV_CONSIGNMENT_DATETIME,
            CMV_CONSIGNMENT_FLAG,
            CMV_PALLET_QTY 
            
            FROM HIS_CMS_MOVEMENTS
        ) AS MOV
        JOIN MD_MATERIALS AS MAT ON MOV.MAT_SAP_CODE = MAT.MAT_SAP_CODE
        AND MOV.CNT_CODE = MAT.CNT_CODE
        AND MOV.MAT_VARIANT = MAT.MAT_VARIANT
        JOIN CMS_MATERIALS AS CMT ON CMT.MAT_SAP_CODE = MOV.MAT_SAP_CODE
        AND CMT.MAT_VARIANT = MOV.MAT_VARIANT
        AND CMT.CNT_CODE = MOV.CNT_CODE
        AND CMT.MAT_PART_CLASS = MOV.MAT_PART_CLASS
        AND CMT.COST_CENTER = MOV.COST_CENTER
        AND CMT.PALLET_TYPE_CODE = MOV.PALLET_TYPE_CODE
        JOIN (
            SELECT
                SFC_CODE,
                SFS_SUBCODE,
                SFS_DESC
            FROM
                MD_SEMI_FINISHED_SUBCLASSES
            WHERE
                (
                    SFS_PLANT_CODE = null
                    OR null = ''
                    OR null IS NULL
                )
                OR SFS_PLANT_CODE IS NULL
                OR SFS_PLANT_CODE = ''
        ) SFS ON SFS.SFC_CODE = MAT.SFC_CODE
        AND SFS.SFS_SUBCODE = MAT.SFS_SUBCODE 
        --and convert(date,CMV_CONSIGNMENT_DATETIME) >='2023-05-02 00:00:00.000' and  convert(date,CMV_CONSIGNMENT_DATETIME) <'2023-05-06 00:00:00.000'
        JOIN MD_PROCESS_PARAMETERS_ACYCLE_VALUE AS RM ON RM.MAT_SAP_CODE = MOV.MAT_SAP_CODE
        AND ST_CODE = 801
        JOIN WMS_CUSTOMERS AS CS ON CS.CST_CODE = CMT.CST_CODE -- biar cari yang NOT NULL
        WHERE 1 = 1 
        AND convert(date,CMV_CONSIGNMENT_DATETIME) >= '" . $start . "'
        AND convert(date,CMV_CONSIGNMENT_DATETIME) <= '" . $end . "'";
        return $this->pcs->query($sql)->getRowArray();
    }

    public function getDataInbound($tahun = null, $bulan = 1, $week = 0, $brand = null, $rim = null,  $cost_center = null, $mch_type = null, $date = null, $get = null)
    {

        $tahun = ($tahun == null) ? date('Y') : $tahun;
        $sqlweek = "";
        $sqlbulan = "AND MONTH(CMV_CONSIGNMENT_DATETIME) = '" . $bulan . "'";
        $sqlbrand = "";
        $sqlrim = "";
        $sqlmch = "";
        $sqlcc = "";
        $sqldate = "";
        $sqltahun = "";

        // $sqlminusdate = "AND CONVERT(date, CMV_CONSIGNMENT_DATETIME) < CONVERT(date, GETDATE())";
        $sqlminusdate = "AND CONVERT(date, CMV_CONSIGNMENT_DATETIME) < '" . date('Y-m-d') . "'";


        $weeknow = idate('W', strtotime(date('Y-m-d')));
        if ($week != 0) {
            // $sqlweek = "AND ((DATEPART(day, CMV_CONSIGNMENT_DATETIME) -1) / 7) + 1 = '" . $week . "'";
            $sqlweek = "AND DATEPART(iso_week, CMV_CONSIGNMENT_DATETIME)  = '" . $week . "'";
            if ($weeknow == $week) {
                // jika sama maka filter sebelum hari ini
                $sqlweek .= $sqlminusdate;
            }
        }

        $bulannow = date('m');
        if ($bulan == $bulannow) {
            // jika sama maka filter sebelum hari ini

            if ($week != null) {
                if ($week >= $weeknow) {
                    $sqlweek .= $sqlminusdate;
                    // jika sama maka filter sebelum hari ini
                }
            }
        }

        if ($get != null) {
            //    ada dua chart dan weekly biasa
            $sqlweek .= $sqlminusdate;
        }

        if ($brand != null) {
            $sqlbrand = "AND CS.CST_DESC = '" . strtoupper($brand) . "'";
        }

        if ($rim != null) {
            $sqlrim = "AND RM.MD_PPA_VALUE = '" . $rim . "'";
        }

        if ($date != null) {
            $sqldate = "AND CONVERT(date, CMV_CONSIGNMENT_DATETIME) = '" . $date . "'";
        }

        if ($tahun != null) {
            $sqltahun = "AND YEAR(CMV_CONSIGNMENT_DATETIME)= '" . $tahun . "'";
        }

        if ($mch_type != null) {
            $mch_type = strtoupper($mch_type);
            if ($mch_type == 'BTU') {
                // karena ada BTU DAN SBTU
                $sqlmch = "AND (
                                CASE WHEN (SELECT
                                    TOP 1 (
                                        SELECT
                                            TOP 1 MT_CODE
                                        FROM
                                            MD_PROCESS_PARAMETERS as MDRS
                                        WHERE
                                            MDRS.MAT_SAP_CODE = DCC.MAT_SAP_CODE
                                    )
                                FROM
                                    MD_MATERIALS as DCC
                                WHERE
                                    DCC.CNT_CODE = 'CAH'
                                    AND DCC.MAT_CODE = MAT.MAT_CODE
                                ORDER BY
                                    MAT_IMPORT_TIMESTAMP DESC)  IS NULL THEN (SELECT
                                    TOP 1 (
                                        SELECT
                                            TOP 1 MT_CODE
                                        FROM
                                            MD_PROCESS_PARAMETERS as MDRS
                                        WHERE
                                            MDRS.MAT_SAP_CODE = DCC.MAT_SAP_CODE
                                    )
                                FROM
                                    MD_MATERIALS as DCC
                                WHERE
                                    DCC.CNT_CODE = 'CAH'
                                    AND DCC.MAT_CODE = MAT.MAT_CODE
                                ORDER BY
                                    MAT_IMPORT_TIMESTAMP ASC) ELSE (SELECT
                                    TOP 1 (
                                        SELECT
                                            TOP 1 MT_CODE
                                        FROM
                                            MD_PROCESS_PARAMETERS as MDRS
                                        WHERE
                                            MDRS.MAT_SAP_CODE = DCC.MAT_SAP_CODE
                                    )
                                FROM
                                    MD_MATERIALS as DCC
                                WHERE
                                    DCC.CNT_CODE = 'CAH'
                                    AND DCC.MAT_CODE = MAT.MAT_CODE
                                ORDER BY
                                    MAT_IMPORT_TIMESTAMP DESC) END
                            ) IN ('SBTU', 'BTUM')";
            } else {
                $sqlmch = "AND (
                            CASE WHEN (SELECT
                                TOP 1 (
                                    SELECT
                                        TOP 1 MT_CODE
                                    FROM
                                        MD_PROCESS_PARAMETERS as MDRS
                                    WHERE
                                        MDRS.MAT_SAP_CODE = DCC.MAT_SAP_CODE
                                )
                            FROM
                                MD_MATERIALS as DCC
                            WHERE
                                DCC.CNT_CODE = 'CAH'
                                AND DCC.MAT_CODE = MAT.MAT_CODE
                            ORDER BY
                                MAT_IMPORT_TIMESTAMP DESC)  IS NULL THEN (SELECT
                                TOP 1 (
                                    SELECT
                                        TOP 1 MT_CODE
                                    FROM
                                        MD_PROCESS_PARAMETERS as MDRS
                                    WHERE
                                        MDRS.MAT_SAP_CODE = DCC.MAT_SAP_CODE
                                )
                            FROM
                                MD_MATERIALS as DCC
                            WHERE
                                DCC.CNT_CODE = 'CAH'
                                AND DCC.MAT_CODE = MAT.MAT_CODE
                            ORDER BY
                                MAT_IMPORT_TIMESTAMP ASC) ELSE (SELECT
                                TOP 1 (
                                    SELECT
                                        TOP 1 MT_CODE
                                    FROM
                                        MD_PROCESS_PARAMETERS as MDRS
                                    WHERE
                                        MDRS.MAT_SAP_CODE = DCC.MAT_SAP_CODE
                                )
                            FROM
                                MD_MATERIALS as DCC
                            WHERE
                                DCC.CNT_CODE = 'CAH'
                                AND DCC.MAT_CODE = MAT.MAT_CODE
                            ORDER BY
                                MAT_IMPORT_TIMESTAMP DESC) END
                        ) LIKE '%" . $mch_type . "%'";
            }
        }

        if ($cost_center != null) {
            $sqlcc = "AND MOV.COST_CENTER = '" . $cost_center . "'";
        }

        $sqlUnion = "SELECT
                        SUM(CMV_PALLET_QTY) AS INBOUND
                        FROM (SELECT 
                        CNT_CODE,
                        MAT_VARIANT,
                        MAT_SAP_CODE,
                        MAT_PART_CLASS,
                        COST_CENTER,
                        PALLET_TYPE_CODE,
                            CMV_BARCODE,
                            CMV_CREATE_DATETIME,
                            CMV_READ1_DATETIME,
                            CMV_READ2_DATETIME,
                            CMV_CONSIGNMENT_DATETIME,
                            CMV_CONSIGNMENT_FLAG,
                            CMV_PALLET_QTY 
                            
                            FROM CMS_MOVEMENTS 
                            UNION ALL
                            SELECT 
                            CNT_CODE,
                        MAT_VARIANT,
                        MAT_SAP_CODE,
                        MAT_PART_CLASS,
                        COST_CENTER,
                        PALLET_TYPE_CODE,
                            CMV_BARCODE,
                            CMV_CREATE_DATETIME,
                            CMV_READ1_DATETIME,
                            CMV_READ2_DATETIME,
                            CMV_CONSIGNMENT_DATETIME,
                            CMV_CONSIGNMENT_FLAG,
                            CMV_PALLET_QTY 
                            
                            FROM HIS_CMS_MOVEMENTS
                        ) AS MOV
                        JOIN MD_MATERIALS AS MAT ON MOV.MAT_SAP_CODE = MAT.MAT_SAP_CODE
                        AND MOV.CNT_CODE = MAT.CNT_CODE
                        AND MOV.MAT_VARIANT = MAT.MAT_VARIANT
                        JOIN CMS_MATERIALS AS CMT ON CMT.MAT_SAP_CODE = MOV.MAT_SAP_CODE
                        AND CMT.MAT_VARIANT = MOV.MAT_VARIANT
                        AND CMT.CNT_CODE = MOV.CNT_CODE
                        AND CMT.MAT_PART_CLASS = MOV.MAT_PART_CLASS
                        AND CMT.COST_CENTER = MOV.COST_CENTER
                        AND CMT.PALLET_TYPE_CODE = MOV.PALLET_TYPE_CODE
                        JOIN (
                            SELECT
                                SFC_CODE,
                                SFS_SUBCODE,
                                SFS_DESC
                            FROM
                                MD_SEMI_FINISHED_SUBCLASSES
                            WHERE
                                (
                                    SFS_PLANT_CODE = null
                                    OR null = ''
                                    OR null IS NULL
                                )
                                OR SFS_PLANT_CODE IS NULL
                                OR SFS_PLANT_CODE = ''
                        ) SFS ON SFS.SFC_CODE = MAT.SFC_CODE
                        AND SFS.SFS_SUBCODE = MAT.SFS_SUBCODE 
                        --and convert(date,CMV_CONSIGNMENT_DATETIME) >='2023-05-02 00:00:00.000' and  convert(date,CMV_CONSIGNMENT_DATETIME) <'2023-05-06 00:00:00.000'
                        JOIN MD_PROCESS_PARAMETERS_ACYCLE_VALUE AS RM ON RM.MAT_SAP_CODE = MOV.MAT_SAP_CODE
                        AND ST_CODE = 801
                        JOIN WMS_CUSTOMERS AS CS ON CS.CST_CODE = CMT.CST_CODE -- biar cari yang NOT NULL
                        WHERE 1 = 1 
                        " . $sqlbrand . "
                        " . $sqlweek . "
                        " . $sqlbulan . "
                        " . $sqlrim . "
                        " . $sqlmch . "
                        " . $sqlcc . "
                        " . $sqldate . "
                        " . $sqltahun . "
                        ";

        // var_dump($sqlUnion);
        // die;

        $sql = "SELECT
                        SUM(CMV_PALLET_QTY) AS INBOUND
                    FROM
                        CMS_MOVEMENTS AS MOV
                        JOIN MD_MATERIALS AS MAT ON MOV.MAT_SAP_CODE = MAT.MAT_SAP_CODE
                        AND MOV.CNT_CODE = MAT.CNT_CODE
                        AND MOV.MAT_VARIANT = MAT.MAT_VARIANT
                        JOIN CMS_MATERIALS AS CMT ON CMT.MAT_SAP_CODE = MOV.MAT_SAP_CODE
                        AND CMT.MAT_VARIANT = MOV.MAT_VARIANT
                        AND CMT.CNT_CODE = MOV.CNT_CODE
                        AND CMT.MAT_PART_CLASS = MOV.MAT_PART_CLASS
                        AND CMT.COST_CENTER = MOV.COST_CENTER
                        AND CMT.PALLET_TYPE_CODE = MOV.PALLET_TYPE_CODE
                        JOIN (
                            SELECT
                                SFC_CODE,
                                SFS_SUBCODE,
                                SFS_DESC
                            FROM
                                MD_SEMI_FINISHED_SUBCLASSES
                            WHERE
                                (
                                    SFS_PLANT_CODE = null
                                    OR null = ''
                                    OR null IS NULL
                                )
                                OR SFS_PLANT_CODE IS NULL
                                OR SFS_PLANT_CODE = ''
                        ) SFS ON SFS.SFC_CODE = MAT.SFC_CODE
                        AND SFS.SFS_SUBCODE = MAT.SFS_SUBCODE 
                        --and convert(date,CMV_CONSIGNMENT_DATETIME) >='2023-05-02 00:00:00.000' and  convert(date,CMV_CONSIGNMENT_DATETIME) <'2023-05-06 00:00:00.000'
                        JOIN MD_PROCESS_PARAMETERS_ACYCLE_VALUE AS RM ON RM.MAT_SAP_CODE = MOV.MAT_SAP_CODE
                        AND ST_CODE = 801
                        JOIN WMS_CUSTOMERS AS CS ON CS.CST_CODE = CMT.CST_CODE -- biar cari yang NOT NULL
                    WHERE 1 = 1
                        --CMV_CONSIGNMENT_DATETIME IS NOT NULL 
                        " . $sqlbrand . "
                        " . $sqlweek . "
                        " . $sqlbulan . "
                        " . $sqlrim . "
                        " . $sqlmch . "
                        " . $sqlcc . "
                        " . $sqldate . "
                        " . $sqltahun . "
            ";
        $data = $this->pcs->query($sqlUnion)->getRowArray();

        return $data;
    }

    public function getDataInboundRimList($tahun = null, $bulan = 1, $week = 0, $brand = null, $rim = null)
    {
        $tahun = ($tahun == null) ? date('Y') : $tahun;
        if (getenv('APP_PROD') == 'LOCAL') {
            $builder = $this->pcs->table($this->table);
            $builder->select('RIM');
            if ($week != 0) {
                $builder->where('WEEK', $week);
            }
            if ($brand != null) {
                $builder->where('BRAND', strtoupper($brand));
            }



            $builder->where('MONTH(CMV_CONSIGNMENT_DATETIME)', $bulan);
            $builder->groupBy('RIM');
            $builder->orderBy('RIM', 'DESC');
            $data = $builder->get()->getResultArray();
            // $data = $this->pcs->table($this->table)->select('RIM')->groupBy('RIM')->get()->getResultArray();
        } else {
            $sqlweek = "";
            $sqlbulan = "AND MONTH(CMV_CONSIGNMENT_DATETIME) = '" . $bulan . "'";
            $sqlbrand = "";
            $sqlrim = "";

            if ($week != 0) {
                $sqlweek = "AND ((DATEPART(day, CMV_CONSIGNMENT_DATETIME) -1) / 7) + 1 = '" . $week . "'";
            }

            if ($brand != null) {
                $sqlbrand = "AND CS.CST_DESC = '" . strtoupper($brand) . "'";
            }

            if ($rim != null) {
                $sqlrim = "AND RM.MD_PPA_VALUE = '" . $rim . "'";
            }




            $sql = "SELECT
                        RM.MD_PPA_VALUE AS RIM
                    FROM
                    (SELECT 
                        CNT_CODE,
                        MAT_VARIANT,
                        MAT_SAP_CODE,
                        MAT_PART_CLASS,
                        COST_CENTER,
                        PALLET_TYPE_CODE,
                            CMV_BARCODE,
                            CMV_CREATE_DATETIME,
                            CMV_READ1_DATETIME,
                            CMV_READ2_DATETIME,
                            CMV_CONSIGNMENT_DATETIME,
                            CMV_CONSIGNMENT_FLAG,
                            CMV_PALLET_QTY 
                            
                            FROM CMS_MOVEMENTS 
                            UNION ALL
                            SELECT 
                            CNT_CODE,
                        MAT_VARIANT,
                        MAT_SAP_CODE,
                        MAT_PART_CLASS,
                        COST_CENTER,
                        PALLET_TYPE_CODE,
                            CMV_BARCODE,
                            CMV_CREATE_DATETIME,
                            CMV_READ1_DATETIME,
                            CMV_READ2_DATETIME,
                            CMV_CONSIGNMENT_DATETIME,
                            CMV_CONSIGNMENT_FLAG,
                            CMV_PALLET_QTY 
                            
                            FROM HIS_CMS_MOVEMENTS
                        ) AS MOV
                        JOIN MD_MATERIALS AS MAT ON MOV.MAT_SAP_CODE = MAT.MAT_SAP_CODE
                        AND MOV.CNT_CODE = MAT.CNT_CODE
                        AND MOV.MAT_VARIANT = MAT.MAT_VARIANT
                        JOIN CMS_MATERIALS AS CMT ON CMT.MAT_SAP_CODE = MOV.MAT_SAP_CODE
                        AND CMT.MAT_VARIANT = MOV.MAT_VARIANT
                        AND CMT.CNT_CODE = MOV.CNT_CODE
                        AND CMT.MAT_PART_CLASS = MOV.MAT_PART_CLASS
                        AND CMT.COST_CENTER = MOV.COST_CENTER
                        AND CMT.PALLET_TYPE_CODE = MOV.PALLET_TYPE_CODE
                        JOIN (
                            SELECT
                                SFC_CODE,
                                SFS_SUBCODE,
                                SFS_DESC
                            FROM
                                MD_SEMI_FINISHED_SUBCLASSES
                            WHERE
                                (
                                    SFS_PLANT_CODE = null
                                    OR null = ''
                                    OR null IS NULL
                                )
                                OR SFS_PLANT_CODE IS NULL
                                OR SFS_PLANT_CODE = ''
                        ) SFS ON SFS.SFC_CODE = MAT.SFC_CODE
                        AND SFS.SFS_SUBCODE = MAT.SFS_SUBCODE 
                        --and convert(date,CMV_CONSIGNMENT_DATETIME) >='2023-05-02 00:00:00.000' and  convert(date,CMV_CONSIGNMENT_DATETIME) <'2023-05-06 00:00:00.000'
                        JOIN MD_PROCESS_PARAMETERS_ACYCLE_VALUE AS RM ON RM.MAT_SAP_CODE = MOV.MAT_SAP_CODE
                        AND ST_CODE = 801
                        JOIN WMS_CUSTOMERS AS CS ON CS.CST_CODE = CMT.CST_CODE -- biar cari yang NOT NULL
                    WHERE 1 = 1
                        --CMV_CONSIGNMENT_DATETIME IS NOT NULL 
                        " . $sqlbrand . "
                        " . $sqlweek . "
                        " . $sqlbulan . "
                        " . $sqlrim . "
                    GROUP BY RM.MD_PPA_VALUE
                    ORDER BY
                    RM.MD_PPA_VALUE DESC
            ";
            $data = $this->pcs->query($sql)->getResultArray();
        }

        return $data;
    }
}
