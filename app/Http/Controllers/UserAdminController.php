<?php

namespace App\Http\Controllers;

use App\Admin;
use App\BranchAddress;
use App\BranchEmail;
use App\BranchProvider;
use App\BranchSupplier;
use App\Branch;
use App\Provider;
use App\BranchType;
use Illuminate\Http\Request;
use App\User;

class UserAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('branchType')->get();

        return view('users.index', compact('users'));
    }

    public function editAdmin(Request $request)
    {
        $admin = \Auth::user();
        $admin->name =  $request->get('name');
        $admin->username = $request->get('username');
        $admin->email = $request->get('email');
        if ($request->get('password') !=''){
            $admin->password = bcrypt($request->get('password'));
        }
        $admin->save();
        return redirect('/users')->with('success', 'You changed you profile.');
    }

    public function editAdminForm()
    {
        $admin = \Auth::user();
//        dd($admin);
        return view('admin.edit', compact('admin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        return response()->json($request);
        $request->validate([
            'branch_type'=>'required',
            'branch_name'=>'required',
            'user_email'=>'required|unique:tb_user',
            'password'=>'required'
        ]);


        $user = new User([
            'branch_type_id' =>(int) $request->get('branch_type'),
            'branch_name' => $request->get('branch_name'),
            'user_email' => $request->get('user_email'),
            'activated' => true,
            'password' => bcrypt($request->get('password')),
        ]);
        $user->save();
        
        $branch = new Branch;
        $branch->branch_type_id = (int) $request->get('branch_type');
		$branch->save();
		$user->branch_id = $branch->branch_id;
        $user->save();
        
        \DB::select("CALL sp_branch_create_parameters({$branch->branch_id})");
        BranchProvider::where('branch_id', $branch->branch_id)->update(['status' => 'Inactive']);
        BranchSupplier::where('branch_id', $branch->branch_id)->update(['status' => 'Inactive']);

        
        
        \Mail::send('emails.registerUser', ['password' => $request->get('password'), 'firstName' =>$user->first_name  , 'lastName' => $user->last_name],
            function ($message) use ($user) {

                $message->to($user->email);
                $message->from('psof@psof.com');
                $message->subject('Registration');

            });
        return redirect('/users')->with('success', 'User saved! Email sent!');
    }

    protected function randomPassword ()
    {
        $length = 8;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);

    }

    public function deactivateUser(Request $request, $id) {

        $user = User::find($id);
        if ($user->activated == true){
            $user->activated = false;
            $user->save();
            $info = "User deactivated!";
        } else {
            $user->activated = true;
            $user->save();
            $info = "User activated!";
        }

        return redirect('/users')->with('success', $info);
    }

    public function create()
    {
        $password = $this->randomPassword();

        $branch_types = BranchType::all();

//        dd($branchTypes);

        return view('users.create', ['password' => $password, 'branch_types' => $branch_types]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id)->with('branch')->first();
        $addresses = BranchAddress::where('branch_id', $user->branch_id)->get();
        $emails = BranchEmail::where('branch_id', $user->branch_id)->get();
        $providersArr = [];
        $branchProviders = BranchProvider::where('branch_id', $user->branch_id)->with('provider')->get();

        foreach ($branchProviders as $branchProvider){
            $provider = Provider::where('provider_id', $branchProvider->provider_id)->first();
            array_push($providersArr, $provider);
        }

        return view('users.show', ['user'=>$user, 'addresses' =>$addresses, 'emails' =>$emails, 'providersArr' =>$branchProviders]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $branch_types = BranchType::all();
        return view('users.edit', compact('user', 'branch_types'));
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
        $request->validate([
            'branch_type'=>'required',
            'branch_name'=>'required',
            'user_email'=>'required'
        ]);

        $user = User::find($id);
        $user->branch_type_id =  $request->get('branch_type');
        $user->branch_name = $request->get('branch_name');
        $user->user_email = $request->get('user_email');
        $user->save();

        return redirect('/users')->with('success', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/users')->with('success', 'User deleted!');
    }
}
