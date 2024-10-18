<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Classes\GenerateLogs;
use App\Classes\ApiCalls;
use App\Exports\CustRyaPayAdjustment;
use App\Exports\TransactionExport;
use App\Navigation;
use App\Employee;
use App\EmpBgVerify;
use App\EmpDocument;
use App\CharOfAccount;
use App\Classes\ValidationMessage;
use App\EmpDetail;
use App\EmpContactDetail;
use App\EmpReference;
use App\Mail\SendMail;
use App\RyaPayItem;
use App\PayoutTransaction;
use App\RyaPayCustomer;
use App\RyaPayInvoice;
use App\RyaPayCustomerAddress;
use App\RyaPayInvoiceItem;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\AdjustmentController;
use App\State;
use App\Utility\BusinessSettingUtility;
use App\User;
use App\MerchantUsages;
use App\Paylink;
use App\Invoice;
use App\MerchantSupport;
use App\CallSupport;
use App\RyaPaySale;
use App\PayslipElement;
use App\EmpPayslip;
use App\EmpEarnDeduct;
use App\CustomerCase;
use App\Settlement;
use App\EmployeeLogActivity;
use App\RyapayBlog;
use App\RyapayFixedAsset;
use App\RyapayJournalVoucher;
use App\RyapaySupplier;
use App\RyapayPorder;
use App\RyapayaSupOrderInv;
use App\RyapayaSupOrderItem;
use App\RyapaySupExpInv;
use App\RyapaySupExpItem;
use App\RyapayPorderItem;
use App\RyapayTaxSettlement;
use App\RyapayTaxAdjustment;
use App\RyapayTaxPayment;
use App\Payment;
use App\Refund;
use App\Custom;
use App\RyapayAdjustment;
use App\payselAdjustmentTrans;
use App\payselAdjustmentDetail;
use App\RyapaySupCDNote;
use App\RyapayaCustCDNote;
use App\RyapaySorder;
use App\RyapaySorderItem;
use App\RyapayCustOrderInv;
use App\RyapayCustOrderItem;
use App\MerchantBusiness;
use App\BusinessSubCategory;
use App\RyapayBGCheck;
use App\MerchantDocument;
use App\RyapayDOCCheck;
use App\CaseComment;
use App\RyapayBankInfo;
use App\RyapayContEntry;
use App\RyapaySupPayEntry;
use App\RyapaySundPayEntry;
use App\RyapayCustRcptEntry;
use App\RyapaySundRcptEntry;
use App\RyapayCDR;
use App\NavPermission;
use App\ContactUs;
use App\RyapaySubscribe;
use App\RyapayGallery;
use App\RyapayCareer;
use App\RyapayApplicant;
use App\RyapayEvent;
use App\EmpWorkStatus;
use File;
use Image;
use App\RyapayRncCheck;
use App\MerchantChargeDetail;
use App\MerchantPayoutCharges;
use App\MerchantPayoutVendor;
use App\RyapayAdjustmentCharge;
use App\BusinessType;
use App\MerchantVendorBank;
use App\VendorBank;
use App\VendorBankInfo;
use App\VendorAdjustmentResp;
use Auth;
use App\MerchantExtraDoc;
use App\PayoutAccountSettelment;
use App\PayoutDirectSettelment;
use App\CfSpayKeys;
use App\Imports\CampaignSheet;
use App\Campaign;
use DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\KycVerifyResponse;
use App\Classes\KycProcessApi;
use App\Imports\ReconImport;
use App\Models\Recon;
use App\Models\ReconAcquirer;
use App\Models\ReconFiles;
use App\Models\ReconMatchedTransactions;
use App\Models\Accountant;
use App\Models\MerchantAccountants;
use App\Exports\ReconExport;
use App\Exports\ReconExportCsv;
use App\Jobs\ExportTransactions;
use App\Jobs\DailyTransactionExportJob;
use App\Jobs\EmployeePayoutTransactionExportJob;
use App\SmsApi;
use App\SmsTemplate;
use App\Http\Requests\SmsApiRequest;
use App\Http\Requests\SmsTemplateRequest;

class EmployeeController extends Controller
{

    public $datetime;

    public $weekdatetime;

    private $gst_on_chargers = "18";

    public $payable_manage;

    public $receivable_manage;

    public $documents_name;

    public $next_settlement;

    public $employee;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
        $this->middleware('check.permissions');
        $this->middleware('Employee');
        $this->middleware('SessionTimeOut');

        /*$this->middleware('TwoFA');
        $this->middleware('ThreeFA');*/
        $this->datetime = date('Y-m-d H:i:s');
        $this->weekdate = date('Y-m-d', strtotime('-7 days'));

