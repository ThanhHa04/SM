@extends('layout.base')
@section('page_title', isset($rec) ? 'Cập nhật sinh viên: '.$rec->user->name : 'Thêm sinh viên')
@section('slot')
<form id="form" class="text-start" method="POST"
    action="{{isset($rec) ? route('students.update', ['id' => $rec->id]) : route('students.create')}}">
    {{ csrf_field() }}
    <label class="form-label mt-3">Mã số sinh viên *</label>
    <div class="input-group input-group-outline">
        <input type="text" name="student_id" class="form-control" required value="{{ old('student_id', $rec->student_id ?? ($student_id ?? '')) }}" readonly>
    </div>

    <label class="form-label mt-3">Họ và tên *</label>
        <div class="input-group input-group-outline">
            <input type="text" name="name" class="form-control" required value="{{$rec->user->name ?? old('name') ?? ''}}">
        </div>
    <label class="form-label mt-3">Ngày sinh *</label>
    <div class="input-group input-group-outline">
        <input type="date" name="dob" class="form-control" required value="{{date('Y-m-d', strtotime($rec->dob ?? old('dob') ?? ''))}}">
    </div>

    <label class="form-label mt-3">Email *</label>
    <div class="input-group input-group-outline">
        <input type="email" name="email" class="form-control" required value="{{$rec->user->email ?? old('email') ?? ''}}">
    </div>

    <label class="form-label mt-3">SDT*</label>
    <div class="input-group input-group-outline">
        <input type="text" name="phone_number" class="form-control" required value="{{ old('phone_number', $rec->phone_number ?? '') }}">
    </div>

    <label class="form-label mt-3">Giới tính *</label>
    <div class="input-group input-group-outline">
        <select name="gender" class="form-control" required>
            <option value="">-- Chọn giới tính --</option>
            <option value="Nam" {{ old('gender', $rec->gender ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
            <option value="Nữ" {{ old('gender', $rec->gender ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
        </select>
    </div>

    <label class="form-label mt-3">Mật khẩu {{isset($rec) ? '' : '*'}}</label>
    <div class="input-group input-group-outline">
        <input type="password" name="password" class="form-control input-outline" {{isset($rec) ? '' : 'required'}}>
    </div>

    <input type="submit" class="btn bg-gradient-primary my-4 mb-2" value="{{ isset($rec) ? 'Cập nhật' : 'Thêm'}}">
</form>
@stop