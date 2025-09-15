@extends('layout.base')

@section('page_title', 'Sinh viên: ' .$student->name)

@section('slot')
<div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-xs ps-2">Tên lớp</th>
                        <th class="text-xs ps-2">Thành phần 1</th>
                        <th class="text-xs ps-2">Thành phần 2</th>
                        <th class="text-xs ps-2">Quá trình</th>
                        <th class="text-xs ps-2">Cuối kỳ</th>
                        <th class="text-xs ps-2">Tổng kết</th>
                        <th class="text-xs ps-2">Ngày tham gia</th>
                        <th class="text-xs ps-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                    <tr>
                        <td class="text-xs">{{ $class->name }}</td>
                        <td class="text-xs">{{ $scores[$class->id]->tp1 ?? '-' }}</td>
                        <td class="text-xs">{{ $scores[$class->id]->tp2 ?? '-' }}</td>
                        <td class="text-xs">{{ $scores[$class->id]->qt ?? '-' }}</td>
                        <td class="text-xs">{{ $scores[$class->id]->ck ?? '-' }}</td>
                        <td class="text-xs">{{ $scores[$class->id]->tk ?? '-' }}</td>
                        <td class="text-xs">{{ $class->created_at }}</td>
                        <td class="align-middle">
                            <a class="text-secondary font-weight-bold text-xs"
                                href="{{route('classes.view', ['id' => $class->id])}}">Xem</a> 
                        @if(in_array(auth()->user()->role, ['teacher'])) 
                            | <a class="text-secondary font-weight-bold text-xs"
                                href="{{route('classes.delete', ['id' => $class->id])}}">Xóa</a>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Sinh viên chưa tham gia lớp học nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<a href="{{ route('students') }}" class="btn btn-sm btn-secondary mt-3" >←</a>
@endsection
