<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentSubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\LoginController;

Route::middleware('auth')->namespace('App\Http\Controllers')->group(function () {
    Route::get('/', function () {
        if(auth()->user()->role == 'teacher')
            return redirect()->route('students');
        else return redirect()->route('scores.student', ['id' => auth()->user()->profile->id]);
    })->name('index');

    Route::get('/students', [StudentController::class,'index'])->name('students');
    Route::get('/students/create', [StudentController::class,'add'])->name('students.add');
    Route::post('/students/create', [StudentController::class,'create'])->name('students.create');
    Route::get('/students/update/{id}', [StudentController::class,'edit'])->name('students.edit');
    Route::post('/students/update/{id}', [StudentController::class,'update'])->name('students.update');
    Route::get('/students/delete/{id}', [StudentController::class, 'delete'])->name('students.delete');
    Route::get('/student/subjects/register', [StudentSubjectController::class, 'register'])->name('student.subjects');
    Route::get('/student/subjects', [StudentSubjectController::class, 'index'])->name('student.subjects');
    Route::post('/student/subjects', [StudentSubjectController::class, 'store'])->name('student.subjects.store');
    Route::get('/students/{id}/classes', [StudentController::class, 'showClassroom'])->name('students.show-classroom');


    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers');
    Route::get('/teachers/create', [TeacherController::class, 'add'])->name('teachers.add');
    Route::post('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create'); 
    Route::get('/teachers/update/{id}', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::post('/teachers/update/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::get('/teachers/delete/{id}', [TeacherController::class, 'delete'])->name('teachers.delete');
    Route::get('/teachers/{teacher_id}', [TeacherController::class, 'showInfo'])->name('teachers.show-info');

    Route::get('/classes', [ClassroomController::class,'index'])->name('classes');
    Route::get('/classes/create', [ClassroomController::class,'add'])->name('classes.add');
    Route::post('/classes/create', [ClassroomController::class,'create'])->name('classes.create');
    Route::get('/classes/update/{id}', [ClassroomController::class,'edit'])->name('classes.edit');
    Route::post('/classes/update/{id}', [ClassroomController::class,'update'])->name('classes.update');
    Route::get('/classes/delete/{id}', [ClassroomController::class,'delete'])->name('classes.delete');
    Route::get('/classes/{id}', [ClassroomController::class,'view'])->name('classes.view');

    Route::get('/subjects', [SubjectController::class,'index'])->name('subjects');
    Route::get('/subjects/create', [SubjectController::class,'add'])->name('subjects.add');
    Route::post('/subjects/create', [SubjectController::class,'create'])->name('subjects.create');
    Route::get('/subjects/update/{id}', [SubjectController::class,'edit'])->name('subjects.edit');
    Route::post('/subjects/update/{id}', [SubjectController::class,'update'])->name('subjects.update');
    Route::get('/subjects/delete/{id}', [SubjectController::class,'delete'])->name('subjects.delete');
    Route::get('/subjects/{id}/show', [SubjectController::class,'showSubject'])->name('subjects.show-subject');

    Route::get('/scores/create', [ScoreController::class,'add'])->name('scores.add');
    Route::post('/scores/create', [ScoreController::class,'create'])->name('scores.create');
    Route::get('/scores/update/{id}', [ScoreController::class,'edit'])->name('scores.edit');
    Route::post('/scores/update/{id}', [ScoreController::class,'update'])->name('scores.update');
    Route::get('/scores/delete/{id}', [ScoreController::class,'delete'])->name('scores.delete');
    Route::get('/scores/subjects', [ScoreController::class,'viewSubjects'])->name('scores.subjects');
    Route::get('/scores/subject/{id}', [ScoreController::class,'bySubject'])->name('scores.subject');
    Route::get('/scores/students', [ScoreController::class,'viewStudents'])->name('scores.students');
    Route::get('/scores/student/{id}', [ScoreController::class,'byStudent'])->name('scores.student');
    Route::get('/scores/student/{student_id}/class/{class_id}', [ScoreController::class,'thisSubjectStudent'])->name('scores.thisSubjectStudent');
    Route::get('/scores/semesters', [ScoreController::class,'viewSemesters'])->name('scores.semesters');
    Route::get('/scores/semester/{id}', [ScoreController::class,'bySemester'])->name('scores.semester');
    Route::get('/scores/classrooms', [ScoreController::class,'viewClassrooms'])->name('scores.classrooms');
    Route::get('/scores/classroom/{id}', [ScoreController::class,'byClassroom'])->name('scores.classroom');

    Route::get('/logout', [LoginController::class,'logout'])->name('logout');
});

Route::middleware('guest')->namespace('App\Http\Controllers')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class,'authenticate'])->name('login.post');
});
