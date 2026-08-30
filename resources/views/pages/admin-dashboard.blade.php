@extends('layout.master')

@section('content')
<div class="section-content-right">
    <div class="main-content">
        <div class="main-content-inner">
            <div class="main-content-wrap">

                {{-- ========== SECTION 1: 4 STAT CARDS ========== --}}
                <div class="tf-section-3 mb-30">

                    {{-- Card 1: Students --}}
                    <div class="wg-chart-default">
                        <div class="top">
                            <div class="flex items-center gap14">
                                <div class="image type-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 48 52" fill="none">
                                        <path d="M19.1094 2.12943C22.2034 0.343099 26.0154 0.343099 29.1094 2.12943L42.4921 9.85592C45.5861 11.6423 47.4921 14.9435 47.4921 18.5162V33.9692C47.4921 37.5418 45.5861 40.8431 42.4921 42.6294L29.1094 50.3559C26.0154 52.1423 22.2034 52.1423 19.1094 50.3559L5.72669 42.6294C2.63268 40.8431 0.726688 37.5418 0.726688 33.9692V18.5162C0.726688 14.9435 2.63268 11.6423 5.72669 9.85592L19.1094 2.12943Z" fill="#FF5200" />
                                    </svg>
                                    <span class="icon">
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.61976 16.1198C5.51618 15.2233 6.73199 14.7197 7.99973 14.7197H15.9997C17.2675 14.7197 18.4833 15.2233 19.3797 16.1198C20.2761 17.0162 20.7797 18.232 20.7797 19.4997V21.4997C20.7797 21.9305 20.4305 22.2797 19.9997 22.2797C19.5689 22.2797 19.2197 21.9305 19.2197 21.4997V19.4997C19.2197 18.6457 18.8805 17.8267 18.2766 17.2228C17.6727 16.619 16.8537 16.2797 15.9997 16.2797H7.99973C7.14573 16.2797 6.32671 16.619 5.72284 17.2228C5.11898 17.8267 4.77973 18.6457 4.77973 19.4997V21.4997C4.77973 21.9305 4.43051 22.2797 3.99973 22.2797C3.56894 22.2797 3.21973 21.9305 3.21973 21.4997V19.4997C3.21973 18.232 3.72333 17.0162 4.61976 16.1198Z" fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9997 4.27973C10.2214 4.27973 8.77973 5.72137 8.77973 7.49973C8.77973 9.27808 10.2214 10.7197 11.9997 10.7197C13.7781 10.7197 15.2197 9.27808 15.2197 7.49973C15.2197 5.72137 13.7781 4.27973 11.9997 4.27973ZM7.21973 7.49973C7.21973 4.85981 9.35981 2.71973 11.9997 2.71973C14.6396 2.71973 16.7797 4.85981 16.7797 7.49973C16.7797 10.1396 14.6396 12.2797 11.9997 12.2797C9.35981 12.2797 7.21973 10.1396 7.21973 7.49973Z" fill="white" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <div class="flex gap10 items-center">
                                        <div class="body-text mt-2 mb-4">Total Students</div>
                                        <div class="box-icon-trending up">
                                            <i class="icon-trending-up"></i>
                                            <div class="body-title number">Active</div>
                                        </div>
                                    </div>
                                    <h4>{{ $stats['students'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Batches --}}
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
                                        <div class="body-text mt-2 mb-4">Active Batches</div>
                                        <div class="box-icon-trending up">
                                            <i class="icon-trending-up"></i>
                                            <div class="body-title number">Running</div>
                                        </div>
                                    </div>
                                    <h4>{{ $stats['batches'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: Lectures --}}
                    <div class="wg-chart-default">
                        <div class="top">
                            <div class="flex items-center gap14">
                                <div class="image type-white">
                                    <svg width="52" height="52" viewBox="0 0 48 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.1084 2.12894C22.2024 0.34261 26.0144 0.342611 29.1084 2.12894L42.4911 9.85544C45.5851 11.6418 47.4911 14.943 47.4911 18.5157V33.9687C47.4911 37.5413 45.5851 40.8426 42.4911 42.6289L29.1084 50.3554C26.0144 52.1418 22.2024 52.1418 19.1084 50.3554L5.72571 42.6289C2.6317 40.8426 0.725712 37.5413 0.725712 33.9687V18.5157C0.725712 14.943 2.6317 11.6418 5.72571 9.85544L19.1084 2.12894Z" fill="#8F77F3" />
                                    </svg>
                                    <span class="icon">
                                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 4.5C3 3.67157 3.67157 3 4.5 3H15.5C16.3284 3 17 3.67157 17 4.5V16.5C17 17.3284 16.3284 18 15.5 18H4.5C3.67157 18 3 17.3284 3 16.5V4.5Z" fill="white" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <div class="flex gap10 items-center">
                                        <div class="body-text mt-2 mb-4">Total Lectures</div>
                                        <div class="box-icon-trending up">
                                            <i class="icon-trending-up"></i>
                                            <div class="body-title number">All time</div>
                                        </div>
                                    </div>
                                    <h4>{{ $stats['lectures'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 4: Syllabuses --}}
                    <div class="wg-chart-default">
                        <div class="top">
                            <div class="flex items-center gap14">
                                <div class="image type-white">
                                    <svg width="52" height="52" viewBox="0 0 48 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.1084 2.12894C22.2024 0.34261 26.0144 0.342611 29.1084 2.12894L42.4911 9.85544C45.5851 11.6418 47.4911 14.943 47.4911 18.5157V33.9687C47.4911 37.5413 45.5851 40.8426 42.4911 42.6289L29.1084 50.3554C26.0144 52.1418 22.2024 52.1418 19.1084 50.3554L5.72571 42.6289C2.6317 40.8426 0.725712 37.5413 0.725712 33.9687V18.5157C0.725712 14.943 2.6317 11.6418 5.72571 9.85544L19.1084 2.12894Z" fill="#2377FC" />
                                    </svg>
                                    <span class="icon">
                                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 4.5C4 3.67157 4.67157 3 5.5 3H14.5C15.3284 3 16 3.67157 16 4.5V16.5C16 17.3284 15.3284 18 14.5 18H5.5C4.67157 18 4 17.3284 4 16.5V4.5Z" fill="white" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <div class="flex gap10 items-center">
                                        <div class="body-text mt-2 mb-4">Syllabuses</div>
                                        <div class="box-icon-trending up">
                                            <i class="icon-trending-up"></i>
                                            <div class="body-title number">Active</div>
                                        </div>
                                    </div>
                                    <h4>{{ $stats['syllabuses'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            

                {{-- ========== SECTION 3: RECENT LECTURES + RECENT STUDENTS ========== --}}
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
                                <li><div class="body-title text-main-dark">Batch</div></li>
                                <li><div class="body-title text-main-dark">Topic</div></li>
                                <li><div class="body-title text-main-dark">Teacher</div></li>
                                <li><div class="body-title text-main-dark">Status</div></li>
                            </ul>
                            <div class="divider mb-14"></div>
                            <ul class="flex flex-column has-divider-line has-line-bot">
                                @forelse ($recentLectures as $l)
                                    <li class="item wg-product gap20">
                                        <div class="body-text text-main-dark mt-4">{{ $l->lecture_date?->format('d M Y') }}</div>
                                        <div class="body-text text-main-dark mt-4">{{ $l->batch?->name ?? '-' }}</div>
                                        <div class="title mb-0"><a href="#" class="body-text">{{ $l->syllabus?->topic ?? '-' }}</a></div>
                                        <div class="body-text text-main-dark mt-4">{{ $l->teacher?->name ?? '-' }}</div>
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

                    {{-- Recent Students --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between">
                            <h5>Recent Students</h5>
                            <a href="{{ route('students.index') }}" class="body-text" style="color:#FF5200; text-decoration:none;">View All →</a>
                        </div>
                        <ul class="flex flex-column h-full has-divider-line">
                            @forelse ($recentStudents as $s)
                                <li class="wg-product">
                                    <div class="name flex-grow">
                                        <div class="image" style="background:#FF5200; width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold;">
                                            {{ strtoupper(substr($s->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="title"><a href="#" class="body-text">{{ $s->name }}</a></div>
                                            <div class="price text-tiny">{{ $s->email }}</div>
                                        </div>
                                    </div>
                                   
                                </li>
                            @empty
                                <li class="text-center body-text" style="padding:20px;">No students yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection