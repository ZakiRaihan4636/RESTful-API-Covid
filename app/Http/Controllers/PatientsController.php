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
                'message' => "Get all Resource patients",
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
        $validateData = $request->validate([
            'name' => 'required',
            'phone' => 'numeric|required',
            'address' => 'required',
            'status' =>  'required',
            'in_date_at' => 'date|required',
            'out_date_at' => 'date|nullable'
        ]);

        # menggunakan Patient dengan eloquent create untuk insert data
        $patients = Patient::create($validateData);

        $data = [
            'message' => 'Resource is added successfully',
            'data' => $patients
        ];

        # mengembalikan data (json) status code 201
        return response()->json($data, 201);
    }

    # mendapatkan detail resource Patients
    # membuat method show 
    public function show($id)
    {
        # mencari data patient berdasarkan id
        $patients = Patient::find($id);

        if ($patients) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patients
            ];

            #mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            # mengembalikan data json status code 200
            return response()->json($data, 200);
        }
    }

    # mengupdate resource patient
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
                'message' => 'Resource is update successfully',
                'data' => $patients
            ];

            # mengirimkan respon json dengan statu code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            # mengembalikan data json status code 404
            return response()->json($data, 404);
        }
    }

    # mengupdate resource patient
    # membuat method update
    public function destroy($id)
    {
        # mencari data patient yang ingin di update
        $patients = Patient::find($id);

        if ($patients) {
            # menghapus data patient menggunakan eloquent delete
            $patients->delete();

            $data = [
                'message' => "Resource delete id $id is succsesfuly",
            ];

            # mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not Found',
            ];

            # mengembalikan data json status code 404
            return response()->json($data, 404);
        }
    }

    # untuk mendapatkan resource berdasarkan name
    # membuat method search 
    public function search($name)
    {
        # mencari data Patients berdasarkan name
        $patients = Patient::where('name', 'LIKE', "%$name%")->get();

        if (count($patients) > 0) {
            $data = [
                'message' => 'Get Detail Searched Resource',
                'data' => $patients
            ];

            #mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found ',
            ];

            # mengembalikan data json status code 200
            return response()->json($data, 200);
        }
    }

    # untuk medapatkan resource berdasarkan status
    # membuat method searchByStatus
    public function searchByStatus($status)
    {

        # mencari patient berdasarkan status
        $patients = Patient::where('status', 'LIKE', "%$status%")->get();

        if ($patients) {
            $data = [
                'message' => "Resource detail status $status",
                'total' => count($patients),
                'data' => $patients
            ];

            #mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found",
            ];

            #mengemablikan data json status code 200
            return response()->json($data, 200);
        }
    }
}