        $this->next_settlement = date('Y-m-d', strtotime('+7 days'));
        $this->today = date('Y-m-d');
        $this->payable_manage = [
            '1' => 'Supplier Order based Invoice',
            '2' => 'Supplier Direct Invoice',
            '3' => 'Debit Note/ Credit Note'
        ];
        $this->receivable_manage = ['1' => 'Order based sale Invoice', '2' => 'Customer Debit Note/ Credit Note'];

        $this->documents_name = [

            "comp_pan_card" => "Company Pan Card",
            "comp_gst_doc" => "Company GST",
            "bank_statement" => "Bank Statement",
            "aoa_doc" => "AOA Doc",
            "mer_pan_card" => "Authorized Signatory Pan Card",
            "mer_aadhar_card" => "Authorized Signatory Aadhar Card",
            "moa_doc" => "MOA Doc",
            "cancel_cheque" => "Cancel Cheque",
            "cin_doc" => "Certificate of Incorporation",
            "partnership_deed" => "Partnership Deed",
            "llp_agreement" => "LLP Agreement",
            "registration_doc" => "Registration Doc",
            "no_objection_doc" => "No Objection Document",
            "trust_constitutional" => "Trust Constitutional",
            "income_tax_doc" => "Income Tax",
            "ccrooa_doc" => "CCROOA Doc",
            "current_trustees" => "Current Trusties",
            "mer_br_document" => "BR Document",

        ];

        $this->fields_name = [

            "name" => "Name",
            "email" => "Email",
            "mobile_no" => "Mobile No",
            "type_name" => "Business Type",
            "category_name" => "Business Category",
            "expenditure" => "Company Expenditure",
            "sub_category_name" => "Business Sub Category",
            "business_name" => "Company Name",
            "address" => "Company Address",
            "pincode" => "Pincode",
            "city" => "City",
            "state_name" => "State",
            "country" => "Country",
            "website" => "Website",
            "bank_name" => "Bank Name",
            "bank_acc_no" => "Bank Account No",
            "bank_ifsc_code" => "Bank IFSC Code",
            "comp_pan_number" => "Company Pan No",
            "comp_gst" => "Company GST",
            "mer_pan_number" => "Merchant Pan No",
            "mer_aadhar_number" => "Merchant Aadhar No",
            "mer_name" => "Merchant Name",
            "comp_cin" => "Corporate Identification Number(cin)"
        ];


        // $this->middleware('auth');

        // $this->middleware(function ($request, $next) {
        //     $user = Auth::user();

        //     $fullUrl = url()->current();

        //     // Extract the path from the full URL
        //     $path = parse_url($fullUrl, PHP_URL_PATH);

        //     $find = DB::table('navigation')->where('hyperlink', $path)->first();



        //     if ($find) {
        //         $combinationArray =  [
        //             'Account' => 'account',
        //             'Finance' => 'finance',
        //             'Settlement' => 'settlement',
        //             'Technical' => 'technical',
        //             'Networking' => 'networking',
        //             'Support' => 'support',
        //             'Marketing' => 'marketing',
        //             'Sales' => 'sales',
        //             'Risk & Complaince' => 'risk_complaince',
        //             'Legal' => 'legal',
        //             'HRM' => 'hrm',
        //             'Merchant' => 'merchant',
        //             'Chargeback & Dispute' => 'chargeback_dispute',
        //             'Payout' => 'payout',
        //             'Reports' => 'reports',
        //             'Users' => 'users',
        //             'Settings' => 'settings',
        //             'Merchant Management' => 'merchant_management',
        //             'Onboarding Management' => 'onboarding_management',
        //             'Recon' => 'recon',
        //         ];

        //         if (array_key_exists($find->link_name, $combinationArray)) {
        //             $module = $combinationArray[$find->link_name];
        //         } else {

        //             $getParent = DB::table('navigation')->where('id', $find->parent_id)->first();
        //             $module = $combinationArray[$getParent->link_name];
        //         }


        //         $getPermissions = DB::table('nav_permission')->where('employee_id', $user->id)->first();

        //         $arr =  explode('+',  $getPermissions->{$module});

        //         $check = in_array($find->id, $arr);

        //         if (!$check) {

        //             dd('you are not authorized');
        //         }
        //     }



        //     return $next($request);
        // });


