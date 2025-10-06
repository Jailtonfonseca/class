<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Districts;
use App\Models\Regions;
use Illuminate\Http\Request;
use Validator;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $districtCode)
    {
        $regions = Regions::where('code', $districtCode)->firstOrFail();
        $countryCode = $regions->country_code;

        if ($request->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            $columns = array(
                'id',
                'code',
                'name',
                'country_code',
                'active'
            );

            $query = $regions->districts();
            $totalRecords = $query->count();

            if (!empty($params['search']['value'])) {
                $searchTerm = $params['search']['value'];
                $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('code', 'like', '%' . $searchTerm . '%');
                });
            }
            $filteredTotal = $query->count();

            $orderColumn = $columns[$params['order'][0]['column']];
            $orderDir = $params['order'][0]['dir'];
            $query->orderBy($orderColumn, $orderDir);

            $regions = $query->offset($params['start'])
                ->limit($params['length'])
                ->get();

            foreach ($regions as $row) {

            $rows = array();
            $rows[] = '<td>'.$row->code.'</td>';
            $rows[] = '<td><span class="text-truncate">'.$row->name.'</span>
                            <div class="d-flex">
                            <a href="'.route('admin.admins2.cities.index', ['code' => $row->code]).'"><span class="badge bg-info p-1"><i class="icon-feather-folder"></i> '.___('Cities').'</span></div></a>
                        </td>';
            $rows[] = '<td><span class="text-truncate badge bg-success p-1">'.($row->active == 1 ? 'Activated' : 'Inactive').'</span></td>';
            $rows[] = '<td>
                            <div class="d-flex">
                                <a href="" data-url="'.route('admin.districts.edit', ['district' => $row->code]).'" title="'.___('Edit').'" data-toggle="slidePanel" class="btn btn-icon btn-default me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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
            "recordsFiltered" => intval($filteredTotal),
            "data"            => $data
        );
        return response()->json($json_data, 200);
    }

    return view('admin.districts.index', ['region' => $regions, 'districtCode' => $districtCode, 'countryCode' => $countryCode]);
}

/**
     * Display the specified resource.
     *
     * @param Districts $districts
     */
    public function show(Districts $districts)
    {
        abort(404);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $districtCode = $request->districtCode;
        $countryCode = $request->countryCode;
        $region = Regions::where('code', $request->districtCode)->firstOrFail();
        return view('admin.districts.create',compact('region','districtCode','countryCode'));
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
            'country_code' => ['required'],
            'name' => ['required'],
            'active' => ['required']
         ]);

         $errors = [];
         if ($validator->fails()) {
             foreach ($validator->errors()->all() as $error) {
                 $errors[] = $error;
             }
             $result = array('success' => false, 'message' => implode('<br>', $errors));
             return response()->json($result, 200);
         }

        // Generate the region code by combining the country code and region ID
        $countryCode = $request->country_code;
        $district = Districts::where('country_code', $countryCode)
                    ->OrWhere('subadmin1_code', $request->subadmin1_code)
                    ->orderBy('code', 'desc')->first();

        $lastDistrict = 0;
        if($district){
            $lastDistrict = substr($district->code,3);
            $pieces = explode(".",(string) $district->code);
            $code_count = count($pieces);
            if($code_count == 3){
                $lastDistrict = $pieces[2];
            }
        }


        $districtId = str_pad($lastDistrict + 1, 2, '0', STR_PAD_LEFT);
        $code =  $request->subadmin1_code .'.'. $districtId;


         $region = Districts::create([
            'code' => $code,
            'subadmin1_code' => $request->subadmin1_code,
            'country_code' => $request->country_code,
            'name' => $request->name,
            'active' => $request->active
         ]);

         if ($region) {
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
     * @param  \App\Models\Districts  $district
     * @return \Illuminate\Http\Response
     */
    public function edit($district)
    {
        $district = Districts::find($district);
        return view('admin.districts.edit', compact('district'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Regions $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $district)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => ['required'],
            'name' => ['required'],
            'active' => ['required']
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $districtData = Districts::find($district);

            $update = $districtData->update([
                'code' => $request->district_code,
                'country_code' => $request->country_code,
                'name' => $request->name,
                'active' => $request->active
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
     * @param  \App\Models\Districts  $districts
     */
    public function destroy(Districts $districts)
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
        Districts::whereIn('id', $ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }

}
