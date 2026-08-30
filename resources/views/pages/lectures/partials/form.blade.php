@php $l = $lecture ?? null; @endphp

<form action="{{ $l ? route('lectures.update', $l->id) : route('lectures.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($l) @method('PUT') @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Batch <span class="tf-color-1">*</span></label>
            <select name="batch_id" class="select" required>
                <option value="">Select Batch</option>
                @foreach ($batches as $b)
                    <option value="{{ $b->id }}" @selected(old('batch_id', $l?->batch_id) == $b->id)>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- ✅ SYLLABUS DROPDOWN --}}
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Topic (Syllabus) <span class="tf-color-1">*</span></label>
            <select name="syllabus_id" class="select" id="syllabus_select" required>
                <option value="">Select Topic</option>
                @foreach ($syllabuses as $s)
                    <option value="{{ $s->id }}" @selected(old('syllabus_id', $l?->syllabus_id) == $s->id)>{{ $s->topic }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Lecture Date <span class="tf-color-1">*</span></label>
            <input type="date" name="lecture_date" class="form-control" value="{{ old('lecture_date', $l?->lecture_date?->format('Y-m-d') ?? date('Y-m-d')) }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">PDF (Optional — If it is not uploaded, the syllabus-related one will be applied.)</label>
            <input type="file" name="pdf" class="form-control" accept="application/pdf">

            {{-- ✅ AUTO PDF INFO BOX --}}
            <div id="autoPdfBox" class="text-tiny mt-2" style="display:none; color:#28a745;"></div>

            @if ($l && $l->pdf_path)
                <div class="text-tiny mt-2">Current: <a href="{{ $l->pdf_url }}" target="_blank" style="color:#5a5bd8;">View PDF</a></div>
            @endif
        </div>

        <div class="col-12 mb-3">
            <label class="body-title mb-10 d-block">Comments</label>
            <textarea name="comments" class="form-control" rows="3" placeholder="What was taught today...">{{ old('comments', $l?->comments) }}</textarea>
        </div>
    </div>

    <div class="flex items-center gap10 mt-20">
        <button type="submit" class="tf-button" style="background:#FF5200;color:#fff;">{{ $l ? 'Update Lecture' : 'Save Lecture' }}</button>
        <a href="{{ route('lectures.index') }}" class="tf-button" style="background:#6c757d;color:#fff;text-decoration:none;">Cancel</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Syllabus id => pdf url ka map
    const syllabusPdfs = @json($syllabuses->pluck('pdf_url', 'id'));

    const select = document.getElementById('syllabus_select');
    const box = document.getElementById('autoPdfBox');

    function showAutoPdf() {
        const url = syllabusPdfs[select.value];
        if (url) {
            box.innerHTML = '📎 Syllabus PDF auto-attach hogi: <a href="' + url + '" target="_blank" style="color:#5a5bd8;">View PDF</a>';
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    }

    select.addEventListener('change', showAutoPdf);
    showAutoPdf(); // Edit page par pehle se selected topic ki PDF dikhaye
});
</script>