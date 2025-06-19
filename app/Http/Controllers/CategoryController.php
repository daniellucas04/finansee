<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.category', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|int',
            'name' => 'required|string',
            'type' => 'required|string'
        ]);

        $category = new Category();
        if ($category->insert([...$validated, 'created_at' => now(), 'updated_at' => now()])) {
            Swal::toastSuccess([
                'title' => 'Success',
                'text' => 'Category has been created',
                'timer' => 2000,
                'position' => 'top-end',
                'showConfirmButton' => false,
            ]);
            return redirect()->back();
        }

        Swal::toastError([
            'title' => 'Error',
            'text' => 'Unable to create the category',
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
        $validated = $request->validate([
            'user_id' => 'required|int',
            'name' => 'required|string',
            'type' => 'required|string'
        ]);

        $category = new Category();
        $category = $category->find($id);
        if ($category->update([...$validated, 'updated_at' => now()])) {
            Swal::toastSuccess([
                'title' => 'Success',
                'text' => 'Category has been updated',
                'timer' => 2000,
                'position' => 'top-end',
                'showConfirmButton' => false,
            ]);
            return redirect()->back();
        }

        Swal::toastError([
            'title' => 'Error',
            'text' => 'Unable to udpate the category',
            'timer' => 2000,
            'position' => 'top-end',
            'showConfirmButton' => false,
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Category::destroy($id)) {
            Swal::toastSuccess([
                'title' => 'Success',
                'text' => 'Category has been deleted',
                'timer' => 2000,
                'position' => 'top-end',
                'showConfirmButton' => false,
            ]);
            return redirect()->back();
        }
        
        Swal::toastError([
            'title' => 'Error',
            'text' => 'Unable to delete the category',
            'timer' => 2000,
            'position' => 'top-end',
            'showConfirmButton' => false,
        ]);
        return redirect()->back();
    }
}
