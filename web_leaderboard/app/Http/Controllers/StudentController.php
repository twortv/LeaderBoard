<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StudentController extends Controller
{
    public function index()
    {
        $response = Http::get('http://127.0.0.1:5001/api/students');
        $students = $response->successful() ? $response->json() : [];
        return view('students.index', compact('students'));
    }

    public function update(Request $request, $id)
    {
        $response = Http::put("http://127.0.0.1:5001/api/students/{$id}", [
            'score' => $request->score
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Điểm đã được cập nhật thành công!');
        } else {
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật điểm.');
        }
    }
}