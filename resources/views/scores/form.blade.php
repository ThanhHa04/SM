@extends('layout.base')
@section('page_title', 'Nhập điểm lớp: '.$class->name)
@section('slot')
<form id="form" class="text-start" method="POST" action="{{ route('scores.update', $class->id) }}">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã môn</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên môn</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Điểm thành phần 1</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Điểm thành phần 2</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Điểm quá trình</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Điểm cuối kì</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tổng kết</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($class->students as $row)
                        @php
                            $score = $row->scores->first();
                        @endphp
                        <tr>
                            <td class="text-xs">{{$row->student_id}}</td>
                            <td class="text-xs">{{$row->name}}</td>
                            <td>
                                <input type="number" name="scores[{{ $row->id }}][tp1]"
                                    value="{{ $score->tp1 ?? '' }}"
                                    class="form-control form-control-sm border border-1 border-gray">
                            </td>
                            <td>
                                <input type="number" name="scores[{{ $row->id }}][tp2]"
                                    value="{{ $score->tp2 ?? '' }}"
                                    class="form-control form-control-sm border border-1 border-gray">
                            </td>
                            <td>
                                <input type="number" name="scores[{{ $row->id }}][qt]"
                                    value="{{ $score->qt ?? '' }}"
                                    class="form-control form-control-sm border border-1 border-gray">
                            </td>
                            <td>
                                <input type="number" name="scores[{{ $row->id }}][ck]"
                                    value="{{ $score->ck ?? '' }}"
                                    class="form-control form-control-sm border border-1 border-gray">
                            </td>
                            <td>
                                <input type="number" name="scores[{{ $row->id }}][tk]"
                                    value="{{ $score->tk ?? '' }}"
                                    class="form-control form-control-sm" readonly>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3 text-center">
                <button type="submit" class="btn btn-primary">Lưu điểm</button>
            </div>
        </div>
    </div>
</form>
@stop
