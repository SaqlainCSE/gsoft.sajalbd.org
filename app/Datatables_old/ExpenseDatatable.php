<?php
namespace App\Datatables;

use App\Models\Expense;
use App\Models\TrxHead;
use Illuminate\Http\Request;

class ExpenseDatatable
{
    public function handel(Request $request)
    {
        try {
            $zones = Expense::query()
                ->with('trxHead', 'paymentMethod', 'expenseBy')

                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('reference_no', 'like', "%{$request->search['value']}%")
                        ->orWhere('date', 'like', "%{$request->search['value']}%")
                        ->orWhere('amount', 'like', "%{$request->search['value']}%");
                })

                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }

            $data = $zones->map(function ($row, $index) use ($no) {
                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'trx_head' => $row->trxHead?->name,
                    'amount' => bd_money_format($row->amount),
                    'date' => formatted_date($row->date),
                    'payment_method' => $row->paymentMethod?->name,
                    'reference_no' => $row->reference_no,
                    'note' => $row->trx_head_id,
                    'expense_by' => $row->expenseBy?->name,
                ];
                return $data_array;
            });
            return dataTableResponse($zones->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
