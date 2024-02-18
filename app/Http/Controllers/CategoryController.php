<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id')->paginate(5);
        return view('categories.index', $categories)
            ->with('categories', $categories);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function toggleActive($category)
    {
        $category = Category::find($category);

        if (!$category) {
            flash('Category not found')->error();
            return redirect()->route('categories.index');
        }

        $category->is_deleted = !$category->is_deleted;
        $category->save();

        return redirect()->route('categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|string|max:255|min:3'
        ], $this->messages());

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index');
    }
    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            flash('Categoría no encontrada')->error();
            return redirect()->route('categories.index');
        }

        return view('categories.update')
            ->with('category', $category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|string|max:255|min:3'
        ], $this->messages());

        $category = Category::find($id);
        if (!$category) {
            flash('Categoría no encontrada')->error();
            return redirect()->route('categories.index');
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            flash('Categoría no encontrada')->error();
            return redirect()->route('categories.index');
        }

        if ($category->funkos->count() > 0) {
            flash('No se puede eliminar la categoría porque tiene funkos asociados')->error();
            return redirect()->route('categories.index');
        }

        $category->delete();

        return redirect()->route('categories.index');
    }


    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'La categoría ya existe',
            'name.string' => 'El nombre debe ser un texto',
            'name.max' => 'El nombre no puede tener más de 255 caracteres',
            'name.min' => 'El nombre no puede tener menos de 3 caracteres'
        ];
    }
}
