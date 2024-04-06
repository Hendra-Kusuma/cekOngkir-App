<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Courier;
use App\Models\Province;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $province = $this->getProvince();
        $courier = $this->getCourier();
        // return view('home', compact('province'));
        return view('home', ['province' => $province, 'courier' => $courier]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getProvince(){
        return Province::pluck('title','code');
    }

    public function getCourier(){
        return Courier::all();
    }
    
    public function getCities($id){
        return City::where('province_code', $id)->pluck('title','code');
    }

    public function searchCities(Request $request)
    {
        $search = $request->search;

        if (empty($search)) {
            $cities = City::orderBy('title', 'asc')
                ->select('id', 'title')
                ->limit(5)
                ->get();
        } else {
            $cities = City::orderBy('title', 'asc')
                ->where('title', 'like', '%' . $search . '%')
                ->select('id', 'title')
                ->limit(5)
                ->get();
        }

        $response = [];
        foreach ($cities as $city) {
            $response[] = [
                'id' => $city->id,
                'text' => $city->title
            ];
        }
        return json_encode($response);
    }

    public function getCity($code) {
        return City::where('code', $code)->first();
    }

    public function store(Request $request)
    {
        $courier = $request->input('courier');
        // dd($courier);
        if($courier){
            $data = [
                'origin' => $this->getCity($request->origin_city),
                'destination' => $this->getCity($request->destination_city),
                'weight' => 1300,
                'result' => []
            ];
            foreach ($courier as $row) {
                $ongkir = RajaOngkir::ongkosKirim([
                    'origin'        => $request->origin_city,     // ID kota/kabupaten asal
                    'destination'   => $request->destination_city,      // ID kota/kabupaten tujuan
                    'weight'        => 1300,    // berat barang dalam gram
                    'courier'       => $row    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
                ])->get();
                $data['result'][] = $ongkir;
        }
        // dd($data);
        return view('cost')->with($data);
    }
    return redirect()->back();
}
}
