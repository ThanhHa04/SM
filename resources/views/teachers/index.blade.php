@extends('layout.base')
@section('page_title', 'Danh sách giáo viên')
@section('slot')
<div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã Giảng viên</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Họ và tên</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Số điện thoại</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giới tính</th>
                        <th class="text-secondary opacity-7"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $row)
                    <tr>
                        <td class="text-xs">{{$row->teacherProfile->teacher_id }}</td>
                        <td class="text-xs">{{$row->teacherProfile->name}}</td>
                        <td class="text-xs">{{$row->teacherProfile->phone_number}}</td>
                        <td class="text-xs">{{$row->teacherProfile->gender}}</td>
                        <td class="align-middle">
                            <a class="text-secondary font-weight-bold text-xs"
                                href="{{ route('teachers.show-info', ['teacher_id' => $row->teacherProfile->id]) }}">Xem</a> | 
                            <a class="text-secondary font-weight-bold text-xs"
                                href="{{route('teachers.edit', ['id' => $row->id])}}">Sửa</a> | 
                            <a class="text-secondary font-weight-bold text-xs"
                                href="{{route('teachers.delete', ['id' => $row->id])}}">Xóa</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td class="align-middle text-secondary font-weight-bold text-xs">Không có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop