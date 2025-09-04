@extends('layout.base')
@section('page_title', 'Danh sách sinh viên trong lớp: '.$classroom->name)
@section('slot')

<div class="card">
    <div class="card-body px-0 pb-2">
        <p class="text-uppercase text-secondary text-s font-weight-bolder ps-2">Giảng viên</p>
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Họ và tên</th>
                        <th class="text-secondary opacity-7"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-xs">{{ $classroom->teacher?->teacher_id ?? '' }}</td>
                        <td class="text-xs">{{ $classroom->teacher?->user?->name ?? 'Chưa có dữ liệu' }}</td>
                        @if(in_array(auth()->user()->role, ['teacher']))
                            @if($classroom->teacher_profile_id)
                            <td class="align-middle">
                                <a class="text-secondary font-weight-bold text-xs"
                                    href="{{ route('teachers.show-info', ['teacher_id' => $classroom->teacher_profile_id]) }}">Xem</a> | 
                                <a class="text-secondary font-weight-bold text-xs"
                                    href="{{ route('teachers.edit', ['id' => $classroom->teacher->user->id]) }}">Sửa</a> | 
                                <a class="text-secondary font-weight-bold text-xs"
                                    href="{{ route('teachers.delete', ['id' => $classroom->teacher_profile_id]) }}">Xóa</a>
                            </td>
                            @endif
                        @endif
                        </td>
                    </tbody>
            </table>
        </div>
        <div class="table-responsive p-0">
            <p class="text-uppercase text-secondary text-s font-weight-bolder ps-2 mt-3">Sinh viên</p>
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã số sinh viên</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Họ và tên</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ngày sinh</th>
                        <th class="text-secondary opacity-7"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classroom_students as $row)
                    <tr>
                        <td class="text-xs">{{$row->student->student_id}}</td>
                        <td class="text-xs">{{$row->student->user->name}}</td>
                        <td class="text-xs">{{date('d/m/Y', strtotime($row->student->dob))}}</td>
                        <td class="align-middle">
                            @if(in_array(auth()->user()->role, ['teacher']))
                            <a class="text-secondary font-weight-bold text-xs" 
                                href="{{route('scores.thisSubjectStudent', ['student_id' => $row->student->user->id, 'class_id' => $classroom->id])}}">Xem</a> | 
                            <a class="text-secondary font-weight-bold text-xs"
                                href="{{route('students.delete', ['id' => $row->student->user->id])}}">Xóa</a>
                            @endif
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