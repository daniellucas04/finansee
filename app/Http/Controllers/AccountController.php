<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all();

        return view('accounts.account', ['accounts' => $accounts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'balance' => str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $request->balance)
        ]);

        $validated = $request->validate([
            'user_id' => 'required|int',
            'name' => 'required|string',
            'balance' => 'required|numeric|min:0'
        ]);

        $account = new Account();
        if ($account->insert([...$validated, 'created_at' => now(), 'updated_at' => now()])) {
            Swal::toastSuccess([
                'title' => 'Success',
                'text' => 'Account has been created',
                'timer' => 2000,
                'position' => 'top-end',
                'showConfirmButton' => false,
            ]);
            return redirect()->back();
        }

        Swal::toastError([
            'title' => 'Error',
            'text' => 'Unable to create the account',
            'timer' => 2000,
            'position' => 'top-end',
            'showConfirmButton' => false,
        ]);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Account::destroy($id)) {
            Swal::toastSuccess([
                'title' => 'Success',
                'text' => 'Account has been deleted',
                'timer' => 2000,
                'position' => 'top-end',
                'showConfirmButton' => false,
            ]);
            return redirect()->back();
        }
        
        Swal::toastError([
            'title' => 'Error',
            'text' => 'Unable to delete the account',
            'timer' => 2000,
            'position' => 'top-end',
            'showConfirmButton' => false,
        ]);
        return redirect()->back();
    }
}
