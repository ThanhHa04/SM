@extends('layout.base')
@section('page_title','Giảng viên: ' .$teacherProfile->user->name ) 
@section('slot')
<div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
            <p class="mt-1 ps-2" class="text-s"><strong>Danh sách môn học:</strong></p>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Mã</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Môn</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Ngày tham gia</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teacherSubjects as $row)
                    <tr>
                        <td class="text-xs">{{ $row->subject?->code }}</td>
                        <td class="text-xs">{{ $row->subject?->name }}</td>
                        <td class="text-xs">{{ $row->created_at }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">Không có môn học</td></tr>
                    @endforelse
                </tbody>
            </table>
            
            <p class="mt-3 ps-2" class="text-s"><strong>Danh sách lớp:</strong></p>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">ID</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Tên lớp</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Ngày tổ chức</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classroom_list as $class)
                    <tr>
                        <td class="text-xs">{{ $class->id }}</td>
                        <td class="text-xs">{{ $class->name }}</td>
                        <td class="text-xs">{{ $class->created_at }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Chưa có thông tin</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    <a href="{{ route('subjects') }}" class="btn btn-sm btn-secondary mt-3" >←</a>
@endsection
