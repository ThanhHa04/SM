@extends('layout.base')
@section('page_title', 'Danh sách sinh viên')
@section('slot')
<div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Mã số sinh viên</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Họ và tên</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Email</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Ngày sinh</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Giới tính</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Số điện thoại</th>
                        <th class="text-secondary opacity-7"></th>
                    </tr>
                </thead>
                <tbody> 
                    @forelse($rows as $row)
                    <tr>
                        <td class="text-xs">{{$row->student_id}}</td>
                        <td class="text-xs">{{$row->user->name}}</td>
                        <td class="text-xs">{{$row->user->email}}</td>
                        <td class="text-xs">{{date('d/m/Y', strtotime($row->dob))}}</td>
                        <td class="text-xs">{{$row->gender}}</td>
                        <td class="text-xs">{{$row->phone_number}}</td>
                        <td class="align-middle">
                            <a class="text-secondary font-weight-bold text-xs"
                                href="{{ route('students.show-classroom', ['id' => $row->id]) }}">Xem</a> |
                            <a class="text-secondary font-weight-bold text-xs"
                                href="{{route('students.edit', ['id' => $row->user->id])}}">Sửa</a> | 
                            <a class="text-secondary font-weight-bold text-xs"
                                href="{{route('students.delete', ['id' => $row->user->id])}}">Xóa</a>
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