@extends('layout.master')

@section('content')
<div class="section-content-right">
    <div class="main-content">
        <div class="main-content-inner">
            <div class="main-content-wrap">

                @if (!$student || !$student->batch_id)
                    {{-- No batch assigned --}}
                    <div class="wg-box p-40 mb-30" style="background:linear-gradient(135deg, #FF5200 0%, #ff8547 100%); color:#fff; border-radius:12px;">
                        <h3 style="color:#fff;">Welcome, {{ auth()->user()->name }}! 👋</h3>
                        <p style="color:rgba(255,255,255,0.9); margin-top:10px;">
                            Your student profile has been created, but a batch has not yet been assigned. Please contact your teacher or administrator so you can view your daily lectures.
                        </p>
                    </div>
                @else

                {{-- ========== SECTION 1: 4 STAT CARDS ========== --}}
                <div class="tf-section-3 mb-30">

                    {{-- Card 1: Total Topics --}}
                    <div class="wg-chart-default">
                        <div class="top">
                            <div class="flex items-center gap14">
                                <div class="image type-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 48 52" fill="none">
                                        <path d="M19.1094 2.12943C22.2034 0.343099 26.0154 0.343099 29.1094 2.12943L42.4921 9.85592C45.5861 11.6423 47.4921 14.9435 47.4921 18.5162V33.9692C47.4921 37.5418 45.5861 40.8431 42.4921 42.6294L29.1094 50.3559C26.0154 52.1423 22.2034 52.1423 19.1094 50.3559L5.72669 42.6294C2.63268 40.8431 0.726688 37.5418 0.726688 33.9692V18.5162C0.726688 14.9435 2.63268 11.6423 5.72669 9.85592L19.1094 2.12943Z" fill="#FF5200" />
                                    </svg>
                                    <span class="icon">
                                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 4.5C3 3.67157 3.67157 3 4.5 3H15.5C16.3284 3 17 3.67157 17 4.5V16.5C17 17.3284 16.3284 18 15.5 18H4.5C3.67157 18 3 17.3284 3 16.5V4.5Z" fill="white" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <div class="flex gap10 items-center">
                                        <div class="body-text mt-2 mb-4">Topics Covered</div>
                                        <div class="box-icon-trending up">
                                            <i class="icon-trending-up"></i>
                                            <div class="body-title number">{{ $progress }}%</div>
                                        </div>
                                    </div>
                                    <h4>{{ $stats['topics'] }} / {{ $totalSyllabus }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Total Lectures --}}
                    <div class="wg-chart-default">
                        <div class="top">
                            <div class="flex items-center gap14">
                                <div class="image type-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 48 52" fill="none">
                                        <path d="M19.1094 2.12943C22.2034 0.343099 26.0154 0.343099 29.1094 2.12943L42.4921 9.85592C45.5861 11.6423 47.4921 14.9435 47.4921 18.5162V33.9692C47.4921 37.5418 45.5861 40.8431 42.4921 42.6294L29.1094 50.3559C26.0154 52.1423 22.2034 52.1423 19.1094 50.3559L5.72669 42.6294C2.63268 40.8431 0.726688 37.5418 0.726688 33.9692V18.5162C0.726688 14.9435 2.63268 11.6423 5.72669 9.85592L19.1094 2.12943Z" fill="#22C55E" />
                                    </svg>
                                    <span class="icon">
                                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.25C5.44365 2.25 1.75 5.94365 1.75 10.5C1.75 15.0563 5.44365 18.75 10 18.75C14.5563 18.75 18.25 15.0563 18.25 10.5C18.25 5.94365 14.5563 2.25 10 2.25Z" fill="white" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <div class="flex gap10 items-center">
                                        <div class="body-text mt-2 mb-4">Total Lectures</div>
                                        <div class="box-icon-trending up">
                                            <i class="icon-trending-up"></i>
                                            <div class="body-title number">Attended</div>
                                        </div>
                                    </div>
                                    <h4>{{ $stats['lectures'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: Assignments (PDFs) --}}
                    <div class="wg-chart-default">
                        <div class="top">
                            <div class="flex items-center gap14">
                                <div class="image type-white">
                                    <svg width="52" height="52" viewBox="0 0 48 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.1084 2.12894C22.2024 0.34261 26.0144 0.342611 29.1084 2.12894L42.4911 9.85544C45.5851 11.6418 47.4911 14.943 47.4911 18.5157V33.9687C47.4911 37.5413 45.5851 40.8426 42.4911 42.6289L29.1084 50.3554C26.0144 52.1418 22.2024 52.1418 19.1084 50.3554L5.72571 42.6289C2.6317 40.8426 0.725712 37.5413 0.725712 33.9687V18.5157C0.725712 14.943 2.6317 11.6418 5.72571 9.85544L19.1084 2.12894Z" fill="#8F77F3" />
                                    </svg>
                                    <span class="icon">
                                        <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 1.5C9.82674 1.5 9.25525 1.94413 9.06623 2.55717C9.02336 2.69622 9 2.84469 9 3H13.5C13.5 2.84469 13.4766 2.69622 13.4338 2.55717C13.2448 1.94413 12.6733 1.5 12 1.5H10.5Z" fill="white" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <div class="flex gap10 items-center">
                                        <div class="body-text mt-2 mb-4">Assignments</div>
                                        <div class="box-icon-trending up">
                                            <i class="icon-trending-up"></i>
                                            <div class="body-title number">PDFs</div>
                                        </div>
                                    </div>
                                    <h4>{{ $stats['assignments'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 4: Upcoming --}}
                    <div class="wg-chart-default">
                        <div class="top">
                            <div class="flex items-center gap14">
                                <div class="image type-white">
                                    <svg width="52" height="52" viewBox="0 0 48 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.1084 2.12894C22.2024 0.34261 26.0144 0.342611 29.1084 2.12894L42.4911 9.85544C45.5851 11.6418 47.4911 14.943 47.4911 18.5157V33.9687C47.4911 37.5413 45.5851 40.8426 42.4911 42.6289L29.1084 50.3554C26.0144 52.1418 22.2024 52.1418 19.1084 50.3554L5.72571 42.6289C2.6317 40.8426 0.725712 37.5413 0.725712 33.9687V18.5157C0.725712 14.943 2.6317 11.6418 5.72571 9.85544L19.1084 2.12894Z" fill="#2377FC" />
                                    </svg>
                                    <span class="icon">
                                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.25C5.44365 2.25 1.75 5.94365 1.75 10.5C1.75 15.0563 5.44365 18.75 10 18.75C14.5563 18.75 18.25 15.0563 18.25 10.5C18.25 5.94365 14.5563 2.25 10 2.25Z" fill="white" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <div class="flex gap10 items-center">
                                        <div class="body-text mt-2 mb-4">Upcoming</div>
                                        <div class="box-icon-trending up">
                                            <i class="icon-trending-up"></i>
                                            <div class="body-title number">Scheduled</div>
                                        </div>
                                    </div>
                                    <h4>{{ $stats['upcoming'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== SECTION 2: MY PROGRESS + TOPICS + UPCOMING ========== --}}
                <div class="tf-section-1 mb-30">

                    {{-- Learning Progress Chart --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between">
                            <h5>My Learning Journey — {{ $student->batch->name }}</h5>
                            <div class="dropdown default style-box">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <span class="view-all">Last 7 Days <i class="icon-chevron-down"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap40">
                            <div>
                                <div class="mb-1"><div class="block-legend"><div class="dot t3"></div><div class="text-tiny">Daily Lectures</div></div></div>
                                <div class="flex items-center gap12"><h4>{{ array_sum(array_column($activity, 'count')) }}</h4></div>
                            </div>
                            <div>
                                <div class="mb-1"><div class="block-legend"><div class="dot t5"></div><div class="text-tiny">Syllabus Progress</div></div></div>
                                <div class="flex items-center gap12">
                                    <h4>{{ $progress }}%</h4>
                                    <div class="box-icon-trending up"><i class="icon-trending-up"></i><div class="body-title number">{{ $coveredTopics }}/{{ $totalSyllabus }}</div></div>
                                </div>
                            </div>
                        </div>
                        <div id="line-chart-7"></div>
                    </div>

                    <div class="flex gap20 flex-wrap-mobile">

                        {{-- Syllabus Progress Donut --}}
                        <div class="wg-box w-half">
                            <div class="flex items-center justify-between">
                                <h5>Syllabus Completion</h5>
                            </div>
                            <div class="donut-wrap mb-6">
                                <div class="morris-donut" id="morris-donut-1"></div>
                                <div class="center">
                                    <div class="center-inner">
                                        <p class="center-title">Completed</p>
                                        <div class="center-value">{{ $progress }}%</div>
                                        <div class="text-tiny text-surface-2">{{ $coveredTopics }} of {{ $totalSyllabus }} topics</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap15 justify-center">
                                <div class="block-legend style-1">
                                    <div class="dot t3"></div>
                                    <div class="text-tiny">Covered ({{ $coveredTopics }})</div>
                                </div>
                                <div class="block-legend style-1">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Remaining ({{ $totalSyllabus - $coveredTopics }})</div>
                                </div>
                            </div>
                        </div>

                        {{-- Top Topics (repeated learning) --}}
                        <div class="wg-box w-half">
                            <div class="flex items-center justify-between">
                                <h5>Most Covered Topics</h5>
                            </div>
                            <ul class="flex flex-column h-full has-divider-line">
                                @forelse ($topTopics as $syllabusId => $count)
                                    @php $topic = $syllabusDetails[$syllabusId] ?? null; @endphp
                                    @if ($topic)
                                        <li class="wg-product">
                                            <div class="name flex-grow">
                                                <div class="image" style="background:#FF5200; width:40px; height:40px; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold;">
                                                    {{ $loop->iteration }}
                                                </div>
                                                <div>
                                                    <div class="title"><a href="#" class="body-text">{{ $topic->topic }}</a></div>
                                                    <div class="price text-tiny">{{ $topic->short_details ? \Illuminate\Support\Str::limit($topic->short_details, 40) : 'Syllabus topic' }}</div>
                                                </div>
                                            </div>
                                            <div class="sale body-text">{{ $count }}×</div>
                                        </li>
                                    @endif
                                @empty
                                    <li class="text-center body-text" style="padding:20px;">No topics covered yet.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- ========== SECTION 3: RECENT + UPCOMING ========== --}}
                <div class="tf-section-4">

                    {{-- Recent Lectures Table --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between">
                            <h5>Recent Lectures</h5>
                            <a href="{{ route('lectures.index') }}" class="body-text" style="color:#FF5200; text-decoration:none;">View All →</a>
                        </div>
                        <div class="wg-table table-recent-orders">
                            <ul class="table-title flex gap20 mb-14">
                                <li><div class="body-title text-main-dark">Date</div></li>
                                <li><div class="body-title text-main-dark">Topic</div></li>
                                <li><div class="body-title text-main-dark">Teacher</div></li>
                                <li><div class="body-title text-main-dark">PDF</div></li>
                                <li><div class="body-title text-main-dark">Status</div></li>
                            </ul>
                            <div class="divider mb-14"></div>
                            <ul class="flex flex-column has-divider-line has-line-bot">
                                @forelse ($recentLectures as $l)
                                    <li class="item wg-product gap20">
                                        <div class="body-text text-main-dark mt-4">{{ $l->lecture_date?->format('d M Y') }}</div>
                                        <div class="title mb-0"><a href="#" class="body-text">{{ $l->syllabus?->topic ?? '-' }}</a></div>
                                        <div class="body-text text-main-dark mt-4">{{ $l->teacher?->name ?? '-' }}</div>
                                        <div class="body-text text-main-dark mt-4">
                                            @if ($l->pdf_path)
                                                <a href="{{ $l->pdf_url }}" target="_blank" style="color:#FF5200;">View</a>
                                            @else - @endif
                                        </div>
                                        <div>
                                            @if ($l->lecture_date && $l->lecture_date->isPast())
                                                <div class="block-available fw-7">Completed</div>
                                            @else
                                                <div class="block-pending fw-7">Upcoming</div>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center body-text" style="padding:20px;">No lectures yet.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    {{-- Upcoming Lectures --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between">
                            <h5>Upcoming Classes</h5>
                        </div>
                        <ul class="flex flex-column h-full has-divider-line">
                            @forelse ($upcomingLectures as $l)
                                <li class="wg-product">
                                    <div class="name flex-grow">
                                        <div class="image" style="background:#22C55E; width:40px; height:40px; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; flex-direction:column; line-height:1;">
                                            <div style="font-size:14px;">{{ $l->lecture_date?->format('d') }}</div>
                                            <div style="font-size:9px;">{{ $l->lecture_date?->format('M') }}</div>
                                        </div>
                                        <div>
                                            <div class="title"><a href="#" class="body-text">{{ $l->syllabus?->topic ?? '-' }}</a></div>
                                            <div class="price text-tiny">by {{ $l->teacher?->name ?? 'Teacher' }}</div>
                                        </div>
                                    </div>
                                    <div class="sale body-text">
                                        <span style="background:#cfe2ff;color:#084298;padding:3px 8px;border-radius:4px;font-size:11px;">
                                            {{ $l->lecture_date?->diffForHumans() }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center body-text" style="padding:20px;">No upcoming classes scheduled.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if ($student && $student->batch_id)
    // Line chart: 7-day activity
    const activity = @json($activity);
    if (typeof ApexCharts !== 'undefined') {
        new ApexCharts(document.querySelector("#line-chart-7"), {
            series: [{ name: 'Lectures', data: activity.map(a => a.count) }],
            chart: { type: 'area', height: 280, toolbar: { show: false } },
            colors: ['#FF5200'],
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 } },
            xaxis: { categories: activity.map(a => a.date) },
            dataLabels: { enabled: false },
            grid: { borderColor: '#f1f1f1' },
        }).render();

        // Donut: Syllabus completion
        const covered = {{ $coveredTopics }};
        const remaining = {{ max(0, $totalSyllabus - $coveredTopics) }};
        new ApexCharts(document.querySelector("#morris-donut-1"), {
            series: [covered, remaining],
            chart: { type: 'donut', height: 280 },
            labels: ['Covered', 'Remaining'],
            colors: ['#22C55E', '#e5e7eb'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: { pie: { donut: { size: '75%' } } },
        }).render();
    }
    @endif
});
</script>
@endpush
@endsection