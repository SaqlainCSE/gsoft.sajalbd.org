<?php

use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;


if(!function_exists('generate_client_no')){
    function get_generate_client_no(){
        $client_count = Client::query()
            ->withTrashed()
            ->count();
        $client_count = sprintf(date('m') .'%04d', $client_count ? $client_count + 1: 1);
        return "SGD{$client_count}";
    }
}

function dataTableData(Request $request, $model, $with = [])
{
    try {
        if ($request->start) {
            $request['page']  = $request->start / $request->length + 1;
        } else {
            $request['page']  = 0;
        }
        $zones = $model::query()->with($with);

        if ($request->has('search') && isset($request->search['value'])) {
            $searchString = $request->search['value'];

            $zones = $zones->where('z_name', 'like', "%{$searchString}%")
                ->orWhere('z_name', 'like', "%{$searchString}%");

            $request['page']  = 0;
        }

        return $zones->paginate($request->length);
    } catch (\Exception $ex) {
        // dd($ex);
        return false;
    }
}

function dataTableResponse(int $total, $data = [])
{
    return response()->json([
        'draw' => request()->draw,
        'recordsTotal' => $total,
        "recordsFiltered" => $total,
        'data' => $data
    ]);
}

function getCurrencySymbol()
{
    return "BDT";
}


if (!function_exists('formatted_date_time')) {
    function formatted_date_time($date)
    {
        return date('d M Y h:i A', strtotime($date));
    }
}

if (!function_exists('formatted_time')) {
    function formatted_time($date)
    {
        return date('h:i A', strtotime($date));
    }
}

if (!function_exists('formatted_date')) {
    function formatted_date($date)
    {
        if (!$date) return;
        return date('d-m-Y', strtotime($date));
    }
}

if (!function_exists('formatted_amount')) {
    function formatted_amount($amount)
    {
        $symbol = getCurrencySymbol();
        // $amount = number_format($amount, 2, '.', ',');
        $amount = bd_money_format($amount, 2, '.', ',');
        return "$symbol $amount";
    }
}

if (!function_exists('ordinal')) {
    function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }
}


if (!function_exists('amount_in_words')) {
    function amount_in_words(float $amount)
    {
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $here_digits = array('', 'Hundred', 'Thousand', 'Lac', 'Crore');
        while ($x < $count_length) {
            $get_divider = ($x == 2) ? 10 : 100;
            $amount = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($amount) {
                $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
            ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
            ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
            } else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
        return ($implode_to_Rupees ? $implode_to_Rupees . 'Taka Only' : '') . $get_paise;
    }
}

if (!function_exists('bd_money_format')) {
    function bd_money_format($number)
    {
        if (!$number) {
            return $number;
        }
        // $decimal = (string)(round($number - floor($number), 2));
        $substr = substr(strstr($number, '.'), 1, 2);
        
        if($substr){
            $decimal = "0." . $substr;
        } else {
            $decimal = "0.00";
        }
        
        
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for ($i = 0; $i < $length; $i++) {
            if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
                $delimiter .= ',';
            }
            $delimiter .= $money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if ($decimal != '0') {
            $result = $result . $decimal;
        } else {
            $result = $result . '.00';
        }
        $result = str_replace('-,', '-', $result);

        return $result;
    }

    function generateMemoNumber($id, $created_at) {
        $createdAt = Carbon::parse($created_at);
        $year = $createdAt->format('y');
        $month = $createdAt->format('m');
        // $day = $createdAt->format('d');
        $formattedId = str_pad($id, 4, '0', STR_PAD_LEFT);
        $memoNumber = $year . $month . $formattedId;
        return $memoNumber;
    }
}
