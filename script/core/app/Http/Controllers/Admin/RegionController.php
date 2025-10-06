<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Regions;
use Illuminate\Http\Request;
use Validator;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $CountryCode)
    {
        $country = Countries::where('code', $CountryCode)->firstOrFail();
        session(['countryCode' => $CountryCode]);

        if ($request->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            $columns = array(
                'id',
                'name',
                'country_code',
                'active'
            );

            $query = $country->regions();
            $totalRecords = $query->count();

            if (!empty($params['search']['value'])) {
                $searchTerm = $params['search']['value'];
                $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('id', 'like', '%' . $searchTerm . '%');
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
            <div>
            <a href="'.route('admin.regions.districts.index',['admin1Code' => $row->code]).'"><span class="badge bg-info me-1 p-1"><i class="icon-feather-folder"></i> District</span></a>
            <a href="'.route('admin.admins1.cities.index', ['code' => $row->code, 'name' => $row->name]).'"><span class="badge bg-info p-1"><i class="icon-feather-folder"></i> '.___('Cities').'</span></div></a>
                        </td>';
            $rows[] = '<td><span class="text-truncate badge bg-success p-1">'.($row->active == 1 ? 'Activated' : 'Inactive').'</span></td>';
            $rows[] = '<td>
                            <div class="d-flex">
                                <a href="" data-url="'.route('admin.regions.edit', ['region' => $row->code]).'" title="'.___('Edit').'" data-toggle="slidePanel" class="btn btn-icon btn-default me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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

        return view('admin.regions.index', ['country' => $country, 'CountryCode' => $CountryCode]);
    }

    /**
     * Display the specified resource.
     *
     * @param Regions $regions
     */
    public function show(Regions $regions)
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
        $countryCode = $request->countryCode;
        $country = Countries::where('code', $countryCode)->firstOrFail();
        return view('admin.regions.create',['country' => $country]);
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
        $region = Regions::where('country_code', $countryCode)->orderBy('code', 'desc')->first();

         $lastRegion = 0;
         if($region){
             $lastRegion = substr($region->code,3);
         }
         $regionId = str_pad($lastRegion + 1, 2, '0', STR_PAD_LEFT);
         $code = $countryCode . '.' . $regionId;

         $region = Regions::create([
            'code' => $code,
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
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function edit($region)
    {
        $region = Regions::findOrFail($region);
        return view('admin.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Regions $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $region)
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

        $regionData = Regions::find($region);

            $update = $regionData->update([
                'code' => $region,
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
     * @param  \App\Models\Regions  $regions
     */
    public function destroy(Regions $regions)
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
        Regions::whereIn('id', $ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }

}
