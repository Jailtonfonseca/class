<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Timezones;
use Illuminate\Http\Request;
use Validator;

class TimezoneController extends Controller
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
                'country_code',
                'time_zone_id',
                'gmt',
                'dst',
                'raw'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $timezones = Timezones::where('country_code', 'like', '%' . $q . '%')
                    ->OrWhere('time_zone_id', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $timezones = Timezones::orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Timezones::count();
            foreach ($timezones as $row) {

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td><span class="text-truncate">'.$row->country_code.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->time_zone_id.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->gmt.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->dst.'</span></td>';
                $rows[] = '<td><span class="text-truncate">'.$row->raw.'</span></td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="" data-url="'.route('admin.timezones.edit', $row->id).'" title="'.___('Edit').'" data-toggle="slidePanel" class="btn btn-icon btn-default me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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

        return view('admin.timezones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Timezones $timezones
     */
    public function show(Timezones $timezones)
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
        $countries = Countries::all();
        return view('admin.timezones.create', compact('countries'));
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
             'country' => ['required', 'string', 'max:2'],
             'timezone' => ['required'],
             'gmt' => ['required', 'numeric'],
             'dst' => ['required', 'numeric'],
             'raw' => ['required', 'numeric']
         ]);

         $errors = [];
         if ($validator->fails()) {
             foreach ($validator->errors()->all() as $error) {
                 $errors[] = $error;
             }
             $result = array('success' => false, 'message' => implode('<br>', $errors));
             return response()->json($result, 200);
         }

             $timezone = Timezones::create([
                 'country_code' => $request->country,
                 'time_zone_id' => $request->timezone,
                 'gmt' => $request->gmt,
                 'dst' => $request->dst,
                 'raw' => $request->raw
             ]);

             if ($timezone) {
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
     * @param  \App\Models\Timezones  $timezones
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = Countries::all();
        $timezone = Timezones::find($id);
        return view('admin.timezones.edit', compact('timezone', 'countries'));
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
            'country' => ['required', 'string', 'max:2'],
            'timezone' => ['required'],
            'gmt' => ['required', 'numeric'],
            'dst' => ['required', 'numeric'],
            'raw' => ['required', 'numeric']
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $timezoneData = Timezones::find($request->timezoneId);

            $update = $timezoneData->update([
                 'country_code' => $request->country,
                 'time_zone_id' => $request->timezone,
                 'gmt' => $request->gmt,
                 'dst' => $request->dst,
                 'raw' => $request->raw
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
     * @param  \App\Models\Timezones  $timezones
     */
    public function destroy(Timezones $timezones)
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
        Timezones::whereIn('id', $ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
