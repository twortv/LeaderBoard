@extends('layouts.app')

@section('content')
<h1>Danh sách sinh viên</h1>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>MSSV</th>
            <th>Điểm</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student['id'] }}</td>
                <td>{{ $student['name'] }}</td>
                <td>{{ $student['student_id'] }}</td>
                <td>{{ $student['score'] ?? 'Chưa có điểm' }}</td>
                <td>
                    <form action="{{ route('students.update', $student['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="number" name="score" step="0.1" min="0" max="10" value="{{ $student['score'] }}">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection