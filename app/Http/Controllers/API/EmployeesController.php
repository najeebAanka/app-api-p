<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class EmployeesController extends \App\Http\Controllers\Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) { // get all categories .. 
        //
        $lang = $this->getLangCode();
        $data = \App\Models\Employee::select(['employees.id', 'employees.name', 'employees.details', 'employees.profile_pic']);
        if ($request->has('category')) {
            $data = $data->join('category_employees', 'category_employees.emp_id', 'employees.id')
                    ->where('category_employees.cat_id', $request->category);
        }

        $data = $data->take(50)->get();

        foreach ($data as $emp) {
            $emp->profile_pic = $emp->buildIcon();
        }


        return $this->formResponse("ok", $data, Response::HTTP_OK);
    }

    public function getAccordingToSlots(Request $request, $day, $time , $category) {
        //
        $list = []; // 

        $all = DB::select("SELECT category_employees.emp_id as "
                        . "id from category_employees join employee_times on"
                        . " employee_times.link_Id=category_employees.id WHERE "
                        . "employee_times.day_of_week = :day "
                        . "and employee_times.slot_from <= :time1 "
                        . "and employee_times.slot_to >= :time2 and category_employees.cat_id=:cat "
                        . "group by category_employees.emp_id  ", ['day' => $day, 'time2' => $time, 'time1' => $time ,'cat'=>$category]);

        foreach ($all as $a) {
            $list[] = $a->id;
        }

        $lang = $this->getLangCode();
        $data = \App\Models\Employee::select(['employees.id', 'employees.name', 'employees.details', 'employees.profile_pic'])
                ->whereIn('employees.id', $list);
        $data = $data->take(50)->get();
        foreach ($data as $emp) {
            $emp->profile_pic = $emp->buildIcon();
        }


        return $this->formResponse("ok", $data, Response::HTTP_OK);
    }

}
