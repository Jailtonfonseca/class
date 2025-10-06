<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Currencies;
use Illuminate\Http\Request;
use Validator;

class CountryController extends Controller
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
                'code',
                'name',
                'active'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $countries = Countries::where('code', 'like', '%' . $q . '%')
                    ->orWhere('name', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $countries = Countries::orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Countries::count();
            foreach ($countries as $row) {

                if ($row->active){
                    $status = '<span class="badge bg-success">'.___('Activated').'</span>';
                    $install_button = '<a href="#" class="btn btn-icon btn-warning me-1 item-ajax-button" title="'.___('Uninstall').'" data-ajax-action="uninstallCountry" data-alert-message="'.___('Are you sure?').'" data-tippy-placement="top"><i class="icon-feather-x"></i></a>';
                }
                else {
                    $status = '<span class="badge bg-warning">'.___('Not Active').'</span>';
                    $install_button = '<a href="#" class="btn btn-icon btn-success me-1 item-ajax-button" title="'.___('Install').'" data-ajax-action="installCountry" data-alert-message="'.___('Are you sure?').'" data-tippy-placement="top"><i class="icon-feather-check"></i></a>';
                }
                $rows = array();
                $rows[] = '<td><span class="text-truncate">'.$row->id.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->code.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->name.'</span>
                               <div>
                                   <a href="'.route('admin.countries.regions.index',['countryCode' => $row->code]).'"><span class="badge bg-info fs-tiny me-1 p-1"><i class="icon-feather-folder"></i> '.___('Regions(State)').'</span></a>
                                   <a href="'.route('admin.cities.index', ['code' => $row->code, 'name' => $row->name]).'"><span class="badge bg-info fs-tiny p-1"><i class="icon-feather-folder"></i> '.___('Cities').'</span></a>
                               </div>
                           </td>';
                $rows[] = '<td>'.$status.'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="" data-url="'.route('admin.countries.edit', ['country' => $row->code]).'" title="'.___('Edit').'" data-toggle="slidePanel" class="btn btn-icon btn-default me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                    '.$install_button.'
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

        return view('admin.countries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Countries $countries
     */
    public function show(Countries $countries)
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
        $currencies = Currencies::all();
        return view('admin.countries.create', compact('currencies'));
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
            'code' => ['required'],
            'local_name' => ['required'],
            'name' => ['required'],
            'currency' => ['required'],
            'phone_code' => ['nullable'],
            'map_zoom' => ['required', 'integer', 'min:4', 'max:20'],
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $country = Countries::create([
            'code' => $request->code,
            'name' => $request->name,
            'currency_code' => $request->currency,
            'phone' => $request->phone,
            'languages' => $request->language,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'map_zoom' => $request->map_zoom
        ]);

        if ($country) {
            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
        else {
            quick_alert_error(___('Upload Error'));
            return back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function edit($country_code)
    {
        $currencies = Currencies::all();
        $countryData = Countries::where('code',$country_code)->first();
        if (!$countryData) {
            quick_alert_error(___('Country not found'));
            return back();
        }
        return view('admin.countries.edit', compact('countryData', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Countries $countries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $country_code)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required'],
            'name' => ['required'],
            'currency' => ['required'],
            'phone' => ['nullable'],
            'map_zoom' => ['required', 'integer', 'min:4', 'max:20'],
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $countryData = Countries::where('code',$country_code)->first();

        $update = $countryData->update([
            'code' => $request->code,
            'name' => $request->name,
            'currency_code' => $request->currency,
            'phone' => $request->phone,
            'languages' => $request->language,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'map_zoom' => $request->map_zoom
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
     * @param  \App\Models\Countries  $countries
     */
    public function destroy(Countries $countries)
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
        Countries::whereIn('id', $ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
