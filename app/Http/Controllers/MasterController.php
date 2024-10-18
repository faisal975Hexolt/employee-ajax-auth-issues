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
use App\VendorBank;
use App\Classes\ValidationMessage;
use App\EmpDetail;
use App\EmpContactDetail;
use App\EmpReference;
use App\Mail\SendMail;
use App\RyaPayItem;
use App\RyaPayCustomer;
use App\RyaPayInvoice;
use App\RyaPayCustomerAddress;
use App\RyaPayInvoiceItem;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\AdjustmentController;
use App\State;
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
use App\PayoutTransaction;
use App\RyapayAdjustmentCharge;
use App\BusinessType;
use App\MerchantVendorBank;
use App\VendorBankInfo;
use App\VendorAdjustmentResp;
use Auth;
use App\MerchantExtraDoc;
use App\SettlementCronSetting;
use App\GstCronSetting;
use App\CfSpayKeys;
use App\Imports\CampaignSheet;
use App\Models\Accountant;
use App\Campaign;
use DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class MasterController extends Controller
{

    public $datetime;

    public $weekdatetime;

    private $gst_on_chargers = "18";

    public $payable_manage;

    public $receivable_manage;

    public $documents_name;

    public $next_settlement;

    public function __construct()
    {




        $this->middleware('prevent-back-history');
        $this->middleware('Employee');
        $this->middleware('SessionTimeOut');
        /*$this->middleware('TwoFA');
        $this->middleware('ThreeFA');*/
        $this->datetime = date('Y-m-d H:i:s');
        $this->weekdate = date('Y-m-d', strtotime('-7 days'));

        $this->next_settlement = date('Y-m-d', strtotime('+7 days'));
        $this->today = date('Y-m-d');
    }

    public function getBusinessCategoryList(Request $request)
    {
        if ($request->ajax() || 1) {
            $form_data = $request->form;
            $search = $form_data['searchfor'];
            $status = $form_data['status_filter'];

            $columns = array(
                1 => 'category_name'
            );
            $limit = $request->length;
            $start = $request->start;
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');


            //get total:
            $payment = new \App\BusinessCategory();
            $paymentTable = $payment->getTable();
            $table = $paymentTable;
            //DB::enableQueryLog();
            $dataCount = $payment

                ->where(function ($query) use ($status, $paymentTable) {
                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search) {

                    $query->where('category_name', 'LIKE', '%' . $search . '%')->orWhere('status', 'LIKE', '%' . $search . '%');
                })->select($paymentTable . '.id')

                ->count();


            if ($limit < 1) {
                $limit = $dataCount;
            }
            // DB::enableQueryLog();
            $data = $payment


                ->where(function ($query) use ($status, $paymentTable) {

                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search, $status) {
                    $query->where('category_name', 'LIKE', '%' . $search . '%')->orWhere('status', 'LIKE', '%' . $search . '%');
                })

                ->offset(intval($start))
                ->limit(intval($limit))
                ->orderBy($order, $dir)
                ->get();



            return Datatables::of(collect($data))
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {

                    if (!empty($request->get('search'))) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {


                            if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['category_name']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<button  id="edit_bcat" alt="Edit" class="btn btn-sm btn-success"  merchant="' . $row['id'] . '" orderid="' . $row['id'] . '" mode="edit">Edit<ion-icon name="checkbox-sharp"></ion-icon></button>';
                    // $btn.='  <button  id="edit_bacat_admin" alt="Edit" class="btn btn-sm btn-warning"  merchant="'.$row['id'].'" orderid="'.$row['id'].'" mode="edit">Update Status<ion-icon name="checkbox-sharp"></ion-icon></button>';

                    return $btn;
                })
                ->addColumn('created', function ($row) {

                    return Carbon::parse($row->created_at)->format('jS M Y h:i:s A');
                })


                ->addColumn('status', function ($row) {

                    return ucwords($row->status);
                })








                ->setFilteredRecords($dataCount)
                ->setTotalRecords($dataCount)
                ->setOffset($start)
                // ->with(['recordsTotal'=>$totalData, "recordsFiltered" => $totalFiltered,'start' => $start])
                ->with(['test' => 123])

                ->make(true);
        }
    }

    public function getBusinessSubCategoryList(Request $request)
    {
        if ($request->ajax() || 1) {
            $form_data = $request->form;
            $search = $form_data['searchfor'];
            $status = $form_data['status_filter'];

            $columns = array(
                1 => 'sub_category_name'
            );
            $limit = $request->length;
            $start = $request->start;
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');


            //get total:
            $payment = new \App\BusinessSubCategory();
            $paymentTable = $payment->getTable();
            $table = $paymentTable;
            //DB::enableQueryLog();
            $dataCount = $payment

                ->where(function ($query) use ($status, $paymentTable) {
                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search) {

                    $query->where('sub_category_name', 'LIKE', '%' . $search . '%')->orWhere('status', 'LIKE', '%' . $search . '%');
                })->select($paymentTable . '.id')

                ->count();


            if ($limit < 1) {
                $limit = $dataCount;
            }
            // DB::enableQueryLog();
            $data = $payment


                ->where(function ($query) use ($status, $paymentTable) {

                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search, $status) {
                    $query->where('sub_category_name', 'LIKE', '%' . $search . '%')->orWhere('status', 'LIKE', '%' . $search . '%');
                })

                ->offset(intval($start))
                ->limit(intval($limit))
                ->orderBy($order, $dir)
                ->get();



            return Datatables::of(collect($data))
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {

                    if (!empty($request->get('search'))) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {


                            if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['sub_category_name']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<button  id="edit_bsubcat" alt="Edit" class="btn btn-sm btn-success"  merchant="' . $row['id'] . '" orderid="' . $row['id'] . '" mode="edit">Edit<ion-icon name="checkbox-sharp"></ion-icon></button>';
                    // $btn.='  <button  id="edit_bacat_admin" alt="Edit" class="btn btn-sm btn-warning"  merchant="'.$row['id'].'" orderid="'.$row['id'].'" mode="edit">Update Status<ion-icon name="checkbox-sharp"></ion-icon></button>';

                    return $btn;
                })
                ->addColumn('created', function ($row) {

                    return Carbon::parse($row->created_at)->format('jS M Y h:i:s A');
                })
                ->addColumn('category_name', function ($row) {

                    return $row->category->category_name;
                })


                ->addColumn('status', function ($row) {

                    return ucwords($row->status);
                })








                ->setFilteredRecords($dataCount)
                ->setTotalRecords($dataCount)
                ->setOffset($start)
                // ->with(['recordsTotal'=>$totalData, "recordsFiltered" => $totalFiltered,'start' => $start])
                ->with(['test' => 123])

                ->make(true);
        }
    }


    public function getBusinessTypeList(Request $request)
    {
        if ($request->ajax() || 1) {
            $form_data = $request->form;
            $search = $form_data['searchfor'];
            $status = $form_data['status_filter'];

            $columns = array(
                1 => 'type_name'
            );
            $limit = $request->length;
            $start = $request->start;
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');


            //get total:
            $payment = new \App\BusinessType();
            $paymentTable = $payment->getTable();
            $table = $paymentTable;
            //DB::enableQueryLog();
            $dataCount = $payment

                ->where(function ($query) use ($status, $paymentTable) {
                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search) {

                    $query->where('type_name', 'LIKE', '%' . $search . '%')->orWhere('status', 'LIKE', '%' . $search . '%');
                })->select($paymentTable . '.id')

                ->count();


            if ($limit < 1) {
                $limit = $dataCount;
            }
            //DB::enableQueryLog();
            $data = $payment


                ->where(function ($query) use ($status, $paymentTable) {

                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search, $status) {
                    $query->where('type_name', 'LIKE', '%' . $search . '%')->orWhere('status', 'LIKE', '%' . $search . '%');
                })

                ->offset(intval($start))
                ->limit(intval($limit))
                ->orderBy($order, $dir)
                ->get();
            // $query = DB::getQueryLog();
            //  dd(DB::getQueryLog());  
            // dd($data);

            return Datatables::of(collect($data))
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {

                    if (!empty($request->get('search'))) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {


                            if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['type_name']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<button  id="edit_btype" alt="Edit" class="btn btn-sm btn-success"  merchant="' . $row['id'] . '" orderid="' . $row['id'] . '" mode="edit">Edit<ion-icon name="checkbox-sharp"></ion-icon></button>';
                    // $btn.='  <button  id="edit_bacat_admin" alt="Edit" class="btn btn-sm btn-warning"  merchant="'.$row['id'].'" orderid="'.$row['id'].'" mode="edit">Update Status<ion-icon name="checkbox-sharp"></ion-icon></button>';

                    return $btn;
                })
                ->addColumn('created', function ($row) {

                    return Carbon::parse($row->created_at)->format('jS M Y h:i:s A');
                })


                ->addColumn('status', function ($row) {

                    return ucwords($row->status);
                })








                ->setFilteredRecords($dataCount)
                ->setTotalRecords($dataCount)
                ->setOffset($start)
                // ->with(['recordsTotal'=>$totalData, "recordsFiltered" => $totalFiltered,'start' => $start])
                ->with(['test' => 123])

                ->make(true);
        }
    }

    public function getAccountantList(Request $request)
    {
        try {
            $users = Accountant::skip($request->input('start'))->take($request->input('length'))->orderBy('created_at', 'DESC')->get();

            $totalRecords = Accountant::count(); // Total number of records in the database
            return response()->json([
                'data' => $users,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords, // Same as recordsTotal for server-side processing
            ]);
        } catch (exception $e) {
            dd($e);
        }
    }

    public function getIpWhitelisted(Request $request)
    {
        try {
            $users = DB::table('merchant_payin_ipwhitelist')->where('merchant_id', $request->mid)->skip($request->input('start'))->take($request->input('length'))->orderBy('created_at', 'DESC')->get();

            $totalRecords = DB::table('merchant_payin_ipwhitelist')->count(); // Total number of records in the database
            return response()->json([
                'data' => $users,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords, // Same as recordsTotal for server-side processing
            ]);
        } catch (exception $e) {
            dd($e);
        }
    }

    public function storeIpWhitelisted(Request $request)
    {
        try {
            $find = DB::table('merchant_payin_ipwhitelist')->where('merchant_id', $request->merchantId)->first();

            if ($find) {
                $update = DB::table('merchant_payin_ipwhitelist')->where('merchant_id', $request->merchantId)->update(['ipwhitelist' => $request->ip]);
            } else {
                $create = DB::table('merchant_payin_ipwhitelist')->insert([
                    'ipwhitelist' => $request->ip,
                    'merchant_id' => $request->merchantId
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ip Whitelisted'
            ]);
        } catch (exception $e) {
            dd($e);
        }
    }
    public function storePayoutIpWhitelisted(Request $request)
    {
        try {
            $find = DB::table('merchant_payout_ipwhitelist')->where('merchant_id', $request->merchantId)->first();

            if ($find) {
                $update = DB::table('merchant_payout_ipwhitelist')->where('merchant_id', $request->merchantId)->update(['ipwhitelist' => $request->ip]);
            } else {
                $create = DB::table('merchant_payout_ipwhitelist')->insert([
                    'ipwhitelist' => $request->ip,
                    'merchant_id' => $request->merchantId
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ip Whitelisted'
            ]);
        } catch (exception $e) {
            dd($e);
        }
    }


    public function getPayoutIpWhitelisted(Request $request)
    {
        try {
            $users = DB::table('merchant_payout_ipwhitelist')->where('merchant_id', $request->mid)->skip($request->input('start'))->take($request->input('length'))->orderBy('created_at', 'DESC')->get();

            $totalRecords = DB::table('merchant_payout_ipwhitelist')->count(); // Total number of records in the database
            return response()->json([
                'data' => $users,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords, // Same as recordsTotal for server-side processing
            ]);
        } catch (exception $e) {
            dd($e);
        }
    }

    

    public function vendorList(Request $request)
    {
        $data = VendorBank::skip($request->input('start'))->take($request->input('length'))->orderBy('bank_name', 'ASC')->get();

        $totalRecords = VendorBank::count(); // Total number of records in the database
        return response()->json([
            'data' => $data,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Same as recordsTotal for server-side processing
        ]);
    }

    public function changeVendorAcquirerStatus(Request $request)
    {
        $data = VendorBank::where('id', $request->id)->update([
            'acquirer_status' => $request->status
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }

    public function changeVendorServiceStatus(Request $request)
    {
        $data = VendorBank::where('id', $request->id)->update([
            'is_active' => $request->status
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }

    public function payoutvendorList(Request $request)
    {
        $data = DB::table('payout_vendor_bank')->skip($request->input('start'))->take($request->input('length'))->orderBy('bank_name', 'ASC')->get();

        $totalRecords =  DB::table('payout_vendor_bank')->count(); // Total number of records in the database
        return response()->json([
            'data' => $data,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Same as recordsTotal for server-side processing
        ]);
    }

    public function payoutchangeVendorAcquirerStatus(Request $request)
    {
        $data = DB::table('payout_vendor_bank')->where('id', $request->id)->update([
            'acquirer_status' => $request->status
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }

    public function payoutchangeVendorServiceStatus(Request $request)
    {
        $data = DB::table('payout_vendor_bank')->where('id', $request->id)->update([
            'is_active' => $request->status
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }

    public function registerVendor(Request $request)
    {
        $data = VendorBank::insert([
            'bank_name' => $request->name
        ]);

        $res = array("success" => true, "type" => "success", "message" => "Vendor Added Successfully!");
        return json_encode($res);
    }

    public function registerPayoutVendor(Request $request)
    {
        $data =  DB::table('payout_vendor_bank')->insert([
            'bank_name' => $request->name
        ]);

        $res = array("success" => true, "type" => "success", "message" => "Payout Vendor Added Successfully!");
        return json_encode($res);
    }


    public function fetchBusinessType(Request $request)
    {


        $type = BusinessType::find($request->row_id);

        echo json_encode(["status" => true, "data" => $type]);
    }

    public function updateBusinessType(Request $request)
    {


        $res = array("success" => false, "type" => "error", "message" => "Something Went Wrong!");

        if ($request->isMethod('post')) {

            $attribute = array(
                'type_name' => 'Business Type Name',
                'status' => 'Status',
            );
            $validator = Validator::make(
                $request->all(),
                [
                    'type_name' => 'required|string|max:200',
                    'status' => 'required'
                ]
            );
            $validator->setAttributeNames($attribute);

            if ($validator->fails()) {
                $res['message'] = $validator->errors();
            } else {
                if ($request->row_id) {
                    $row_id = $request->row_id;
                    $type = BusinessType::find($row_id);
                    $type->type_name = $request->type_name;
                    $type->status = $request->status;
                    $type->updated_at = $this->datetime;
                    $type->updated_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "Business Type updated successfully");
                } else {

                    $type = new BusinessType;
                    $type->type_name = $request->type_name;
                    $type->status = $request->status;
                    $type->created_at = $this->datetime;
                    $type->created_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "Business Type created successfully");
                }
            }
        }

        return json_encode($res);
    }

    public function fetchBusinessCategory(Request $request)
    {


        $cat = \App\BusinessCategory::find($request->row_id);

        echo json_encode(["status" => true, "data" => $cat]);
    }

    public function updateBusinessCategory(Request $request)
    {


        $res = array("success" => false, "type" => "error", "message" => "Something Went Wrong!");

        if ($request->isMethod('post')) {

            $attribute = array(
                'category_name' => 'Business Category Name',
                'status' => 'Status',
            );
            $validator = Validator::make(
                $request->all(),
                [
                    'category_name' => 'required|string|max:200',
                    'status' => 'required'
                ]
            );
            $validator->setAttributeNames($attribute);

            if ($validator->fails()) {
                $res['message'] = $validator->errors();
            } else {
                if ($request->row_id) {
                    $row_id = $request->row_id;
                    $type = \App\BusinessCategory::find($row_id);
                    $type->category_name = $request->category_name;
                    $type->status = $request->status;
                    $type->updated_at = $this->datetime;
                    $type->updated_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "Business Category updated successfully");
                } else {

                    $type = new \App\BusinessCategory;
                    $type->category_name = $request->category_name;
                    $type->status = $request->status;
                    $type->created_at = $this->datetime;
                    $type->created_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "Business Category created successfully");
                }
            }
        }

        return json_encode($res);
    }

    public function fetchBusinessSubCategory(Request $request)
    {


        $type = BusinessSubCategory::find($request->row_id);

        echo json_encode(["status" => true, "data" => $type]);
    }

    public function updateBusinessSubCategory(Request $request)
    {


        $res = array("success" => false, "type" => "error", "message" => "Something Went Wrong!");

        if ($request->isMethod('post')) {

            $attribute = array(
                'sub_category_name' => 'Business Type Name',
                'status' => 'Status',
                'category_id' => 'Category'
            );
            $validator = Validator::make(
                $request->all(),
                [
                    'sub_category_name' => 'required|string|max:200',
                    'status' => 'required',
                    'category_id' => 'required'
                ]
            );
            $validator->setAttributeNames($attribute);

            if ($validator->fails()) {
                $res['message'] = $validator->errors();
            } else {
                if ($request->row_id) {
                    $row_id = $request->row_id;
                    $type = BusinessSubCategory::find($row_id);
                    $type->sub_category_name = $request->sub_category_name;
                    $type->category_id = $request->category_id;
                    $type->status = $request->status;
                    $type->updated_at = $this->datetime;
                    $type->updated_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "Business Sub Category updated successfully");
                } else {

                    $type = new BusinessSubCategory;
                    $type->sub_category_name = $request->sub_category_name;

                    $type->status = $request->status;
                    $type->created_at = $this->datetime;
                    $type->created_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "Business Sub Category created successfully");
                }
            }
        }

        return json_encode($res);
    }



    public function getSettelmentCronSettingList(Request $request)
    {
        if ($request->ajax() || 1) {
            $form_data = $request->form;
            $search = $form_data['searchfor'];
            $status = $form_data['status_filter'];

            $columns = array(
                1 => 'id',
                7 => "created_at"
            );
            $limit = $request->length;
            $start = $request->start;
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');


            //get total:
            $payment = new \App\SettlementCronSetting();
            $paymentTable = $payment->getTable();
            $table = $paymentTable;
            //DB::enableQueryLog();

            $dataCount = $payment

                ->where(function ($query) use ($status, $paymentTable) {
                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search) {

                    $query->where('status', 'LIKE', '%' . $search . '%');
                })->select($paymentTable . '.id')

                ->count();


            if ($limit < 1) {
                $limit = $dataCount;
            }
            //DB::enableQueryLog();
            $data = $payment


                ->where(function ($query) use ($status, $paymentTable) {

                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search, $status) {
                    $query->where('status', 'LIKE', '%' . $search . '%');
                })

                ->offset(intval($start))
                ->limit(intval($limit))
                ->orderBy($order, $dir)
                ->get();
            // $query = DB::getQueryLog();
            //  dd(DB::getQueryLog());  
            // dd($data);

            return Datatables::of(collect($data))
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {

                    if (!empty($request->get('search'))) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {


                            if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<button  id="edit_CronSetting" alt="Edit" class="btn btn-sm btn-success"  merchant="' . $row['id'] . '" orderid="' . $row['id'] . '" mode="edit">Edit<ion-icon name="checkbox-sharp"></ion-icon></button>';
                    // $btn.='  <button  id="edit_bacat_admin" alt="Edit" class="btn btn-sm btn-warning"  merchant="'.$row['id'].'" orderid="'.$row['id'].'" mode="edit">Update Status<ion-icon name="checkbox-sharp"></ion-icon></button>';

                    return $btn;
                })
                ->addColumn('created', function ($row) {

                    return Carbon::parse($row->created_at)->format('jS M Y h:i:s A');
                })


                ->addColumn('status', function ($row) {

                    return ucwords($row->status);
                })








                ->setFilteredRecords($dataCount)
                ->setTotalRecords($dataCount)
                ->setOffset($start)
                // ->with(['recordsTotal'=>$totalData, "recordsFiltered" => $totalFiltered,'start' => $start])
                ->with(['test' => 123])

                ->make(true);
        }
    }



    public function fetchSettelmentCronSetting(Request $request)
    {


        $type = SettlementCronSetting::find($request->row_id);

        echo json_encode(["status" => true, "data" => $type]);
    }

    public function updateSettelmentCronSetting(Request $request)
    {


        $res = array("success" => false, "type" => "error", "message" => "Something Went Wrong!");

        if ($request->isMethod('post')) {

            $attribute = array(
                'transaction_form' => 'Transaction Start From',
                'transaction_to' => 'Transaction End At',
                "transaction_form_day" => "Transaction Start Day",
                "transaction_to_day" => "Transaction End Day",
                'cron_time' => "Cron Fire At",
                'status' => 'Status'
            );
            $validator = Validator::make(
                $request->all(),
                [
                    'transaction_form' => 'required',
                    'transaction_to' => 'required',
                    'transaction_form_day' => 'required',
                    'transaction_to_day' => 'required',
                    'cron_time' => 'required',
                    'status' => 'required',

                ]
            );
            $validator->setAttributeNames($attribute);

            if ($validator->fails()) {
                $res['message'] = $validator->errors();
            } else {
                if ($request->row_id) {
                    $row_id = $request->row_id;
                    $type = SettlementCronSetting::find($row_id);
                    $type->transaction_form = $request->transaction_form;
                    $type->transaction_to = $request->transaction_to;
                    $type->transaction_form_day = $request->transaction_form_day;
                    $type->transaction_to_day = $request->transaction_to_day;
                    $type->cron_time = $request->cron_time;

                    $type->status = $request->status;
                    $type->updated_at = $this->datetime;
                    $type->updated_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "Settlement Cron Settings updated successfully");
                } else {

                    $type = new SettlementCronSetting;
                    $type->transaction_form = $request->transaction_form;
                    $type->transaction_to = $request->transaction_to;
                    $type->transaction_form_day = $request->transaction_form_day;
                    $type->transaction_to_day = $request->transaction_to_day;
                    $type->cron_time = $request->cron_time;

                    $type->status = $request->status;
                    $type->created_at = $this->datetime;
                    $type->created_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "Settlement Cron Settings created successfully");
                }
            }
        }

        return json_encode($res);
    }


    public function getGstCronSettingList(Request $request)
    {
        if ($request->ajax() || 1) {
            $form_data = $request->form;
            $search = $form_data['searchfor'];
            $status = $form_data['status_filter'];

            $columns = array(
                1 => 'id',
                7 => "created_at"
            );
            $limit = $request->length;
            $start = $request->start;
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');


            //get total:
            $payment = new \App\GstCronSetting();
            $paymentTable = $payment->getTable();
            $table = $paymentTable;
            //DB::enableQueryLog();

            $dataCount = $payment

                ->where(function ($query) use ($status, $paymentTable) {
                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search) {

                    $query->where('status', 'LIKE', '%' . $search . '%');
                })->select($paymentTable . '.id')

                ->count();


            if ($limit < 1) {
                $limit = $dataCount;
            }
            //DB::enableQueryLog();
            $data = $payment


                ->where(function ($query) use ($status, $paymentTable) {

                    if ($status) {
                        $query->where($paymentTable . '.status', $status);
                    }
                })
                ->where(function ($query) use ($search, $status) {
                    $query->where('status', 'LIKE', '%' . $search . '%');
                })

                ->offset(intval($start))
                ->limit(intval($limit))
                ->orderBy($order, $dir)
                ->get();
            // $query = DB::getQueryLog();
            //  dd(DB::getQueryLog());  
            // dd($data);

            return Datatables::of(collect($data))
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {

                    if (!empty($request->get('search'))) {

                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {


                            if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<button  id="edit_GstCronSetting" alt="Edit" class="btn btn-sm btn-success"  merchant="' . $row['id'] . '" orderid="' . $row['id'] . '" mode="edit">Edit<ion-icon name="checkbox-sharp"></ion-icon></button>';
                    // $btn.='  <button  id="edit_bacat_admin" alt="Edit" class="btn btn-sm btn-warning"  merchant="'.$row['id'].'" orderid="'.$row['id'].'" mode="edit">Update Status<ion-icon name="checkbox-sharp"></ion-icon></button>';

                    return $btn;
                })
                ->addColumn('created', function ($row) {

                    return Carbon::parse($row->created_at)->format('jS M Y h:i:s A');
                })


                ->addColumn('status', function ($row) {

                    return ucwords($row->status);
                })








                ->setFilteredRecords($dataCount)
                ->setTotalRecords($dataCount)
                ->setOffset($start)
                // ->with(['recordsTotal'=>$totalData, "recordsFiltered" => $totalFiltered,'start' => $start])
                ->with(['test' => 123])

                ->make(true);
        }
    }



    public function fetchGstCronSetting(Request $request)
    {


        $type = GstCronSetting::find($request->row_id);

        echo json_encode(["status" => true, "data" => $type]);
    }

    public function updateGstCronSetting(Request $request)
    {


        $res = array("success" => false, "type" => "error", "message" => "Something Went Wrong!");

        if ($request->isMethod('post')) {

            $attribute = array(
                'gst_cron_day' => 'Day Of Month',

                'gst_cron_time' => "Cron Fire At",
                'status' => 'Status'
            );
            $validator = Validator::make(
                $request->all(),
                [
                    'gst_cron_day' => 'required',
                    'gst_cron_time' => 'required',
                    'status' => 'required',

                ]
            );
            $validator->setAttributeNames($attribute);

            if ($validator->fails()) {
                $res['message'] = $validator->errors();
            } else {
                if ($request->row_id) {
                    $row_id = $request->row_id;
                    $type = GstCronSetting::find($row_id);

                    $type->gst_cron_time = $request->gst_cron_time;
                    $type->gst_cron_day = $request->gst_cron_day;

                    $type->status = $request->status;
                    $type->updated_at = $this->datetime;
                    $type->updated_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "GST Cron Settings updated successfully");
                } else {

                    $type = new GstCronSetting;
                    $type->gst_cron_time = $request->gst_cron_time;
                    $type->gst_cron_day = $request->gst_cron_day;


                    $type->status = $request->status;
                    $type->created_at = $this->datetime;
                    $type->created_by = auth()->guard('employee')->user()->id;
                    $type->save();
                    $res = array("success" => true, "type" => "success", "message" => "GST Cron Settings created successfully");
                }
            }
        }

        return json_encode($res);
    }
}
