<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employees;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Employees::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'employee_name' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'employee_NIC' => 'required|string|min:10|max:15|unique:employees',
            'employee_contact_number' => 'required|string|regex:/(0)[0-9]{9}/',
        ]);

        return Employees::create([
            'employee_name' => $request['employee_name'],
            'address' => $request['address'],
            'employee_NIC' => $request['employee_NIC'],
            'employee_contact_number' => $request['employee_contact_number']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $employee = Employees::findorFail($id);

        $this->validate($request,[
            'employee_name' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'employee_NIC' => 'required|string|min:10|max:15|unique:employees,employee_NIC,'.$employee->employee_id.',employee_id',
            'employee_contact_number' => 'required|string|regex:/(0)[0-9]{9}/',
        ]);


        $employee->update($request->all());
        return ["mesasge"=>$employee];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $employee = Employees::findorFail($id);

        $employee->delete();

        return ['message'=>'Employee is deleted'];
    }
}
