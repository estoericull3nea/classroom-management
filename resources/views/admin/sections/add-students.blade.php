@extends('admin.layout.app')

@section('content')
    <div class="container mt-3">
        <h1>Assign Students to Section: {{ $section->name }}</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.sections.storeStudents', $section->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="school_year">School Year</label>
                <input type="text" name="school_year" id="school_year" class="form-control"
                    value="{{ old('school_year', '2025-2026') }}" required>
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <select name="semester" id="semester" class="form-control" required>
                    <option value="First" {{ old('semester') == 'First' ? 'selected' : '' }}>First</option>
                    <option value="Second" {{ old('semester') == 'Second' ? 'selected' : '' }}>Second</option>
                    <option value="Summer" {{ old('semester') == 'Summer' ? 'selected' : '' }}>Summer</option>
                </select>
            </div>

            <div class="form-group">
                <label>Select Students:</label>

                <div class="mb-2">
                    <button type="button" class="btn btn-sm btn-info" id="selectAllToggle">Select All</button>
                </div>
                
                <div style="max-height: 400px; overflow-y: auto; border:1px solid #ccc; padding:10px;">
                  
                    <input type="text" id="studentSearch" class="form-control mb-2" placeholder="Search student by name or number...">
                  
                    @foreach($allStudents as $student)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="students[]" value="{{ $student->id }}"
                                id="student_{{ $student->id }}" {{ in_array($student->id, $assignedStudents) ? 'checked' : '' }}>
                            <label class="form-check-label" for="student_{{ $student->id }}">
                                {{ $student->name }} ({{ $student->student_number }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>


            <button type="submit" class="btn btn-primary"
             onclick="return confirm('Are you sure you want to update the assigned students for this section?')">
                    Update Students
                </button>

           

            <a href="{{ route('admin.assignments.index') }}" class="btn btn-default">Cancel</a>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('selectAllToggle');
        let isAllSelected = false;

        toggleBtn.addEventListener('click', function () {
            const checkboxes = document.querySelectorAll('input[name="students[]"]');
            checkboxes.forEach(cb => cb.checked = !isAllSelected);
            isAllSelected = !isAllSelected;
            toggleBtn.textContent = isAllSelected ? 'Deselect All' : 'Select All';
        });


        const searchInput = document.getElementById('studentSearch');
        searchInput.addEventListener('keyup', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.form-check').forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });



    
</script>
