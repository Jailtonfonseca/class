<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Districts;
use App\Models\Regions;
use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class CitiesController extends Controller
{
    public $parentEntity = null;
    public $countryCode = null;
    public $admin1Code = null;
    public $admin2Code = null;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $code)
    {
        $country = null;
        $admin1 = null;
        $admin2 = null;
        // Parents Entities
        $parentEntities = ['country', 'admins1', 'admins2'];

        $this->parentEntity = request()->segment(2);

        if (!in_array($this->parentEntity, $parentEntities)) {
            abort(404);
        }

        // Country => City
        if ($this->parentEntity == 'country') {
            $this->countryCode = request()->segment(3);
            session(['countryCode' => $this->countryCode]);
            $country = Countries::where('code',$this->countryCode)->firstOrFail();
            $query = Cities::where('country_code',$this->countryCode);
        }

        // Admin1 => City
        if ($this->parentEntity == 'admins1') {
            $this->admin1Code = request()->segment(3);
            $admin1 = Regions::where('code', $this->admin1Code)->firstOrFail();
            if (!$admin1) {
                return response()->json(['error' => 'Region not found.'], 404);
            }
            $query = $admin1->cities();
        }

        // Admin2 => City
        if ($this->parentEntity == 'admins2') {
            $this->admin2Code = request()->segment(3);
            $admin2 = Districts::where('code', $this->admin2Code)->firstOrFail();
            if (!$admin2) {
                return response()->json(['error' => 'Region not found.'], 404);
            }
            $query = $admin2->cities();
        }

        if ($request->ajax()) {

            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            $columns = array(
                'id',
                'name',
                'country_code',
                'active'
            );
            $totalRecords = $query->count();

            if (!empty($params['search']['value'])) {
                $searchTerm = $params['search']['value'];
                $query->where(function ($query) use ($searchTerm) {
                $query->where('country_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('id', 'like', '%' . $searchTerm . '%');
                });
            }
            $filteredTotal = $query->count();

            $orderColumn = $columns[$params['order'][0]['column']];
            $orderDir = $params['order'][0]['dir'];
            $query->orderBy($orderColumn, $orderDir);

            $cities = $query->offset($params['start'])
                ->limit($params['length'])
                ->get();

            foreach ($cities as $row) {

            $rows = array();
            $rows[] = '<td>'.$row->id.'</td>';
            $rows[] = '<td><span class="text-truncate">'.$row->name.'</span></td>';
            $rows[] = '<td><span class="text-truncate">'.$row->subadmin1_code.'</span></td>';
            $rows[] = '<td><span class="text-truncate">'. ($row->subadmin2_code ? : '()').'</span></td>';
            $rows[] = '<td><span class="text-truncate bg-success p-1" style="border-radius: 4px; font-size: 13px;">'.($row->active == 1 ? 'Activated' : 'Inactive').'</span></td>';
            $rows[] = '<td>
                            <div class="d-flex">
                                <a href="" data-url="'.route('admin.cities.edit', ['city' => $row->id]).'" title="'.___('Edit').'" data-toggle="slidePanel" class="btn btn-icon btn-default me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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
            "data"            => $data   // total data array
        );
        return response()->json($json_data, 200);
    }

    return view('admin.cities.index', compact('country','admin1','admin2'), ['parentEntity' => $this->parentEntity]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $countryCode = session('countryCode');

        if (!$countryCode) {
            Log::error('Country code not found in session');
            abort(404, 'Country not found');
        }
            $country = Countries::where('code', $countryCode)->firstOrFail();

        $regions = $country->regions()->get();
        return view('admin.cities.create', compact('country', 'regions'));
    }

    // Getting district data for Dependent dropdown
    public function getDistricts($regionCode)
    {
        $region = Regions::where('code', $regionCode)->firstOrFail();
        $districts = $region->districts()->get();

        return response()->json($districts);
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
            'subadmin1' => ['required'],
            'subadmin2' => ['required'],
            'local_name' => ['required'],
            'name' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'population' => ['required'],
            'time_zone' => ['required'],
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

        $create = Cities::create([
            'country_code' => $request->country_code,
            'subadmin1_code' => $request->subadmin1,
            'subadmin2_code' => $request->subadmin2,
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'population' => $request->population,
            'time_zone' => $request->time_zone,
            'active' => $request->active
        ]);

        if ($create){
            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
        else {
            quick_alert_error(___('Upload Error'));
            return back();
        }
    }

    public function edit($id)
    {
        // $country = Countries::where('code', $code)->firstOrFail();
        $city = Cities::findOrFail($id);
        return view('admin.cities.edit',compact('city'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'local_name' => ['required'],
            'name' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'population' => ['required'],
            'time_zone' => ['required'],
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

        $city = Cities::find($id);

        $update = $city->update([
            'country_code' => $city->country_code,
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'population' => $request->population,
            'time_zone' => $request->time_zone,
            'active' => $request->active
        ]);

        if ($update){
            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
        else {
            quick_alert_error(___('Upload Error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Cities $cities
     */
    public function show(Cities $cities)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cities  $cities
     */
    public function destroyCity(Cities $cities)
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
        Cities::whereIn('id', $ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }

}


