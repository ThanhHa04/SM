@extends('layout.base')
@section('page_title', $subject->name ) 
@section('slot')
<div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
            <p class="ps-2" class="text-s"><strong>Danh sách giảng viên:</strong></p>
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Mã</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Giảng viên</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Ngày tham gia</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teacher_subject_list as $teacher)
                    <tr>
                        <td class="text-xs">{{ $teacher->teacherProfile?->teacher_id }}</td>
                        <td class="text-xs">{{ $teacher->teacherProfile?->user?->name }}</td>
                        <td class="text-xs">{{ $teacher->created_at }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Chưa có thông tin</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-responsive p-0">
            <p class="ps-2 mt-3 " class="text-s"><strong>Danh sách lớp:</strong></p>
                    <table class="table align-items-center mb-0">
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
