<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Funko;
use Illuminate\Http\Request;
use Storage;

class FunkoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $funkos = Funko::search($search)->orderBy('id')->paginate(4);
        return view('funkos.index')
            ->with('funkos', $funkos);
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('funkos.create')
            ->with('categories', $categories);
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|min:3|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ], $this->messages());

        if (!$valid) {
            return redirect()->back(400)
                ->withErrors($valid)
                ->withInput();
        }

        $funko = new Funko($request->all());

        $funko->save();

        return redirect()->route('funkos.index');
    }

    public function show($id)
    {
        $funko = Funko::find($id);
        if (!$funko) {
            flash()->error('Funko no encontrado');
            return redirect()->route('funkos.index');
        }

        return view('funkos.show')
            ->with('funko', $funko);
    }

    public function edit($id)
    {
        $funko = Funko::find($id);
        if (!$funko) {
            flash()->error('Funko no encontrado');
            return redirect()->route('funkos.index');
        }

        $categories = Category::active()->get();
        return view('funkos.update')
            ->with('funko', $funko)
            ->with('categories', $categories);
    }

    public function update(Request $request, $id)
    {
        $valid = $request->validate([
            'name' => 'required|min:3|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ], $this->messages());

        if (!$valid) {
            return redirect()->back(400)
                ->withErrors($valid)
                ->withInput();
        }

        $funko = Funko::find($id);
        if (!$funko) {
            flash()->error('Funko no encontrado');
            return redirect()->route('funkos.index');
        }

        $funko->fill($request->all());
        $funko->save();

        return redirect()->route('funkos.index');
    }

    public function destroy($id)
    {
        $funko = Funko::find($id);
        if (!$funko) {
            flash()->error('Funko no encontrado');
            return redirect()->route('funkos.index');
        }

        if ($funko->image !== Funko::DEFAULT_IMAGE) {
            $path = public_path('storage/funkos/' . $funko->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $funko->delete();

        return redirect()->route('funkos.index');
    }

    public function showUpdateImage($id)
    {
        $funko = Funko::find($id);
        if (!$funko) {
            flash()->error('Funko no encontrado');
            return redirect()->route('funkos.index');
        }

        return view('funkos.update-image')
            ->with('funko', $funko);
    }


    public function doUpdateImage(Request $request, $id)
    {
        $valid = $request->validate([
            'image' => 'required|image|mimes:jpg,png'
        ]);

        if (!$valid) {
            return redirect()->back(400)
                ->withErrors($valid)
                ->withInput();
        }

        $funko = Funko::find($id);

        if (!$funko) {
            flash()->error('Funko no encontrado');
            return redirect()->route('funkos.index');
        }

        $file = $request->file('image');
        $extension = $file->extension();
        Storage::disk('public')->put('funkos/' . $funko->id . '.' . $extension, file_get_contents($file));

        $funko->image = $funko->id . '.' . $extension;

        $funko->save();

        return redirect()->route('funkos.index');
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'name.max' => 'El nombre no puede tener más de 255 caracteres',
            'price.required' => 'El precio es obligatorio',
            'price.numeric' => 'El precio debe ser un número',
            'stock.required' => 'El stock es obligatorio',
            'stock.numeric' => 'El stock debe ser un número',
            'category_id.required' => 'La categoría es obligatoria',
            'category_id.exists' => 'La categoría no existe'
        ];
    }
}
