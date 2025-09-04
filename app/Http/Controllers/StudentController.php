<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // Middleware aplicado nas rotas em web.php

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roll' => 'required|integer|unique:student_info,roll',
            'class' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'pcontact' => 'required|string|max:30',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'roll', 'class', 'city', 'pcontact']);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = $request->roll . '-' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/students', $filename);
            $data['photo'] = $filename;
        }

        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'Estudante adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roll' => 'required|integer|unique:student_info,roll,' . $student->id,
            'class' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'pcontact' => 'required|string|max:30',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'roll', 'class', 'city', 'pcontact']);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo) {
                Storage::delete('public/students/' . $student->photo);
            }
            
            $photo = $request->file('photo');
            $filename = $request->roll . '-' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/students', $filename);
            $data['photo'] = $filename;
        }

        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'Estudante atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Delete photo if exists
        if ($student->photo) {
            Storage::delete('public/students/' . $student->photo);
        }
        
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Estudante excluído com sucesso!');
    }
}
