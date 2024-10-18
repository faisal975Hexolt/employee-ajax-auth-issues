<?php

namespace App\Exports;

use App\Models\Recon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReconExportCsv implements FromQuery, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Recon::query()->select(
            'merchant_name',
            'bank_name',
            'reason',
            'txn_time',
            'acquirer_txn_time',
            'payer_name',
            'vpa',
            'mobile_number',
            'amount',
            'acquirer_amount',
            'txn_id',
            'acquirer_txn_id',
            'txn_status',
            'acquirer_txn_status',
            'rrn',
            'acquirer_rrn',
            'ref_id'
        )->where('recon_file_id', $this->request->file);

        // Apply column filter if present
        if ($this->request->has('filter') && $this->request->filter != '') {
            $filterColumn = $this->request->filter;
            $query->where($filterColumn, 'like', '%' . $this->request->value . '%');
        }

        if ($this->request->has('remark') && $this->request->remark != '') {
            $query->where('reason', 'like', '%' . $this->request->remark . '%');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Merchant Name',
            'Bank Name',
            'Reason',
            'Transaction Time',
            'Acquirer Transaction Time',
            'Payer Name',
            'VPA',
            'Mobile Number',
            'Amount',
            'Acquirer Amount',
            'Transaction ID',
            'Acquirer Transaction ID',
            'Transaction Status',
            'Acquirer Transaction Status',
            'RRN',
            'Acquirer RRN',
            'Ref ID',
        ];
    }
}
