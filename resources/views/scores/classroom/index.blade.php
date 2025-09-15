@extends('layout.base')
@section('page_title', 'Điểm của lớp: '.$rec->name)
@section('page_action')
    <div class="text-center">
        <a href="{{ route('scores.edit', $rec->id) }}" class="btn btn-primary">Sửa</a>
    </div>
@endsection
@section('slot')
<div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã số sinh viên</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Họ và tên</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Điểm thành phần 1</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Điểm thành phần 2</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Điểm quá trình</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Điểm cuối kì</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tổng kết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    @php
                        $score = $student->scores->first();
                    @endphp
                    <tr>
                        <td class="text-xs">{{$student->student_id}}</td>
                        <td class="text-xs">{{$student->name}}</td>
                        <td class="text-xs">{{$score->tp1 ?? ''}}</td>
                        <td class="text-xs">{{$score->tp2 ?? ''}}</td>
                        <td class="text-xs">{{$score->qt ?? ''}}</td>
                        <td class="text-xs">{{$score->ck ?? ''}}</td>
                        <td class="text-xs">{{$score->tk ?? ''}}</td>
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