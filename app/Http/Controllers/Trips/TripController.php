<?php

namespace App\Http\Controllers\Trips;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trips\TripRequest;
use App\Http\Requests\Trips\TripRequestAjax;
use App\Http\Resources\Trips\TripResource;
use App\Models\CompleteTripDaily;
use App\Models\Constant;
use App\Models\StartEndTime;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $length = \request()->get('length', 10);
            if (\request()->get('length') && \request()->get('length') == -1) {
                $length = Trip::query()->count();
            }

            $items = Trip::query()->with(['captain', 'owner'])->orderBy(getColAndDirForOrderBy()['col'], getColAndDirForOrderBy()['dir'])->filter()
                ->paginate($length, '*', '*', getPageNumber($length));
            return datatable_response($items, null, TripResource::class);
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $length = \request()->get('length', 10);
            if (\request()->get('length') && \request()->get('length') == -1) {
                $length = Trip::query()->count();
            }
            $items = Trip::query()->with(['captain', 'owner'])->orderBy(getColAndDirForOrderBy()['col'], getColAndDirForOrderBy()['dir'])->filter()
                ->paginate($length, '*', '*', getPageNumber($length));
            return datatable_response($items, null, TripResource::class);
        }
        $customers = User::query()->customers()->get();
        $places = User::query()->places()->get();
        $captains = User::query()->captains()->get();
        $active_customers = collect($customers)->where('is_deleted', '=', 0);
        $active_places = collect($places)->where('is_deleted', '=', 0);
        $captain_ids = User::captainReadyForTrips();
        $active_captains = User::query()->active()->captains()->whereNotIn('id', $captain_ids)->get();
        $start_end_time = StartEndTime::query()->orderByDesc('created_at')->first();


        $page_breadcrumbs = [
            ['page' => route('dashboard.index'), 'title' => 'الرئيسية', 'active' => true],
            ['page' => '#', 'title' => 'الرحلات', 'active' => false],
        ];
        return view('trips.index', [
            'page_title' => 'الرئيسية',
            'page_breadcrumbs' => $page_breadcrumbs,
            'customers' => $customers,
            'captains' => $captains,
            'places' => $places,
            'active_customers' => $active_customers,
            'active_places' => $active_places,
            'active_captains' => $active_captains,
            'start_end_time' => $start_end_time,
        ]);
    }

    public function archive(Request $request)
    {
        if ($request->ajax()) {
            $length = \request()->get('length', 10);
            if (\request()->get('length') && \request()->get('length') == -1) {
                $length = Trip::query()->count();
            }
            $items = Trip::query()->with(['captain', 'owner'])->orderBy(getColAndDirForOrderBy()['col'], getColAndDirForOrderBy()['dir'])->filter()
                ->paginate($length, '*', '*', getPageNumber($length));
            return datatable_response($items, null, TripResource::class);
        }
        $customers = User::query()->customers()->get();
        $places = User::query()->places()->get();
        $captains = User::query()->captains()->get();
        $active_customers = collect($customers)->where('is_deleted', '=', 0);
        $active_places = collect($places)->where('is_deleted', '=', 0);
        $page_breadcrumbs = [
            ['page' => route('dashboard.index'), 'title' => 'الرئيسية', 'active' => true],
            ['page' => '#', 'title' => 'الرحلات', 'active' => false],
            ['page' => '#', 'title' => 'الأرشيف', 'active' => false],
        ];
        return view('trips.archive', [
            'page_title' => 'الأرشيف',
            'page_breadcrumbs' => $page_breadcrumbs,
            'customers' => $customers,
            'captains' => $captains,
            'places' => $places,
            'active_customers' => $active_customers,
            'active_places' => $active_places,
        ]);
    }

    public function create($id = null)
    {
        $item = null;
        $page_title = __('lang.create');
        if (isset($id)) {
            $page_title = __('lang.edit');
            try {
                $item = Trip::query()->filter()->findOrFail($id);
            } catch (QueryException $exception) {
                return $this->invalidIntParameter();
            }
        }
        $page_breadcrumbs = [
            ['page' => route('dashboard.index'), 'title' => 'الرئيسية', 'active' => true],
            ['page' => route('trips.index'), 'title' => 'الرحلات', 'active' => true],
            ['page' => '#', 'title' => isset($id) ? __('lang.edit') : __('lang.add'), 'active' => false],
        ];

        $customers = User::query()->active()->customers()->get();
        $places = User::query()->active()->places()->get();
        $captain_ids = User::captainReadyForTrips($item);
        $captains = User::query()->active()->captains()->whereNotIn('id', $captain_ids)->get();

        return view('trips.create', [
            'page_title' => $page_title,
            'page_breadcrumbs' => $page_breadcrumbs,
            'item' => @$item,
            'customers' => $customers,
            'captains' => $captains,
            'places' => $places,
        ]);
    }

    public function store(TripRequest $request, $id = null)
    {
        try {
            $data = $request->only(Trip::FILLABLE);
            if ($request->get('owner', null) == 'place') {
                $data['owner_id'] = $request->get('place_id', null);
                $data['is_owner_place'] = 1;
                $data['payment_type'] = Enum::POSTPAID;
            } else {
                $data['owner_id'] = $request->get('customer_id', null);
                $data['is_owner_place'] = 0;
                $data['payment_type'] = Enum::IMMEDIATELY;
            }
            if ($data['amount'] >= 0) {
                $data['customer_paid'] = 1;
            } else {
                $data['amount'] = null;
            }
            DB::beginTransaction();
            $item = Trip::query()->updateOrCreate([
                'id' => $id,
            ], $data);
            DB::commit();

            return $this->returnBackWithSaveDone();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->returnBackWithSaveDoneFailed();
        }
    }

    public function ajax_store(TripRequestAjax $request, $id = null)
    {
        try {
            $data = $request->only(Trip::FILLABLE);
            if ($request->get('owner', null) == 'place') {
                $data['owner_id'] = $request->get('place_id', null);
                $data['is_owner_place'] = 1;
//              $data['payment_type'] = Enum::POSTPAID;
                if ($request->get('add_or_cancel_place_value') == 2 && $request->get('place_name')) {
                    $place_data['name'] = $request->get('place_name');
                    $place_data['phone'] = $request->get('place_phone');
                    $place_data['role'] = Enum::PLACE;
                }
            } else {
                $data['owner_id'] = $request->get('customer_id', null);
                $data['is_owner_place'] = 0;
                $data['payment_type'] = Enum::IMMEDIATELY;
                if ($request->get('add_or_cancel_customer_value') == 2 && $request->get('customer_name')) {
                    $customer_data['name'] = $request->get('customer_name');
                    $customer_data['phone'] = $request->get('customer_phone');
                    $customer_data['role'] = Enum::CUSTOMER;
                }
            }
            if ($data['amount'] >= 0) {
                $data['customer_paid'] = 1;
            } else {
                $data['amount'] = null;
            }

            DB::beginTransaction();
            if (isset($customer_data)) {
                $customer = User::query()->create($customer_data);
                $data['owner_id'] = $customer->id;
            } else if (isset($place_data)) {
                $place = User::query()->create($place_data);
                $data['owner_id'] = $place->id;
            }

            $item = Trip::query()->updateOrCreate([
                'id' => $id,
            ], $data);
            DB::commit();

            return response()->json([
                'status' => true,
                'data' => [
                    'item' => $item
                ],
                'msg' => 'تمت العملية بنجاح'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ ما'
            ]);
        }
    }


    public function completeSelected(Request $request)
    {

        try {
            $constants = Constant::query()->get();
            $ratio = getConstantByKey($constants, 'ratio')->value;
            $fix_amount = getConstantByKey($constants, 'fix_amount')->value;
            $ids = $request->get('ids');
            $captain_id = $request->get('captain_id', null);
            $fix_amount = $request->get('fix_amount', $fix_amount);
            DB::beginTransaction();
            $start_end_time = StartEndTime::query()->orderByDesc('created_at')->first();
            $exist_trips_not_selected = Trip::query()
                ->where('created_at', '>=', $start_end_time->start_time)
                ->where('status', Enum::PENDING)
                ->where('captain_id', $captain_id)
                ->whereNotIn('id', $ids)
                ->first();
            if ($exist_trips_not_selected) {
                return $this->response_json(false, StatusCodes::VALIDATION_ERROR, 'يجب عليك تحديد كل الرحلات  الغير مكتملة لهذا الكابتن لاتمام العملية بنجاح');

            }

            $item = CompleteTripDaily::query()->create([
                'completed_at' => now(),
                'ids_trips' => $ids,
                'ratio' => $ratio,
                'fix_amount' => $fix_amount,
                'captain_id' => $captain_id
            ]);
            $result = Trip::query()->pending()->closed()->whereIn('id', $ids)->update([
                'status' => Enum::COMPLETED,
                'complete_trip_daily_id' => $item->id
            ]);
            if ($result) {
                $totalAmount = DB::table('trips')
                    ->whereIn('id', $ids)
                    ->sum('amount');
                $TotalAmountAfterDiscountForOffice = $totalAmount ? (($totalAmount * $ratio) + floatval($fix_amount)) : 0;
                $decimalPart = $TotalAmountAfterDiscountForOffice - floor($TotalAmountAfterDiscountForOffice);

                if ($decimalPart >= 0.44) {
                    $TotalAmountAfterDiscountForOffice = floor($TotalAmountAfterDiscountForOffice) + 1;
                } else {
                    $TotalAmountAfterDiscountForOffice = floor($TotalAmountAfterDiscountForOffice);
                }

                $TotalAmountAfterDiscount = $totalAmount - $TotalAmountAfterDiscountForOffice;


                $item->update([
                    'total_amount' => $totalAmount,
                    'total_amount_for_captain' => $TotalAmountAfterDiscount,
                    'total_amount_for_office' => $TotalAmountAfterDiscountForOffice,
                ]);
            }
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }

    public function closeSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
            $closed_amount = Constant::query()->where('key', '=', 'closed_amount')->firstOrFail();
            $result = Trip::query()->notClosed()->whereIn('id', $ids)->update([
                'amount' => $closed_amount ? $closed_amount->value : null
            ]);
        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }

    public function updatePrice(Request $request)
    {
        $id = $request->get('id');
        $amount = $request->get('amount');
        try {
            if ($id && ($amount >= 0)) {
                $result = Trip::query()->findOrFail($id)->update([
                    'amount' => $amount
                ]);
            } else {
                return $this->invalidIntParameterJson();
            }

        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }

    public function updateFrom(Request $request)
    {
        $id = $request->get('id');
        $from = $request->get('from');
        try {
            if ($id && $from) {
                $result = Trip::query()->findOrFail($id)->update([
                    'from' => $from
                ]);
            } else {
                return $this->invalidIntParameterJson();
            }

        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }

    public function updateTo(Request $request)
    {
        $id = $request->get('id');
        $to = $request->get('to');
        try {
            if ($id && $to) {
                $result = Trip::query()->findOrFail($id)->update([
                    'to' => $to
                ]);
            } else {
                return $this->invalidIntParameterJson();
            }

        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }

    public function cancelSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
            $result = Trip::query()->pending()->whereIn('id', $ids)->update([
                'status' => Enum::CANCELED
            ]);
        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }

    public function getAvailableCaptains(Request $request)
    {
        $captain_ids = User::captainReadyForTrips();
        $captains = User::query()->active()->captains()->whereNotIn('id', $captain_ids)->get();
        return response()->json([
            'status' => true,
            'data' => [
                'captains' => $captains
            ]
        ]);
    }

    public function print(Request $request)
    {
        $ids = $request->get('ids');
        $trips = Trip::query()->with(['captain'])->filterPrint()->get();
        $owner_name = '';
        if ($trips && count($trips) > 0  && false) {

            if ((request('place_filter') && !empty(request('place_filter')))) {
                $place = User::query()->places()->find(request('place_filter'));
                $owner_name = $place->name;
            } elseif ((request('customer_filter') && !empty(request('customer_filter')))) {
                $place = User::query()->customers()->find(request('customer_filter'));
                $owner_name = $place->name;
            }

        }

        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//        $pdf->SetCreator(PDF_CREATOR);
//        $pdf->SetAuthor('Nicola Asuni');
//        $pdf->SetTitle('TCPDF Example 018');
//        $pdf->SetSubject('TCPDF Tutorial');
//        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');


// set header and footer fonts
//        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
        $lg = array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

// set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);

// ---------------------------------------------------------


// add a page
        $pdf->AddPage();

// Restore RTL direction
        $pdf->setRTL(true);
        $font_path = public_path('assets/fonts/IBM_Plex_Sans_Arabic/IBMPlexSansArabic-Regular.ttf');

// Check if the font file exists
        if (!file_exists($font_path)) {
            die('Font file not found: ' . $font_path);
        }
        $fontname = \TCPDF_FONTS::addTTFfont($font_path, 'TrueTypeUnicode', '', 96);

// set font
//        $pdf->SetFont('Aldhabi', '', 13);
        $pdf->SetFont($fontname, '', 10,true);

// print newline
        $pdf->Ln();

// Arabic and English content
//        $htmlcontent = '<h4>المكان / الزبون : ' . $owner_name . '</h4>
        $htmlcontent = '

<table  style=" border-collapse: collapse; width: 100%;" cellpadding="5" >
   <tbody>
  <tr>
    <th style="  border: 1px solid #ddd; ;width: 45px">#</th>
    <th style="  border: 1px solid #ddd; ;">صاحب الطلب</th>
    <th style="  border: 1px solid #ddd; ;">الكابتن</th>
    <th style="  border: 1px solid #ddd; ;">من</th>
    <th style="  border: 1px solid #ddd; ;">الى</th>
    <th style="  border: 1px solid #ddd; ;;width: 50px">السعر</th>
    <th style="  border: 1px solid #ddd; ;width: 174px">التاريخ</th>
  </tr>';
        foreach ($trips as $index => $trip) {
            $captain_name = @$trip->captain->name;
            if($trip->status == Enum::COMPLETED){
                $backgroundColor = '#f9eec2;';
            }elseif ($trip->status == Enum::PENDING && (!is_null($trip->amount))){
                $backgroundColor = '#d0ebfb;';
            }elseif ($trip->status == Enum::PENDING && (is_null($trip->amount))){
                $backgroundColor = '#f9eec2;';
            }elseif ($trip->status == Enum::CANCELED){
                $backgroundColor = '#fdcfdd;';
            }
            $htmlcontent .= '
 <tr style="background-color: ' . $backgroundColor . '; ">
  <td style="border: 1px solid #ddd; width: 45px">' . ($index+1) . '</td>
  <td style="border: 1px solid #ddd; margin: 100px">' . @$trip->owner->name . '</td>
  <td style="border: 1px solid #ddd; ">' . $captain_name . '</td>
  <td style="  border: 1px solid #ddd; ">' . $trip->from . '</td>
  <td style="  border: 1px solid #ddd; ;">' . $trip->to . '</td>
  <td style="  border: 1px solid #ddd; ;width: 50px">' . $trip->amount . '</td>
  <td style="  border: 1px solid #ddd; ;width: 174px">' . $trip->created_at . '</td>
 </tr>';
        }

        $htmlcontent .= '</tbody></table>';
        $pdf->WriteHTML($htmlcontent, true, 0, true, 0);


// ---------------------------------------------------------

//Close and output PDF document
        $pdf->Output('trips.pdf', 'I');
    }
}
