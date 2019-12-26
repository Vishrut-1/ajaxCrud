<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Service::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editService">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteService">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('serviceAjax',compact('services'));

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        Service::UpdateorCreate(['id' => $request->service_id],
            ['name' => $request->name, 'email' => $request->email]);

        return response()->json(['success'=>'Service Saved successfully.']);
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $service = Service::find($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        Service::find($id)->delete();

        return response()->json(['success'=>'Service deleted successfully.']);
    }
}
