<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{

    protected $table;

    protected $jointable1;

    public $primarykey = 'id';

    protected $table_prefix = "test";

    protected $requestresp = "atom_response";

    protected $merchantId;

    protected $empId;

    public function __construct($prefix = '')
    {

        if (Auth::guard('employee')->check()) {
            $this->table_prefix = "live";
        } elseif (Auth::guard("merchantemp")->check()) {

            $this->table_prefix = "live";

            $this->merchantId = Auth::guard("merchantemp")->user()->created_merchant;

            $this->empId = Auth::guard("merchantemp")->user()->id;
        } else {

            if (Auth::check() && Auth::user()->app_mode == 1) {
                $this->table_prefix = "live";
                $this->merchantId = Auth::user()->id;
            }
        }
        if ($prefix) {

            $this->table_prefix = $prefix;
        }

        $this->table = $this->table_prefix . "_payment";

        $this->jointable1 = $this->table_prefix . "_order";
    }



    public function setTablePrefix($prifix)
    {
        $this->table_prefix = $prifix;
    }

    public function get_all_payments($filters = array())
    {

        $where_condition = 'payment.created_merchant=:id';
        $apply_condition['id'] =  Auth::user()->id;

        if (!empty($filters)) {
            if (!empty($filters["transaction_gid"])) {
                $where_condition .=  ' AND payment.transaction_gid=:pay_gid';
                $apply_condition['pay_gid'] = $filters["transaction_gid"];
            }
            if (!empty($filters["payment_status"])) {
                $where_condition .=  ' AND payment.transaction_status=:pay_status';
                $apply_condition['pay_status'] = $filters["payment_status"];
            }
            if (!empty($filters["payment_email"])) {
                $where_condition .=  ' AND payment.payment_email=:pay_email';
                $apply_condition['pay_email'] = $filters["payment_email"];
            }
        }


        // return DB::select('SELECT payment_gid,'.$this->table_prefix.'_order.order_gid,payment_method,payment_email,payment_contact,payment_amount,payment_status,'.$this->table_prefix.'_payment.created_date FROM '.$this->table_prefix.'_payment 
        // LEFT JOIN '.$this->table_prefix.'_order ON '.$this->table_prefix.'_order.id = '.$this->table_prefix.'_payment.order_id WHERE '.$this->table_prefix.'_payment.created_merchant=:id 
        // '.$where_condition,['id'=>Auth::user()->id]);
        // DB::enableQueryLog();

        $sSql = "SELECT payment.id,transaction_gid,`order`.order_gid ,transaction_email,transaction_contact,transaction_amount,transaction_status,DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date,
            IF( ISNULL(payment.transaction_date) ,payment.created_date,payment.transaction_date) as transaction_date,
           IF(merchant_business.state=36,'IGST&SGST(%9+%9)','GST(%18)') as transaction_gst,
            IF(payment.created_employee <> 0,merchant_employee.employee_name,merchant.name) as created_merchant,merchant.merchant_gid,merchant.name,transaction_mode,
            transaction_type  ,`order`.order_gid as orderId,
            payment.udf1 as merchantorderId  ,
            payment.transaction_username as uname,
           payment.transaction_email as uemail,
           payment.transaction_contact as ucontact,payment.bank_ref_no,
         payment.transaction_ip as uip,
         merchant.merchant_gid,merchant.id as merchant_id 
         FROM " . $this->table_prefix . "_payment payment
        LEFT JOIN " . $this->table_prefix . "_order `order` ON `order`.id = payment.order_id 
        INNER JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_employee ON merchant_employee.id = payment.created_employee
         LEFT JOIN merchant_business ON merchant_business.created_merchant = payment.created_merchant 
        WHERE " . $where_condition . " ORDER BY payment.created_date DESC ";

        return DB::select($sSql, $apply_condition);

        // dd(DB::getQueryLog());

    }

    public function get_payments_by_date($fromdate, $todate, $filters = array())
    {
        $payment = new \App\Payment;
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";

        $transactionResult = $payment->select([
            $paymentTable . '.id',
            'transaction_gid',
            $paymentTable . '.udf1 as merchantorderId',
            'transaction_type',
            $paymentTable . '.created_merchant',
            'order_id',
            $paymentTable . '.created_date',
            'merchant_business.state',
            'transaction_username',
            'transaction_email',
            'transaction_contact',
            'transaction_amount',
            'transaction_status',
            'transaction_mode',
            DB::raw('IF( ISNULL(transaction_date) ,' . $paymentTable . '.created_date,transaction_date) as transaction_date'),
            'merchant_ip',
            'transaction_gst_value',
            'transaction_gst_charged_per',
            'transaction_gst_charged_amount',
            'transaction_adjustment_charged_per',
            'transaction_adjustment_charged_amount',
            'transaction_total_charged_amount',
            'transaction_total_adjustment',
            'bank_ref_no'
        ])
            ->join($order . " as order", 'order.id', '=', $paymentTable . '.order_id')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') >='" . $fromdate . "'")
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') <='" . $todate . "'")
            ->where($paymentTable . ".created_merchant", Auth::user()->id)
            ->where($paymentTable . ".transaction_status", 'success')
            ->orderBy($paymentTable . ".id", 'asc');
        $results = $transactionResult->get();
        return $results;
    }


    public function get_all_payments_by_date($fromdate, $todate, $filters = array())
    {


        $where_condition = 'DATE_FORMAT(payment.created_date,"%Y-%m-%d %H:%i:%s")>=:fromdate AND DATE_FORMAT(payment.created_date,"%Y-%m-%d %H:%i:%s")<=:todate AND payment.created_merchant=:id';
        $apply_condition['id'] =  Auth::user()->id;
        $apply_condition['fromdate'] = $fromdate;
        $apply_condition['todate'] = $todate;

        if (!empty($filters)) {
            if (!empty($filters["transaction_gid"])) {
                $where_condition .=  ' AND payment.transaction_gid=:pay_gid';
                $apply_condition['pay_gid'] = $filters["transaction_gid"];
            }
            if (!empty($filters["payment_status"])) {
                $where_condition .=  ' AND payment.transaction_status=:pay_status';
                $apply_condition['pay_status'] = $filters["payment_status"];
            }
            if (!empty($filters["payment_email"])) {
                $where_condition .=  ' AND payment.payment_email=:pay_email';
                $apply_condition['pay_email'] = $filters["payment_email"];
            }
        }


        // return DB::select('SELECT payment_gid,'.$this->table_prefix.'_order.order_gid,payment_method,payment_email,payment_contact,payment_amount,payment_status,'.$this->table_prefix.'_payment.created_date FROM '.$this->table_prefix.'_payment 
        // LEFT JOIN '.$this->table_prefix.'_order ON '.$this->table_prefix.'_order.id = '.$this->table_prefix.'_payment.order_id WHERE '.$this->table_prefix.'_payment.created_merchant=:id 
        // '.$where_condition,['id'=>Auth::user()->id]);
        // DB::enableQueryLog();

        $sSql = "SELECT payment.id,transaction_gid,`order`.order_gid ,transaction_email,transaction_contact,transaction_amount,transaction_status,DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date,
            IF( ISNULL(payment.transaction_date) ,payment.created_date,payment.transaction_date) as transaction_date,
           IF(merchant_business.state=36,'IGST&SGST(%9+%9)','GST(%18)') as transaction_gst,
            IF(payment.created_employee <> 0,merchant_employee.employee_name,merchant.name) as created_merchant,merchant.merchant_gid,merchant.name,transaction_mode,
            transaction_type  ,`order`.order_gid as orderId,
            payment.udf1 as merchantorderId  ,
            payment.transaction_username as uname,
           payment.transaction_email as uemail,
           payment.transaction_contact as ucontact,payment.bank_ref_no,
         payment.transaction_ip as uip,
         merchant.merchant_gid,merchant.id as merchant_id ,
          payment.merchant_ip ,
          transaction_gst_value,transaction_gst_charged_per,transaction_gst_charged_amount,transaction_adjustment_charged_per,transaction_adjustment_charged_amount,transaction_total_charged_amount,transaction_total_adjustment,refund.refund_gid,refund.refund_status,refund.created_date as refunded_at,
          payment.settlement_brief_gid
         FROM " . $this->table_prefix . "_payment payment
        LEFT JOIN " . $this->table_prefix . "_order `order` ON `order`.id = payment.order_id 
        LEFT JOIN " . $this->table_prefix . "_refund `refund` ON `refund`.payment_id = payment.id 
        INNER JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_employee ON merchant_employee.id = payment.created_employee
         LEFT JOIN merchant_business ON merchant_business.created_merchant = payment.created_merchant 
        WHERE " . $where_condition . " ORDER BY payment.created_date DESC ";

        return DB::select($sSql, $apply_condition);

        // dd(DB::getQueryLog());

    }

    public function get_all_paymentsbackup()
    {
        return DB::table($this->table . ' as payment')->select(
            "payment.id",
            "transaction_gid",
            "order.order_gid",
            "transaction_email",
            "transaction_contact",
            "transaction_amount",
            "transaction_status",
            DB::raw('DATE_FORMAT(payment.created_date,"%d-%m-%Y %h:%i:%s %p") as created_date')
        )
            ->leftJoin($this->jointable1 . ' as order', 'order.id', '=', 'payment.order_id')
            ->where('payment.created_merchant', '=', Auth::user()->id)
            ->orderByDesc('payment.created_date')->simplePaginate(10);
    }


    public function get_payment($id)
    {
        $where_condition = "payment.id=:id AND payment.created_merchant=:merchant_id";
        $apply_condition["id"] = $id;
        $apply_condition["merchant_id"] = $this->merchantId;

        $query = 'SELECT transaction_gid,`order`.order_gid,transaction_email,transaction_contact,transaction_amount,IFNULL(transaction_status,"") as transaction_status,DATE_FORMAT(payment.created_date,"%d-%m-%Y %h:%i:%s %p") as created_date  FROM ' . $this->table_prefix . '_payment payment
        LEFT JOIN ' . $this->table_prefix . '_order `order` ON `order`.id = payment.order_id WHERE';

        return DB::select($query . " " . $where_condition, $apply_condition);
    }

    public function get_dashboard_payments($from_date = "", $to_date = "")
    {


        $limit_clause = "";
        $where_condition = 'payment.created_merchant=:id';
        $apply_condition['id'] =  Auth::user()->id;

        if (!empty($from_date)) {
            $where_condition .=  ' AND DATE_FORMAT(payment.created_date,"%Y-%m-%d")>=:from_date';
            $apply_condition['from_date'] = $from_date;
        }
        if (!empty($to_date)) {
            $where_condition .=  ' AND DATE_FORMAT(payment.created_date,"%Y-%m-%d")<=:to_date';
            $apply_condition['to_date'] = $to_date;
        }

        //DB::enableQueryLog();

        return DB::select('SELECT transaction_gid,transaction_email,transaction_contact,transaction_amount,transaction_status,DATEDIFF(now(),payment.created_date) as date_diff FROM ' . $this->table_prefix . '_payment payment
        WHERE ' . $where_condition . ' ORDER BY payment.created_date DESC ' . $limit_clause, $apply_condition);
        //dd(DB::getQueryLog());

    }




    public function graph_amount_of_payments($from_date = "", $to_date = "")
    {
        $where_condition = "payment.created_merchant=:id AND transaction_status='success'";
        $apply_condition['id'] =  Auth::user()->id;

        if (!empty($from_date)) {
            $where_condition .=  " AND payment.created_date >= :from_date";
            $apply_condition['from_date'] = $from_date;
        }
        if (!empty($to_date)) {
            $where_condition .=  " AND payment.created_date <= :to_date";
            $apply_condition['to_date'] = $to_date;
        }

        $total_payments_amount = "SELECT sum(transaction_amount) as amount, MONTHNAME(created_date) as month FROM $this->table as payment WHERE";

        return DB::select($total_payments_amount . " " . $where_condition . " GROUP BY MONTH(created_date)", $apply_condition);
    }



    public function graph_success_rate($from_date = "", $to_date = "")
    {
        // $convert = Carbon::parse($to_date)->format('Y-m-d H:i:s');

        $data = DB::table('live_payment');

        if (!empty($from_date)) {
            $data = $data->whereDate('created_date', '>=',  Carbon::parse($from_date)->format('Y-m-d'));
        }
        if (!empty($to_date)) {
            $data = $data->whereDate('created_date', '<=',  Carbon::parse($to_date)->format('Y-m-d'));
        }

        $data = $data->select('transaction_status', DB::raw('count(*) as total'))
            ->groupBy('transaction_status')
            ->get();

        return $data;
    }

    public function summary_data_count($from_date = "", $to_date = "")
    {
        $this->table = $this->table_prefix . "_payment";
        $data = DB::table($this->table);
        $data = $data->where('created_merchant', '=', Auth::user()->id);

        if (!empty($from_date)) {
            $data = $data->where('created_date', '>=', Carbon::parse($from_date)->format('Y-m-d H:i:s'));
        }
        if (!empty($to_date)) {
            $data = $data->where('created_date', '<=', Carbon::parse($to_date)->format('Y-m-d H:i:s'));
        }

        $data = $data->select('transaction_status', DB::raw('count(*) as total'))
            ->groupBy('transaction_status')
            ->get();

        return $data;
    }


    public function summary_payment_mode($from_date = "", $to_date = "")
    {
        $this->table = $this->table_prefix . "_payment";
        $data = DB::table($this->table);

        $data = $data->where('created_merchant', '=', Auth::user()->id);
        $data = $data->where('transaction_status', "success");

        if (!empty($from_date)) {
            $data = $data->where('created_date', '>=', Carbon::parse($from_date)->format('Y-m-d H:i:s'));
        }
        if (!empty($to_date)) {
            $data = $data->where('created_date', '<=', Carbon::parse($to_date)->format('Y-m-d H:i:s'));
        }

        $data = $data->select('transaction_mode', DB::raw('sum(transaction_amount) as total'))
            ->groupBy('transaction_mode')
            ->get();

        foreach ($data as $datas) {
            if ($datas->transaction_mode === 'CC') {
                $datas->transaction_mode = 'Credit Card';
            }

            if ($datas->transaction_mode === null) {
                $datas->transaction_mode = 'Cancelled';
            }

            if ($datas->transaction_mode === 'NB') {
                $datas->transaction_mode = 'Net Banking';
            }

            if ($datas->transaction_mode === 'MW') {
                $datas->transaction_mode = 'Merchant Wallet';
            }
        }

        return $data;
    }


    public function summary_payment_platform($from_date = "", $to_date = "")
    {
        $this->table = $this->table_prefix . "_payment";
        $data = DB::table($this->table);

        $data = $data->where('created_merchant', '=', Auth::user()->id);
        $data = $data->where('transaction_status', "success");

        if (!empty($from_date)) {
            $data = $data->where('created_date', '>=', Carbon::parse($from_date)->format('Y-m-d H:i:s'));
        }
        if (!empty($to_date)) {
            $data = $data->where('created_date', '<=', Carbon::parse($to_date)->format('Y-m-d H:i:s'));
        }

        $data = $data->select('merchant_device', DB::raw('sum(transaction_amount) as total'))
            ->where('merchant_device', '!=', '')
            ->where('merchant_device', '!=', null)
            ->groupBy('merchant_device')
            ->get();

        return $data;
    }

    public function graph_no_of_payments_of_merchant_by_status($from_date = "", $to_date = "")
    {
        $data = DB::table('live_payment');

        if (!empty($from_date)) {
            $data = $data->where('created_date', '>=', Carbon::parse($from_date)->format('Y-m-d H:i:s'));
        }
        if (!empty($to_date)) {
            $data = $data->where('created_date', '<=', Carbon::parse($to_date)->format('Y-m-d H:i:s'));
        }

        $data->where('created_merchant', '=', Auth::user()->id);

        // Filter by transaction_status 'success' and 'failed'
        $data = $data->whereIn('transaction_status', ['success', 'failed']);

        $data = $data->select('transaction_status', DB::raw('count(*) as total'))
            ->groupBy('transaction_status')
            ->get();

        return $data;
    }




    public function graph_payment_mode($from_date = "", $to_date = "", $merchantid = 0)
    {

        $data = DB::table('live_payment');

        if (!empty($from_date)) {
            $data = $data->where('created_date', '>=',  Carbon::parse($from_date)->format('Y-m-d H:i:s'));
        }
        if (!empty($to_date)) {
            $data = $data->where('created_date', '<=',  Carbon::parse($to_date)->format('Y-m-d H:i:s'));
        }

        $data = $data->where('transaction_status', "success");

        if ($merchantid) {
            $data = $data->where('created_merchant', $merchantid);
        }

        $data = $data->select('transaction_mode', DB::raw('sum(transaction_amount) as total'))
            ->groupBy('transaction_mode')
            ->get();



        foreach ($data as $datas) {
            if ($datas->transaction_mode === 'CC') {
                $datas->transaction_mode = 'Credit Card';
            }

            if ($datas->transaction_mode === null) {
                $datas->transaction_mode = 'Cancelled';
            }


            if ($datas->transaction_mode === 'NB') {
                $datas->transaction_mode = 'Net Banking';
            }


            if ($datas->transaction_mode === 'MW') {
                $datas->transaction_mode = 'Merchant Wallet';
            }
        }



        return $data;
    }

    public function graph_no_of_payments_by_status($from_date = "", $to_date = "", $merchantid = 0)
    {


        $data = DB::table('live_payment');

        if (!empty($from_date)) {
            $data = $data->where('created_date', '>=',  Carbon::parse($from_date)->format('Y-m-d H:i:s'));
        }
        if (!empty($to_date)) {
            $data = $data->where('created_date', '<=',  Carbon::parse($to_date)->format('Y-m-d H:i:s'));
        }

        if ($merchantid) {
            $data = $data->where('created_merchant', $merchantid);
        }

        $data = $data->select('transaction_status', DB::raw('count(*) as total'))
            ->groupBy('transaction_status')
            ->get();

        return $data;
    }

    public function graph_no_of_payments($from_date = "", $to_date = "")
    {
        $where_condition = "payment.created_merchant=:id AND transaction_status='success'";
        $apply_condition['id'] = Auth::user()->id;

        if (!empty($from_date)) {
            $where_condition .= " AND payment.created_date >= :from_date";
            $apply_condition['from_date'] = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        }
        if (!empty($to_date)) {
            $where_condition .= " AND payment.created_date <= :to_date";
            $apply_condition['to_date'] = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        }

        $total_payments_amount = "SELECT COUNT(1) as no_of_transactions, MONTHNAME(created_date) as month FROM $this->table as payment WHERE";

        return DB::select($total_payments_amount . " " . $where_condition . " GROUP BY MONTH(created_date)", $apply_condition);
    }


    public function current_transaction_amount()
    {

        $query = "SELECT SUM(transaction_amount) as current_amount FROM $this->table WHERE transaction_status='success' AND adjustment_done='N'
        AND created_merchant=:merchant_id";
        $apply_condition["merchant_id"] = Auth::user()->id;
        return DB::select($query, $apply_condition);
    }

    public function total_transaction_amount($merchant_id)
    {
        $query = "SELECT SUM(transaction_total_adjustment) as current_amount FROM live_payment WHERE transaction_status='success' AND adjustment_done='N'
        AND created_merchant=:merchant_id";
        $apply_condition["merchant_id"] = $merchant_id;
        return DB::select($query, $apply_condition);
    }


    public function get_merchant_transactions($id)
    {

        $where_condition = "created_merchant=:id AND adjustment_done='N' AND transaction_status='success' ORDER BY created_date DESC";
        $apply_condition["id"] = $id;

        $query = "SELECT transaction_gid FROM live_payment WHERE";

        return DB::select($query . " " . $where_condition, $apply_condition);
    }

    public function get_transactions_details($transaction_id)
    {

        $where_condition = "transaction_gid=:id AND adjustment_done='N' AND transaction_status='success'";
        $apply_condition["id"] = $transaction_id;

        $query = "SELECT IFNULL(mmp_txn,'') as mmp_txn,IFNULL(amt,'') amt,IFNULL(bank_txn,'') bank_txn,IFNULL(bank_name,'') bank_name,IFNULL(discriminator,'') discriminator,IFNULL(DATE_FORMAT(transaction_date,'%Y-%m-%d'),'') transaction_date FROM live_payment LEFT JOIN  
        $this->requestresp ON $this->requestresp.mer_txn = live_payment.transaction_gid WHERE";

        return DB::select($query . " " . $where_condition, $apply_condition);
    }

    public function update_transaction_adjustment($transaction_id)
    {

        return DB::table("live_payment")->where(["transaction_gid" => $transaction_id])->update(["adjustment_done" => 'Y']);
    }


    public function update_transaction_adjustment_charges($where, $updatedata)
    {

        return DB::table("live_payment")->where($where)->update($updatedata);
    }


    public function live_success_transactions($filter)
    {

        $where_condition = "";
        $apply_condition = [];

        if (!empty($filter["transaction_date"])) {
            $where_condition .= " AND DATE_FORMAT(transaction_date,'%Y-%m-%d')=:d";
            $apply_condition["d"] = $filter["transaction_date"];
        }

        if (!empty($filter["merchant_id"])) {
            $where_condition .= " AND created_merchant=:mid";
            $apply_condition["mid"] = $filter["merchant_id"];
        }

        if (!empty($filter["transaction_gid"])) {
            $where_condition .= " AND transaction_gid=:tid";
            $apply_condition["tid"] = $filter["transaction_gid"];
        }

        //DB::enableQueryLog();

        $query = "SELECT transaction_gid,transaction_amount,DATE_FORMAT(transaction_date,'%Y-%m-%d') as transaction_date,vendor_transaction_id,transaction_mode FROM live_payment WHERE transaction_status='success' AND adjustment_done='N' $where_condition";

        //dd(DB::getQueryLog());

        return DB::select($query, $apply_condition);
    }


    public function get_emp_payments($merchantId, $empId)
    {


        $where_condition = 'payment.created_merchant=:id AND payment.created_employee=:empid';
        $apply_condition['id'] = $merchantId;
        $apply_condition['empid'] = $empId;

        //DB::enableQueryLog();

        $query = "SELECT payment.id,transaction_gid,`order`.order_gid,transaction_email,transaction_contact,transaction_amount,transaction_status,DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date  FROM live_payment payment LEFT JOIN live_order `order` ON `order`.id = payment.order_id WHERE $where_condition ORDER BY payment.created_date DESC";

        return DB::select($query, $apply_condition);

        //dd(DB::getQueryLog());    

    }

    public function get_transactions_bydate($filters = array())
    {


        $where_condition = "1=:id ";
        $apply_condition["id"] = "1";
        //dd($filters);
        $where_condition .= '  AND transaction_status ="success" AND adjustment_done="N"';

        if (!empty($filters["merchant_id"]) && $filters["merchant_id"] != '') {
            $where_condition .=  ' AND payment.created_merchant=:created_merchant';
            $apply_condition['created_merchant'] = $filters["merchant_id"];
        }

        if (!empty($filters["fromdate"]) && $filters["fromdate"] != '') {
            $where_condition .= ' AND DATE_FORMAT(payment.created_date,"%Y-%m-%d %H:%i:%s")>=:fromdate';
            $apply_condition['fromdate'] = $filters["fromdate"];
        }

        if (!empty($filters["todate"]) && $filters["todate"] != '') {
            $where_condition .=  ' AND DATE_FORMAT(payment.created_date,"%Y-%m-%d %H:%i:%s")<=:todate';
            $apply_condition['todate'] = $filters["todate"];
        }


        // print_r($apply_condition);
        // DB::enableQueryLog();

        $query = "SELECT merchant.id as merchant_id,merchant.merchant_gid,merchant_business.business_name as name,payment.id,transaction_gid,transaction_amount,transaction_status,payment.created_date,DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as transaction_date,transaction_mode,
        transaction_type,payment.created_merchant,IF(merchant_business.state=36,'IGST&SGST(%9+%9)','GST(%18)') as transaction_gst,live_order.order_gid as orderId  ,payment.vendor_transaction_id as merchantorderId  ,payment.customer_vpa ,
        payment.transaction_username as uname,
        payment.transaction_email as uemail,
        payment.transaction_contact as ucontact,payment.bank_ref_no,
         payment.merchant_ip as uip,
         transaction_gst_value,transaction_gst_charged_per,transaction_gst_charged_amount,transaction_adjustment_charged_per,transaction_adjustment_charged_amount,transaction_total_charged_amount,transaction_total_adjustment,refund.refund_gid,refund.refund_status,refund.created_date as refunded_at,
          payment.settlement_brief_gid
        FROM live_payment payment 
        LEFT JOIN live_order ON live_order.id = payment.order_id
        LEFT JOIN " . $this->table_prefix . "_refund `refund` ON `refund`.payment_id = payment.id 
        LEFT JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_business ON merchant_business.created_merchant = payment.created_merchant 
        WHERE $where_condition ORDER BY payment.created_date DESC";

        return  DB::select($query, $apply_condition);

        //  dd(DB::getQueryLog());
    }

    public function get_transactions_bydate_dwld($filters = array())
    {

        $where_condition = "1=:id ";
        $apply_condition["id"] = "1";
        //dd($filters);
        $where_condition .= '  AND transaction_status ="success" AND adjustment_done="N"';

        if (!empty($filters["merchant_id"]) && $filters["merchant_id"] != '') {
            $where_condition .=  ' AND payment.created_merchant=:created_merchant';
            $apply_condition['created_merchant'] = $filters["merchant_id"];
        }

        if (!empty($filters["fromdate"]) && $filters["fromdate"] != '') {
            $where_condition .= ' AND DATE_FORMAT(payment.created_date,"%Y-%m-%d %H:%i:%s")>=:fromdate';
            $apply_condition['fromdate'] = $filters["fromdate"];
        }

        if (!empty($filters["todate"]) && $filters["todate"] != '') {
            $where_condition .=  ' AND DATE_FORMAT(payment.created_date,"%Y-%m-%d %H:%i:%s")<=:todate';
            $apply_condition['todate'] = $filters["todate"];
        }


        // print_r($apply_condition);
        // DB::enableQueryLog();

        $query = "SELECT merchant.id as merchant_id,merchant.merchant_gid,merchant_business.mer_name,IF(business_name<>'',business_name,name) as name,payment.id,transaction_gid,transaction_amount,transaction_status,payment.created_date,DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as transaction_date,transaction_mode,
        transaction_type,payment.created_merchant,IF(merchant_business.state=36,'IGST&SGST(%9+%9)','GST(%18)') as transaction_gst,live_order.order_gid as orderId  ,payment.udf1 as merchantorderId  ,
        payment.transaction_username as uname,
        payment.transaction_email as uemail,
        payment.transaction_contact as ucontact,payment.bank_ref_no,
        payment.merchant_ip as uip,
        transaction_adjustment_charged_per,
        transaction_adjustment_charged_amount,
        transaction_gst_value,
        transaction_gst_charged_amount,
        transaction_adjustment_charged_amount,
        transaction_total_adjustment,
        transaction_total_charged_amount
        FROM live_payment payment 
        LEFT JOIN live_order ON live_order.id = payment.order_id
        LEFT JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_business ON merchant_business.created_merchant = payment.created_merchant 
        WHERE $where_condition ORDER BY payment.created_date DESC";

        return  DB::select($query, $apply_condition);

        // dd(DB::getQueryLog());
    }

    public function get_transactions_bydate_dwldOld($fromdate, $todate)
    {

        $where_condition = 'DATE_FORMAT(payment.created_date,"%Y-%m-%d %H:%i:%s")>=:fromdate AND DATE_FORMAT(payment.created_date,"%Y-%m-%d %H:%i:%s")<=:todate  AND adjustment_done="N"';
        $apply_condition['fromdate'] = $fromdate;
        $apply_condition['todate'] = $todate;

        // print_r($apply_condition);
        // DB::enableQueryLog();

        $query = "SELECT merchant.id as merchant_id,merchant.merchant_gid,merchant.name,payment.id,transaction_gid,live_order.order_gid as orderId,transaction_amount,transaction_status,DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as transaction_date,payment.created_date as t_date,transaction_mode,
        transaction_type,payment.created_merchant,IF(merchant_business.state=36,'IGST&SGST(%9+%9)','GST(%18)') as transaction_gst  FROM live_payment payment 
        LEFT JOIN live_order ON live_order.id = payment.order_id
        LEFT JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_business ON merchant_business.created_merchant = payment.created_merchant 
        WHERE $where_condition ORDER BY payment.created_date ASC limit 0,1000";

        return DB::select($query, $apply_condition);

        // dd(DB::getQueryLog());
    }

    public function get_transactions_bydaterange($fromdate, $todate)
    {

        $where_condition = 'DATE_FORMAT(p.created_date,"%Y-%m-%d %H:%i:%s")>=:fromdate AND DATE_FORMAT(p.created_date,"%Y-%m-%d %H:%i:%s")<=:todate AND p.created_merchant=:id';
        $apply_condition['fromdate'] = $fromdate;
        $apply_condition['todate'] = $todate;
        $apply_condition['id'] = Auth::user()->id;;

        //DB::enableQueryLog();

        $query = 'SELECT p.transaction_gid,p.udf1 as merchantorderId,p.transaction_type,p.transaction_username,p.transaction_email,p.transaction_contact,p.transaction_amount,p.transaction_status,p.transaction_mode,p.created_date, IF( ISNULL(p.transaction_date) ,p.created_date,p.transaction_date) as transaction_date
          FROM ' . $this->table_prefix . '_payment p
        LEFT JOIN ' . $this->table_prefix . '_order `order` ON `order`.id = p.order_id WHERE';

        return DB::select($query . " " . $where_condition, $apply_condition);
        //return DB::select($query,$apply_condition);

        //dd(DB::getQueryLog());
    }


    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'created_merchant', 'id');
    }


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function get_payments_by_reseller($filters = array())
    {
        $current_reseller_id = Auth::guard('reseller')->user()->id;

        $where_condition = 'merchant.reseller_id=:reseller_id';
        $apply_condition['reseller_id'] = $current_reseller_id;

        if (!empty($filters)) {
            if (!empty($filters["transaction_gid"])) {
                $where_condition .= ' AND payment.transaction_gid=:pay_gid';
                $apply_condition['pay_gid'] = $filters["transaction_gid"];
            }
            if (!empty($filters["payment_status"])) {
                $where_condition .= ' AND payment.transaction_status=:pay_status';
                $apply_condition['pay_status'] = $filters["payment_status"];
            }
            if (!empty($filters["payment_email"])) {
                $where_condition .= ' AND payment.transaction_email=:pay_email';
                $apply_condition['pay_email'] = $filters["payment_email"];
            }
        }
        $sSql = "SELECT 
            payment.id,
            transaction_gid,
            `order`.order_gid,
            transaction_email,
            transaction_contact,
            transaction_amount,
            transaction_status,
            DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date,
            IF(ISNULL(payment.transaction_date), payment.created_date, payment.transaction_date) as transaction_date,
            IF(merchant_business.state=36, 'IGST&SGST(%9+%9)', 'GST(%18)') as transaction_gst,
            IF(payment.created_employee <> 0, merchant_employee.employee_name, merchant.name) as created_merchant,
            merchant.merchant_gid,
            merchant.name,
            transaction_mode,
            transaction_type,
            `order`.order_gid as orderId,
            payment.udf1 as merchantorderId,
            payment.transaction_username as uname,
            payment.transaction_email as uemail,
            payment.transaction_contact as ucontact,
            payment.bank_ref_no,
            payment.transaction_ip as uip,
            merchant.merchant_gid,
            merchant.id as merchant_id 
        FROM " . $this->table_prefix . "_payment payment
        LEFT JOIN " . $this->table_prefix . "_order `order` ON `order`.id = payment.order_id 
        INNER JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_employee ON merchant_employee.id = payment.created_employee
        LEFT JOIN merchant_business ON merchant_business.created_merchant = payment.created_merchant
        INNER JOIN resellers ON resellers.id = merchant.reseller_id
        WHERE " . $where_condition . " 
        GROUP BY transaction_gid
        ORDER BY payment.created_date DESC";


        return DB::select($sSql, $apply_condition);
    }

    public function get_reseller_payments_by_date($fromdate, $todate, $filters = array())
    {
        $current_reseller_id = Auth::guard('reseller')->user()->id;

        $where_condition = 'DATE_FORMAT(payment.created_date, "%Y-%m-%d %H:%i:%s") >= :fromdate AND DATE_FORMAT(payment.created_date, "%Y-%m-%d %H:%i:%s") <= :todate AND merchant.reseller_id = :reseller_id';
        $apply_condition['reseller_id'] = $current_reseller_id;
        $apply_condition['fromdate'] = $fromdate;
        $apply_condition['todate'] = $todate;

        if (!empty($filters)) {
            if (!empty($filters["transaction_gid"])) {
                $where_condition .= ' AND payment.transaction_gid = :pay_gid';
                $apply_condition['pay_gid'] = $filters["transaction_gid"];
            }
            if (!empty($filters["payment_status"])) {
                $where_condition .= ' AND payment.transaction_status = :pay_status';
                $apply_condition['pay_status'] = $filters["payment_status"];
            }
            if (!empty($filters["payment_email"])) {
                $where_condition .= ' AND payment.transaction_email = :pay_email';
                $apply_condition['pay_email'] = $filters["payment_email"];
            }
        }
        $sSql = "SELECT 
            payment.id,
            transaction_gid,
            `order`.order_gid,
            transaction_email,
            transaction_contact,
            transaction_amount,
            transaction_status,
            DATE_FORMAT(payment.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date,
            IF(ISNULL(payment.transaction_date), payment.created_date, payment.transaction_date) as transaction_date,
            IF(merchant_business.state=36, 'IGST&SGST(%9+%9)', 'GST(%18)') as transaction_gst,
            IF(payment.created_employee <> 0, merchant_employee.employee_name, merchant.name) as created_merchant,
            merchant.merchant_gid,
            merchant.name,
            transaction_mode,
            transaction_type,
            `order`.order_gid as orderId,
            payment.udf1 as merchantorderId,
            payment.transaction_username as uname,
            payment.transaction_email as uemail,
            payment.transaction_contact as ucontact,
            payment.bank_ref_no,
            payment.transaction_ip as uip,
            merchant.merchant_gid,
            merchant.id as merchant_id 
        FROM " . $this->table_prefix . "_payment payment
        LEFT JOIN " . $this->table_prefix . "_order `order` ON `order`.id = payment.order_id 
        INNER JOIN merchant ON merchant.id = payment.created_merchant
        LEFT JOIN merchant_employee ON merchant_employee.id = payment.created_employee
        LEFT JOIN merchant_business ON merchant_business.created_merchant = payment.created_merchant
        INNER JOIN resellers ON resellers.id = merchant.reseller_id
        WHERE " . $where_condition . " 
        GROUP BY transaction_gid
        ORDER BY payment.created_date DESC";

        return DB::select($sSql, $apply_condition);
    }
}
