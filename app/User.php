<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyAccount;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile_no', 'password', 'verify_token', 'app_mode', 'merchant_gid', 'created_date', 'last_seen_at',
        'is_mobile_verified', 'i_agree', 'is_account_locked', 'failed_attempts'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_date'
    ];

    protected $table = "merchant";

    protected $jointable1 = "live_payment";

    protected $jointable2 = "customer_case";

    protected $jointable3 = "merchant_document";



    public $timestamps = FALSE;

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    /**
     * 
     * @param appmode field
     * 
     */


    public function update_merchant($field)
    {
        return DB::table($this->table)->where('id', Auth::user()->id)->update($field);
    }

    public function update_merchant_admin($field, $merchant_id)
    {
        return DB::table($this->table)->where('id', $merchant_id)->update($field);
    }

    /**
     * sendAccountVerificationEmail 
     * 
     * @return void
     */
    public function sendAccountVerificationEmail()
    {
        $this->notify(new VerifyAccount($this));
    }


    public function getLastUserIndex()
    {
        $query = "SELECT count(1) as merchant_count FROM $this->table";
        return DB::select($query);
    }


    public function get_merchant_details()
    {
        $where_condition = "id=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT `name`,email,mobile_no FROM merchant WHERE";

        return DB::select($query . " " . $where_condition, $apply_condition);
    }

    public function get_merchant_details_by_mail($email)
    {
        $where_condition = "email=:email OR mobile_no=:mobile_no";
        $apply_condition["email"] = $email;
        $apply_condition["mobile_no"] = $email;

        $query = "SELECT `name`,email,mobile_no,is_account_locked,merchant_status,id FROM merchant WHERE";

        return DB::select($query . " " . $where_condition, $apply_condition);
    }

    public function get_merchant_details_by_id($merchant_id)
    {
        $where_condition = "id=:merchant_id ";
        $apply_condition["merchant_id"] = $merchant_id;

        $query = "SELECT `name`,email,mobile_no,is_account_locked,merchant_status FROM merchant WHERE";

        return DB::select($query . " " . $where_condition, $apply_condition);
    }



    public function get_document_status()
    {
        return DB::table($this->table)->where('id', Auth::user()->id)->select("documents_upload", "app_mode")->get();
    }

    public function enable_showmodal($field)
    {
        return DB::table($this->table)->where(['id' => Auth::user()->id, "documents_upload" => "N"])->update($field);
    }

    public function select_query($select, $where)
    {

        return DB::table($this->table)->where($where)->select($select)->get();
    }

    public function get_documents_status()
    {

        $query = "SELECT merchant_gid,`name`,email,mobile_no,IF(app_mode,'Live','Test') app_mode,
        IF(mer_pan_card<>'',mer_pan_card,'NA') pan_card,
        IF(mer_aadhar_card<>'',mer_aadhar_card,'NA') aadhar_card,IF(bank_statement<>'',bank_statement,'NA') bank_statement,
        IF(registration_doc<>'',registration_doc,'NA') company_registration
        FROM $this->table,$this->jointable3 WHERE merchant_status = 'active' GROUP BY merchant_gid";

        //DB::enableQueryLog();
        return DB::select($query);
        //dd(DB::getQueryLog());
        //exit;
    }

    public function update_docverified_status($id, $field)
    {

        return DB::table($this->table)->where($id)->update($field);
    }

    public function update_user_field($id, $field)
    {
        // DB::enableQueryLog();
        return DB::table($this->table)->where($id)->update($field);
        // dd(DB::getQueryLog());
        // exit;
    }

    public static function get_merchant_gids()
    {

        $query = "SELECT merchant.id,IF(business_name<>'',business_name,name) as merchant_gid,merchant_gid as mid,
             COUNT(merchant_business.id) AS isBusiness,
            COUNT(merchant_document.id) AS isDocuments,
            merchant_status
        FROM merchant 
        LEFT JOIN merchant_business on merchant_business.created_merchant = merchant.id
         
        LEFT JOIN merchant_document ON merchant.id = merchant_document.created_merchant
        GROUP BY merchant.id 
        HAVING isBusiness > 0 AND isDocuments>0 AND merchant_status='active'  
        order by business_name asc";
        return DB::select($query);
    }

    public static function get_merchant_list_for_routing()
    {
        $query = "SELECT merchant.id,
                 IF(business_name <> '', business_name, name) AS merchant_gid,
                 merchant_vendor_bank.merchant_id,
                 merchant_gid AS mid,
                 COUNT(merchant_business.id) AS isBusiness,
                 COUNT(merchant_document.id) AS isDocuments,
                 merchant_status
          FROM merchant
          LEFT JOIN merchant_business ON merchant_business.created_merchant = merchant.id
          LEFT JOIN merchant_document ON merchant.id = merchant_document.created_merchant
          LEFT JOIN merchant_vendor_bank ON merchant.id = merchant_vendor_bank.merchant_id
          GROUP BY merchant.id
          HAVING isBusiness > 0
                 AND isDocuments > 0
                 AND merchant_status = 'active'
                 AND merchant_vendor_bank.merchant_id IS NULL
          ORDER BY business_name ASC";

        $results = DB::select($query);
        return $results;
    }

    public static function get_merchant_list_for_charge_detail()
    {
        $query = "SELECT merchant.id,
                 IF(business_name <> '', business_name, name) AS merchant_gid,
                 merchant_charge_detail.merchant_id,
                 merchant_gid AS mid,
                 COUNT(merchant_business.id) AS isBusiness,
                 COUNT(merchant_document.id) AS isDocuments,
                 merchant_status
          FROM merchant
          LEFT JOIN merchant_business ON merchant_business.created_merchant = merchant.id
          LEFT JOIN merchant_document ON merchant.id = merchant_document.created_merchant
          LEFT JOIN merchant_charge_detail ON merchant.id = merchant_charge_detail.merchant_id
          GROUP BY merchant.id
          HAVING isBusiness > 0
                 AND isDocuments > 0
                 AND merchant_status = 'active'
                 AND merchant_charge_detail.merchant_id IS NULL
          ORDER BY business_name ASC";

        $results = DB::select($query);
        return $results;
    }

    public static function get_merchant_list_for_usage()
    {
        $query = "SELECT merchant.id,
                 IF(business_name <> '', business_name, name) AS merchant_gid,
                 merchant_usages.created_merchant,
                 merchant_gid AS mid,
                 COUNT(merchant_business.id) AS isBusiness,
                 COUNT(merchant_document.id) AS isDocuments,
                 merchant_status
          FROM merchant
          LEFT JOIN merchant_business ON merchant_business.created_merchant = merchant.id
          LEFT JOIN merchant_document ON merchant.id = merchant_document.created_merchant
          LEFT JOIN merchant_usages ON merchant.id = merchant_usages.created_merchant
          GROUP BY merchant.id
          HAVING isBusiness > 0
                 AND isDocuments > 0
                 AND merchant_status = 'active'
                 AND merchant_usages.created_merchant IS NULL
          ORDER BY business_name ASC";

        $results = DB::select($query);
        return $results;
    }

    public static function get_merchant_list_for_payout_charges()
    {
        $query = "SELECT merchant.id,
                 IF(business_name <> '', business_name, name) AS merchant_gid,
                 merchant_payout_charges.merchant_id,
                 merchant_gid AS mid,
                 COUNT(merchant_business.id) AS isBusiness,
                 COUNT(merchant_document.id) AS isDocuments,
                 merchant_status
          FROM merchant
          LEFT JOIN merchant_business ON merchant_business.created_merchant = merchant.id
          LEFT JOIN merchant_document ON merchant.id = merchant_document.created_merchant
          LEFT JOIN merchant_payout_charges ON merchant.id =  merchant_payout_charges.merchant_id
          GROUP BY merchant.id
          HAVING isBusiness > 0
                 AND isDocuments > 0
                 AND merchant_status = 'active'
                 AND merchant_payout_charges.merchant_id IS NULL
          ORDER BY business_name ASC";

        $results = DB::select($query);
        return $results;
    }

    public static function get_merchant_lists()
    {

        $query = "SELECT merchant.id,IF(business_name<>'',business_name,name) as merchant_gid,merchant_gid as mid,
             COUNT(merchant_business.id) AS isBusiness,
            COUNT(merchant_document.id) AS isDocuments,
            merchant_status
        FROM merchant 
        LEFT JOIN merchant_business on merchant_business.created_merchant = merchant.id
         
        LEFT JOIN merchant_document ON merchant.id = merchant_document.created_merchant
        GROUP BY merchant.id 
        HAVING isBusiness > 0 AND isDocuments>0 AND merchant_status='active'  
        order by business_name asc";
        return DB::select($query);
    }

    public function get_merchant_transactions($fromdate = "", $todate = "")
    {

        // $where_condition = "1=:id and transaction_status=:status";

        $where_condition = "1=:id ";
        $apply_condition["id"] = "1";
        //$apply_condition["status"] = "success";

        if (!empty($fromdate)) {
            $where_condition .= " AND DATE_FORMAT($this->jointable1.created_date,'%Y-%m-%d %H:%i:%s')>=:from_date";
            $apply_condition["from_date"] = $fromdate;
        }

        if (!empty($todate)) {
            $where_condition .= " AND DATE_FORMAT($this->jointable1.created_date,'%Y-%m-%d %H:%i:%s')<=:to_date";
            $apply_condition["to_date"] = $todate;
        }

        $query = "SELECT merchant.id,merchant.merchant_gid,merchant.name,merchant.email,merchant.mobile_no,
        sum(CASE WHEN transaction_status = 'success' THEN 1 ELSE 0 END) as no_of_success, 
        sum(CASE WHEN transaction_status = 'failed' THEN 1 ELSE 0 END) as no_of_failed ,
        sum(CASE WHEN transaction_status = 'authorized' THEN 1 ELSE 0 END) as no_of_authorized, count(*) as no_of_transaction
        FROM $this->jointable1 
        join merchant on merchant.id=$this->jointable1.created_merchant 
        WHERE $where_condition 
        GROUP BY created_merchant 
        ORDER BY merchant.name ASC";

        //DB::enableQueryLog();
        return DB::select($query, $apply_condition);
        //dd(DB::getQueryLog());
        //exit;
    }

    public function get_merchant_trans_amount($fromdate = "", $todate = "")
    {


        $where_condition = "$this->jointable1.transaction_status='success'";

        if (!empty($fromdate)) {
            $where_condition .= " AND DATE_FORMAT($this->jointable1.created_date,'%Y-%m-%d %H:%i:%s')>=:from_date";
            $apply_condition["from_date"] = $fromdate;
        }

        if (!empty($todate)) {
            $where_condition .= " AND DATE_FORMAT($this->jointable1.created_date,'%Y-%m-%d %H:%i:%s')<=:to_date";
            $apply_condition["to_date"] = $todate;
        }
        //  DB::enableQueryLog();
        $query = "SELECT merchant.id,merchant.merchant_gid,merchant.name,merchant.email,merchant.mobile_no,
        sum($this->jointable1.transaction_amount) as transaction_amount ,
        sum($this->jointable1.transaction_gst_charged_amount) as gst_charged_amount,
        sum($this->jointable1.transaction_adjustment_charged_amount) as adjustment_charged_amount,
        sum($this->jointable1.transaction_total_charged_amount) as total_charged_amount, 
        sum($this->jointable1.transaction_total_adjustment) as total_adjustment
        FROM $this->jointable1 
        join merchant on merchant.id=$this->jointable1.created_merchant WHERE";
        return DB::select($query . " " . $where_condition . " GROUP BY created_merchant ORDER BY merchant.name ASC", $apply_condition);
        //dd(DB::getQueryLog());
        // exit;

    }

    public function get_all_merchants()
    {

        $query = "SELECT merchant_gid,`name`,email,mobile_no,merchant_status,DATE_FORMAT(created_date,'%Y-%m-%d %h:%i:%s %p') created_date,DATE_FORMAT(last_seen_at,'%Y-%m-%d %h:%i:%s %p') last_seen_at FROM $this->table
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_merchant_cases()
    {

        $query = "SELECT case_gid,transaction_gid,transaction_amount,customer_name,customer_email,customer_mobile,$this->table.`name`,`status`,DATE_FORMAT($this->jointable2.created_date,'%Y-%m-%d %H:%i:%s %p') as created_date FROM $this->jointable2 JOIN $this->table ON $this->table.id=$this->jointable2.merchant_id ORDER BY $this->jointable2.created_date DESC";

        return DB::select($query);
    }

    public function merchant_locked()
    {

        $query = "SELECT id,merchant_gid,`name`,email,mobile_no,merchant_status,DATE_FORMAT(created_date,'%Y-%m-%d %h:%i:%s %p') created_date,DATE_FORMAT(last_seen_at,'%Y-%m-%d %h:%i:%s %p') last_seen_at FROM $this->table
        WHERE is_account_locked='Y' ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_active_merchants()
    {

        $query = "SELECT id,name,app_mode,is_reminders_enabled,email from $this->table WHERE merchant_status='active' AND is_reminders_enabled = 'Y'";
        return DB::select($query);
    }

    public static function get_merchant_options()
    {

        $query = "SELECT id,name FROM merchant WHERE merchant_status='active' ORDER BY name asc";
        return DB::select($query);
    }

    public static function get_tmode_bgverfied_merchants()
    {

        $query = "SELECT id,name FROM merchant WHERE merchant_status='active' AND app_mode='0' AND bg_verified='N'";
        return DB::select($query);
    }

    public static function get_tmode_docupload_merchants()
    {

        $query = "SELECT id,name FROM merchant WHERE merchant_status='active' AND app_mode='0' AND documents_upload='Y' AND doc_verified='N'";
        return DB::select($query);
    }

    public static function get_merchant_gid($merchant_id)
    {
        return DB::table("merchant")->where("id", $merchant_id)->value("merchant_gid");
    }

    public function get_merchant_info($merchant_id, $column_name)
    {
        if (!empty($merchant_id) && !empty($column_name)) {
            return DB::table("merchant")->where("id", $merchant_id)->value($column_name);
        }
    }

    public function business()
    {
        return $this->hasOne(MerchantBusiness::class, 'created_merchant', 'id');
    }


    public function OnboardingStatus()
    {
        return $this->hasOne(MerchantOnboardingStatus::class, 'onboarding_status_id', 'onboarding_status');
    }

    public function AccountStatus()
    {
        return $this->hasOne(MerchantAccountStatus::class, 'account_status_id', 'account_status',);
    }
}
