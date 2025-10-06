<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currencies;
use Illuminate\Http\Request;
use Validator;

class CurrencyController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            //define index of column
            $columns = array(
                'id',
                'name',
                'code',
                'html_entity',
                'in_left'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $currencies = Currencies::where('id', 'like', '%' . $q . '%')
                    ->OrWhere('name', 'like', '%' . $q . '%')
                    ->OrWhere('code', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $currencies = Currencies::orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Currencies::count();
            foreach ($currencies as $row) {

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td><span class="text-truncate">'.$row->code.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->name.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->html_entity.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->in_left.'</span></td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="" data-url="'.route('admin.currencies.edit', ['currency' => $row->id]).'" title="'.___('Edit').'" data-toggle="slidePanel" class="btn btn-icon btn-default me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                </div>
                            </td>';
                $rows[] = '<td>
                                <div class="checkbox">
                                <input type="checkbox" id="check_'.$row->id.'" value="'.$row->id.'" class="quick-check">
                                <label for="check_'.$row->id.'"><span class="checkbox-icon"></span></label>
                            </div>
                           </td>';

                $rows['DT_RowId'] = $row->id;
                $data[] = $rows;
            }

            $json_data = array(
                "draw"            => intval( $params['draw'] ),
                "recordsTotal"    => intval( $totalRecords ),
                "recordsFiltered" => intval($totalRecords),
                "data"            => $data   // total data array
            );
            return response()->json($json_data, 200);
        }

        return view('admin.currencies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Currencies $currencies
     */
    public function show(Currencies $currencies)
    {
        abort(404);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.currencies.create');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'name' => ['required', 'string', 'min:2', 'max:50'],
             'code' => ['required', 'string', 'min:2', 'max:3'],
             'in_left' => ['required', 'boolean'],
             'decimal_places' => ['required'],
             'decimal_separator' => ['required'],
             'thousand_separator' => ['required']
         ]);

         $errors = [];
         if ($validator->fails()) {
             foreach ($validator->errors()->all() as $error) {
                 $errors[] = $error;
             }
             $result = array('success' => false, 'message' => implode('<br>', $errors));
             return response()->json($result, 200);
         }

             $currency = Currencies::create([
                 'code' => $request->code,
                 'name' => $request->name,
                 'html_entity' => $request->html_entity,
                 'font_arial' => $request->font_arial,
                 'font_code2000' => $request->font_code2000,
                 'unicode_decimal' => $request->unicode_decimal,
                 'unicode_hex' => $request->unicode_hex,
                 'in_left' => $request->in_left,
                 'decimal_places' => $request->decimal_places,
                 'decimal_separator' => $request->decimal_separator,
                 'thousand_separator' => $request->thousand_separator
             ]);

             if ($currency) {
                 $result = array('success' => true, 'message' => ___('Created Successfully'));
                 return response()->json($result, 200);
                 return redirect()->route('admin.currencies.index');
             }
             else {
                 quick_alert_error(___('Upload Error'));
                 return back();
             }
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function edit($currency)
    {
        $currencies = Currencies::find($currency);
        return view('admin.currencies.edit', compact('currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Currencies $currencies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'code' => ['required', 'string', 'min:2', 'max:3'],
            'in_left' => ['required', 'boolean'],
            'decimal_separator' => ['required'],
            'thousand_separator' => ['required']
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $currencyData = Currencies::find($request->currencyId);

            $update = $currencyData->update([
                'code' => $request->code,
                'name' => $request->name,
                'html_entity' => $request->html_entity,
                'font_arial' => $request->font_arial,
                'font_code2000' => $request->font_code2000,
                'unicode_decimal' => $request->unicode_decimal,
                'unicode_hex' => $request->unicode_hex,
                'in_left' => $request->in_left,
                'decimal_places' => $request->decimal_places,
                'decimal_separator' => $request->decimal_separator,
                'thousand_separator' => $request->thousand_separator
            ]);

            if ($update) {
                $result = array('success' => true, 'message' => ___('Updated Successfully'));
                return response()->json($result, 200);
            }
            else {
                quick_alert_error(___('Upload Error'));
                return back();
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currencies  $currencies
     */
    public function destroy(Currencies $currencies)
    {
        abort(404);
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        Currencies::whereIn('id', $ids)->delete();

        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
