<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        # menggunakan model Patents untuk menselect data
        $patients = Patient::all();

        if ($patients) {
            $data = [
                'message' => "Get all resouce patients",
                'data' => $patients
            ];

            #mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data is empty',
            ];

            # mereturn pesan erorr dan kode 404
            return response()->json($data, 404);
        }
    }

    # menambahkan resource patients
    # membuat method store
    public function store(Request $request)
    {


        $input = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
            'in_date_at' => $request->in_date_at,
            'out_date_at' => $request->out_date_at
        ];

        # menggunakan Patitent dengan eloquent create untuk insert data
        $patients = Patient::create($input);

        $data = [
            'message' => 'Patients is created successfully',
            'data' => $patients
        ];

        # mengembalikan data (json) status code 201
        return response()->json($data, 201);
    }

    # mendapatkan detail resource student
    # membuat method show 
    public function show($id)
    {
        # mencari data student berdasarkan id
        $patients = Patient::find($id);

        if ($patients) {
            $data = [
                'message' => 'Get detail patients',
                'data' => $patients
            ];

            #mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'data is empty',
            ];

            # mengembalikan data json status code 200
            return response()->json($data, 200);
        }
    }

    # mengupdate resource student
    # membuat method update
    public function update(Request $request, $id)
    {
        # mencari data patient yang ingin di update
        $patients = Patient::find($id);

        if ($patients) {
            # mendapatkan data request 
            $input = [
                'name' => $request->name ?? $patients->name,
                'phone' => $request->phone ?? $patients->phone,
                'address' => $request->address ?? $patients->address,
                'status' => $request->status ?? $patients->status,
                'in_date_at' => $request->in_date_at ?? $patients->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patients->out_date_at
            ];

            # mengupdate data
            $patients->update($input);

            $data = [
                'message' => 'Resource patients updated',
                'data' => $patients
            ];

            # mengirimkan respon json dengan statu code 200
            return response()->json($data, 200);
        }else{
            $data = [
                'message'=> 'Patients not found',
            ];

            # mengembalikan data json status code 404
            return response()->json($data, 404);
        }
    }

    # mengupdate resource patient
    # membuat method update
    public function destroy($id)
    {
        # mencari data student yang ingin di update
        $patients = Patient::find($id);

        if($patients){
            # menghapus data patient menggunakan eloquent delete
            $patients->delete();

            $data = [
                'message' => 'Patients is deleted',
            ];

            # mengembalikan data json status code 200
            return response()->json($data, 200);

        }else{
            $data = [
                'message' => 'Patient not found',
            ];

            # mengembalikan data json status code 404
            return response()->json($data, 404);
        }
    }
}
