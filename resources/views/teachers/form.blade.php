@extends('layout.base')
@section('page_title', isset($rec) ? 'Cập nhật giáo viên: '.$rec->name : 'Thêm giáo viên')
@section('slot')
<form id="form" class="text-start" method="POST"
    action="{{isset($rec) ? route('teachers.update', ['id' => $rec->id]) : route('teachers.create')}}">
    {{ csrf_field() }}
    <label class="form-label mt-3">Mã Giảng Viên *</label>
    <div class="input-group input-group-outline">
        <input type="text" name="teacher_id" class="form-control opacity-10" required
            value="{{ old('teacher_id', $rec->profile->teacher_id ?? ($teacher_id ?? '')) }}" readonly>    
    </div>
    
    <label class="form-label mt-3">Họ và tên *</label>
    <div class="input-group input-group-outline">
        <input type="text" name="name" class="form-control" required value="{{$rec->name ?? old('name') ?? ''}}">
    </div>

   <label class="form-label mt-3">Số điện thoại *</label>
   <div class="input-group input-group-outline">
      <input type="tel" name="phone_number" class="form-control" placeholder="Nhập số"
        required pattern="[0-9]{10,11}"
        value="{{ old('phone_number', $rec->profile->phone_number ?? '') }}">
   </div>
   
    <label class="form-label mt-3">Email *</label>
    <div class="input-group input-group-outline">
        <input type="email" name="email" class="form-control" required value="{{$rec->email ?? old('email') ?? ''}}">
    </div>

    <label class="form-label mt-3">Ngày sinh *</label>
    <div class="input-group input-group-outline">
        <input type="date" name="dob" class="form-control" required value="{{date('Y-m-d', strtotime($rec->profile->dob ?? old('dob') ?? ''))}}">
    </div>

    <label class="form-label mt-3">Giới tính *</label>
    <div class="input-group input-group-outline">
        <select name="gender" class="form-control" required>
            <option value="">-- Chọn giới tính --</option>
            <option value="Nam" {{ old('gender', $rec->profile->gender ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
            <option value="Nữ" {{ old('gender', $rec->profile->gender ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
        </select>
    </div>
    
    <label class="form-label mt-3">Mật khẩu {{isset($rec) ? '' : '*'}}</label>
    <div class="input-group input-group-outline">
        <input type="password" name="password" class="form-control input-outline" {{isset($rec) ? '' : 'required'}}>
    </div>
    <input type="submit" class="btn bg-gradient-primary my-4 mb-2" value="{{ isset($rec) ? 'Cập nhật' : 'Thêm'}}">
</form>
@stop