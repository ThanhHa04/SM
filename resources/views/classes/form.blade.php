@extends('layout.base')
@section('page_title', isset($rec) ? 'Cập nhật lớp: '.$rec->name : 'Thêm lớp')
@section('slot')

<form id="form" class="text-start" method="POST"
    action="{{ isset($rec) ? route('classes.update', ['id' => $rec->id]) : route('classes.create') }}">
    {{ csrf_field() }}
    
    <div class="row mt-4">
        <div class="col-md-6">
            {{-- Chọn môn --}}
            <label class="form-label mt-3">Môn *</label>
            <div class="input-group input-group-outline">
                <select name="subject_id" id="subject_id" class="form-control" required
                {{ isset($rec) ? 'disabled' : '' }} >
                    <option value="">-- Chọn môn học --</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ (isset($rec) && $rec->subject_id == $subject->id) || old('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tên lớp --}}
            <label class="form-label mt-3">Tên lớp *</label>
            <div class="input-group input-group-outline">
                <input type="text" name="name" class="form-control" required
                    value="{{ $rec->name ?? old('name') ?? '' }}">
            </div>

            {{-- Danh sách giáo viên --}}
            <div class="form-group mt-3">   
                <label class="form-label">Giảng viên *</label>
                <div class="overflow-auto" id="teacher_list" style="max-height: 50vh;"></div>
            </div>
        </div>

        {{-- Danh sách sinh viên --}}
        <div class="col-md-6">
            <label class="form-label">Sinh viên *</label>
            <div class="mb-2 d-flex">
                <input type="text" id="studentSearch" class="form-control me-2" placeholder="Tìm sinh viên...">
            </div>

            <div class="overflow-auto" id="student_list" style="max-height: 70vh;">
                @foreach($students as $student)
                    @php
                        $check = false;
                        if(isset($student_list))
                            foreach($student_list as $index => $roww) {
                                if($roww->student_profile_id == $student->id) {
                                    $check = true;
                                    unset($student_list[$index]);
                                    break;
                                }
                            }
                    @endphp
                    <div class="form-check student-item">
                        <input class="form-check-input" type="checkbox" name="student_profile_id[]"
                            value="{{ $student->id }}" {{ $check ? 'checked' : '' }}>
                        <label class="custom-control-label">{{ $student->student_id }} - {{ $student->name }} </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <input type="submit" class="btn bg-gradient-primary my-4 mb-2"
        value="{{ isset($rec) ? 'Cập nhật' : 'Thêm'}}">
</form>

{{-- JS AJAX load giáo viên --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subjectSelect = document.getElementById('subject_id');
    const teacherListDiv = document.getElementById('teacher_list');

    function loadTeachers(subjectId, selectedTeacherId = null) {
        if(!subjectId) {
            teacherListDiv.innerHTML = '';
            return;
        }
        
        fetch(`/SM/subjects/${subjectId}/teachers`)
            .then(res => res.json())
            .then(teachers => {
                if(teachers.length === 0) {
                    teacherListDiv.innerHTML = '<p class="text-muted">Chưa có giảng viên đảm nhiệm môn này.</p>';
                    return;
                } else {
                    teacherListDiv.innerHTML = '';
                
                }
                teachers.forEach(teacher => {
                    const div = document.createElement('div');
                    div.classList.add('form-check');

                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.name = 'teacher_profile_id';
                    input.value = teacher.id;
                    input.id = 'teacher_' + teacher.id;
                    input.classList.add('form-check-input');

                    if(selectedTeacherId && selectedTeacherId == teacher.id) {
                        input.checked = true;
                    }

                    const label = document.createElement('label');
                    label.setAttribute('for', 'teacher_' + teacher.id);
                    label.classList.add('form-control-label');
                    label.textContent = teacher.name;

                    div.appendChild(input);
                    div.appendChild(label);
                    teacherListDiv.appendChild(div);

                });
            })
            .catch(err => console.error(err));
    }

    // Khi chọn môn
    subjectSelect.addEventListener('change', function() {
        loadTeachers(this.value);
    });

    // Load sẵn giáo viên đã chọn
    @if(isset($rec))
        loadTeachers({{ $rec->subject_id }}, {{ $rec->teacher_profile_id ?? 'null' }});
    @endif

    const searchInput = document.getElementById('studentSearch');
    const studentItems = document.querySelectorAll('#student_list .student-item');

    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        studentItems.forEach(item => {
            const label = item.querySelector('label').textContent.toLowerCase();
            if(label.includes(filter)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

@stop
