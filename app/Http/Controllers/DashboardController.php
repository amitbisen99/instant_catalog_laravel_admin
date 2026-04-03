<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        $users = User::latest()->get();
        $data['recent_users'] = $users;
        $data['total_users'] = count($users);
        $data['subscription'] = Subscription::select('amount')->latest()->first();
        $data['total_user_plan'] = UserPlan::count();
        $data['total_trial'] = UserPlan::leftJoin('plans', function($join) {
                                    $join->on('user_plans.plan_id', '=', 'plans.id');
                                })
                                ->where('plan_name', 'Trial')
                                ->count();

        return view('home')->with($data);
    }

    public function Users(Request $request) {
        if ($request->ajax()) {
            $post = User::select('users.id', 'users.full_name', 'users.email', 'users.mobile_number', 'user_devices.device_type', 'industry_types.title as industry_type', 'business_types.title as business_type', 'users.status')
                    ->leftJoin('user_devices', 'users.id', '=', 'user_devices.user_id')
                    ->leftJoin('industry_types', 'users.industry_type_id', '=', 'industry_types.id')
                    ->leftJoin('business_types', 'users.business_type_id', '=', 'business_types.id');

            if (!empty($request->status) && in_array($request->status, ['active', 'inactive'])) {
                $post->where('users.status', $request->status);
            }

            $post = $post->groupBy('users.id')->get();

            return DataTables::of($post)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-status="'.($row->status == 'active' ? 'inactive' : 'active').'" class="edit btn btn-'.($row->status == 'active' ? 'warning' : 'success').' btn-sm editPost">'.($row->status == 'active' ? 'Inactive' : 'Active').'</a>';
                        
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        } else {
            return view('user');
        }
    }

    public function StatusChange(Request $request, $id) {
        $status = User::where('id', $id)->update(['status' => $request->status]);

        if ($status) {
            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }

    public function Delete($id) {
        $delete = User::where('id', $id)->update(['status' => 'inactive']);

        if ($delete) {
            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }
}