        // $apiCall = new ApiCalls(array());
        // ($apiCall->calculate_settlement_data());


    }


    public function index()
    {
        $navigation = new Navigation();
        $nav_details = $navigation->get_app_navigation_links();

        $dashboard = new \stdClass();
        $dashboard->total_merchant = User::count();
        $dashboard->live_merchant = User::where('app_mode', 1)->count();
        $dashboard->active_merchant = User::where('merchant_status', 'active')->count();

        $dashboard->total_transaction = Payment::count();
        $dashboard->successful_transaction = Payment::where('transaction_status', 'success')->count();
        $dashboard->failed_transaction = Payment::where('transaction_status', 'failed')->count();

        $dashboard->gtv = Payment::where('transaction_status', 'success')->sum('transaction_amount');
        $dashboard->refund = DB::table('live_refund')->where('refund_status', 'success')->sum('refund_amount');

        return view('employee.dashboard', compact('dashboard'))->with("nav_details", $nav_details);
    }

    public function dashboardTransactionStats(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $merchant = $request->merchantId;


        if ($merchant == 'all') {
            $dashboard = new \stdClass();
            $dashboard->total_transaction = Payment::whereBetween('created_date', [$request->start, $request->end])->count();
            $dashboard->successful_transaction = Payment::whereBetween('created_date', [$request->start, $request->end])->where('transaction_status', 'success')->count();
            $dashboard->failed_transaction = Payment::whereBetween('created_date', [$request->start, $request->end])->where('transaction_status', 'failed')->count();

            $dashboard->gtv = Payment::whereBetween('created_date', [$request->start, $request->end])->where('transaction_status', 'success')->sum('transaction_amount');
            $dashboard->refund = DB::table('live_refund')->whereBetween('created_date', [$request->start, $request->end])->where('refund_status', 'processed')->sum('refund_amount');
        } else {
            $dashboard = new \stdClass();
            $dashboard->total_transaction = Payment::where('created_merchant', $merchant)->whereBetween('created_date', [$request->start, $request->end])->count();
            $dashboard->successful_transaction = Payment::where('created_merchant', $merchant)->whereBetween('created_date', [$request->start, $request->end])->where('transaction_status', 'success')->count();
            $dashboard->failed_transaction = Payment::where('created_merchant', $merchant)->whereBetween('created_date', [$request->start, $request->end])->where('transaction_status', 'failed')->count();

            $dashboard->gtv = Payment::where('created_merchant', $merchant)->whereBetween('created_date', [$request->start, $request->end])->where('transaction_status', 'success')->sum('transaction_amount');
            $dashboard->refund = DB::table('live_refund')->where('created_merchant', $merchant)->whereBetween('created_date', [$request->start, $request->end])->where('refund_status', 'processed')->sum('refund_amount');
        }
        return response()->json(['transactionStats' => $dashboard], 200);
    }

    public function dashboardTransactionGraph(Request $request)
    {
        $startDate = new Carbon($request->start);
        $endDate = new Carbon($request->end);
        $merchant = $request->merchantId;
        $all_dates = array();
        while ($startDate->lte($endDate)) {
            $all_dates[] = $startDate->toDateString();

            $startDate->addDay();
        }

        $graphData = [];
        $graphDataAll = [];
        $graphPayMode = [];
        $pay = new Payment();


        if ($merchant == 'all') {
            foreach ($all_dates as $key => $date) {
                // DB::enableQueryLog();
                $graphData[$key] = new \stdClass();


                $graphData[$key]->gtv_amount = Payment::whereDate('created_date', $date)
                    ->where('transaction_status', 'success')
                    ->sum('transaction_amount');
                // dd(DB::getQueryLog());
                $graphData[$key]->tran_count = Payment::whereDate('created_date', $date)
                    ->where('transaction_status', 'success')
                    ->count() ?? 0;
                $graphData[$key]->gtv_date = $date;
            }

            $graphPayMode = $pay->graph_payment_mode($request->start, $request->end);
            $graphPayStatusWise = $pay->graph_no_of_payments_by_status($request->start, $request->end);
        } else {
            foreach ($all_dates as $key => $date) {

                $graphData[$key] = new \stdClass();


                $graphData[$key]->gtv_amount = Payment::where('created_merchant', $merchant)->whereDate('created_date', $date)
                    ->where('transaction_status', 'success')
                    ->sum('transaction_amount');

                $graphData[$key]->tran_count = Payment::where('created_merchant', $merchant)
                    ->whereDate('created_date', $date)
                    ->where('transaction_status', 'success')
                    ->count() ?? 0;
                $graphData[$key]->gtv_date = $date;
            }

            $graphPayMode = $pay->graph_payment_mode($request->start, $request->end, $merchant);
            $graphPayStatusWise = $pay->graph_no_of_payments_by_status($request->start, $request->end, $merchant);
        }

        $graphDataAll = array('bar_graph' => $graphData, 'pay_mode' => $graphPayMode, 'status_mode' => $graphPayStatusWise);


        return $graphDataAll;
    }


    public function dashboardPaymentStatusWiseGraph(Request $request)
    {
        $pay = new Payment();

        $graphPayStatusWise = $pay->graph_no_of_payments_by_status($request->start, $request->end);

        dd($graphPayStatusWise);
    }

    public static function page_limit()
    {
        $per_page = array(
            "10" => "10",
            "25" => "25",
            "50" => "50",
            "75" => "75",
            "100" => "100"
        );
        return $per_page;
    }

    private function _arrayPaginator($array, $request, $module = "", $perPage = 10)
    {

        $page = request()->get('page', 1);
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, true),
            count($array),
            $perPage,
            $page,
            ['path' => '/manage/pagination/' . $module . '-' . $perPage, 'query' => $request->query()]
        );
    }

    private function _generate_html_content($description)
    {

        $dom = new \DomDocument();

        $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {

            $data = $img->getAttribute('src');

            $imageName = explode('.', $img->getAttribute('data-filename'));

            list($type, $data) = explode(';', $data);

            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);

            $image_name = "/storage/blog/images/" . $imageName[0] . '.png';

            $path = public_path() . $image_name;


            file_put_contents($path, $data);

            $img->removeAttribute('src');

            $img->setAttribute('src', $image_name);
        }

        return $dom->saveHTML();
    }

    public static function navigationId($hyperlink = '')
    {
        $parent_id = Navigation::select("parent_id")->where('hyperlink', $hyperlink)->first();
        $link = "";
        if ($parent_id) {

            $parent = Navigation::select("id")->where('id', $parent_id->parent_id)->first();
            if ($parent) {
                $link = $parent->id;
            }
        }

        return $link;
    }

    public static function navigation()
    {

        $links = [];
        $permissions = [];
        $permission_row = [];
        $filter_links = [];
        $nav_array = [];


        if (!session()->has('links')) {
            $naviagtion = new Navigation();
            $links = $naviagtion->navigator();

            session(['links' => $links]);
        }



        $navpermObject = new NavPermission();
        $permissions = $navpermObject->get_employee_navpermissions();




        if (!empty($permissions)) {
            $permission_row = $permissions[0];

            foreach (session('links') as $key => $link) {
                $col = trim($link->link_name);

                $column_name = strtolower(str_replace(" & ", "_", $col));

                $column_name = strtolower(str_replace(" ", "_", $column_name));

                if (!empty($permission_row->$column_name)) {
                    $nav_array[$link->id] = explode("+", $permission_row->$column_name);
                }
            }


            foreach (session('links') as $key => $link) {

                if (array_key_exists($link->id, $nav_array)) {
                    $filter_links[$key]["link_name"] = $link->link_name;
                    $filter_links[$key]["hyperlink"] = $link->hyperlink;
                    $filter_links[$key]["hyperlinkid"] = $link->hyperlinkid;
                    $filter_links[$key]["id"] = $link->id;
                    $filter_links[$key]["icons"] = $link->icons;
                    foreach ($link->sublinks as $index => $sublink) {
                        if (in_array($sublink["id"], $nav_array[$link['id']])) {
                            $filter_links[$key]["sublinks"][$index] = [
                                'id' => $sublink['id'],
                                'link_name' => $sublink['link_name'],
                                'hyperlink' => $sublink['hyperlink'],
                                "hyperlinkid" => $sublink['hyperlinkid'],
                            ];
                        }
                    }
                }
            }
        }

        return $filter_links;
    }



    public static function support_category()
    {
        $sup_category = array(
            "1" => "Bug",
            "2" => "Complaint",
            "3" => "Change Request",
            "4" => "Query Reuest",
            "5" => "Spam Ticket",
            "6" => "No Information"
        );
        return $sup_category;
    }

    public static function merchant_status()
    {
        $merchant = [
            'visited' => 'Visited Today',
            'interested' => 'Interested',
            'not interested' => 'Not Interested',
            'one more visit' => 'One More Visit',
            'final discussion' => 'Final Discussion',
            'ready to onboard' => 'Ready to Onboard'
        ];
        return $merchant;
    }

    public static function sales_status()
    {
        $status = [
            'lead' => "Lead",
            'daily' => "Daily Tracker",
            'sales' => "Sales Sheet"
        ];

        return $status;
    }

    public function get_adjustment_percentage($discriminator)
    {

        switch ($discriminator) {
            case 'CC':
                return "2.00";
                break;
            case 'DC':
                return "1.70";
                break;
            case 'NB':
                return "2.00";
                break;
            default:
                return "3.00";
                break;
        }
    }

    public function num_format($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    public function get_merchant_transactions(Request $request, $id)
    {

        if ($request->ajax()) {
            $payment = new Payment();
            $transactions = $payment->get_merchant_transactions($id);
            echo json_encode($transactions);
        }
    }

}