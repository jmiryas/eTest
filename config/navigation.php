<?php

$nav = [
    "General" => [
        [
            "title" => "Home",
            "icon" => '<i class="menu-icon bx bx-home"></i>', // Home
            'route' => 'dashboard',
            'permissions' => null
        ],
        [
            "title" => "Master",
            "icon" => '<i class="menu-icon bx bx-folder"></i>', // Master Data
            "submenus" => [
                [
                    'title' => 'Peserta',
                    'route' => 'peserta.index',
                    'permissions' => ['etest peserta view'],
                    'icon' => '<i class="menu-icon bx bx-user"></i>', // user
                ],
                [
                    'title' => 'Course',
                    'route' => 'course.index',
                    'permissions' => ['etest course view'],
                    'icon' => '<i class="menu-icon bx bx-book-content"></i>', // course = buku dengan konten
                ],
                [
                    'title' => 'Modul',
                    'route' => 'modul.index',
                    'permissions' => ['etest modul view'],
                    'icon' => '<i class="menu-icon bx bx-file"></i>', // modul = dokumen
                ],
                [
                    'title' => 'Modul Section',
                    'route' => 'modul-detail.index',
                    'permissions' => ['etest modul-detail view'],
                    'icon' => '<i class="menu-icon bx bx-git-branch"></i>', // section = bagian/cabang
                ],
                [
                    'title' => 'Bank Soal',
                    'route' => 'banksoal.index',
                    'permissions' => ['etest banksoal view'],
                    'icon' => '<i class="menu-icon bx bx-book-open"></i>',
                ],
                [
                    'title' => 'Opsi Bank Soal',
                    'route' => 'banksoal-detail.index',
                    'permissions' => ['etest banksoal-detail view'],
                    'icon' => '<i class="menu-icon bx bx-task"></i>',
                ],
            ],
        ],
        [
            "title" => "Back Office",
            "icon" => '<i class="menu-icon bx bx-briefcase"></i>', // back office = kerjaan kantor
            "submenus" => [
                [
                    'title' => 'Course Enrollment',
                    'route' => 'course-detail.index',
                    'permissions' => ['etest course-detail view'],
                    'icon' => '<i class="menu-icon bx bx-user-plus"></i>' // enrollment = tambah peserta
                ],
                [
                    'title' => 'Paket Soal',
                    'route' => 'soal.index',
                    'permissions' => ['etest soal view'],
                    'icon' => '<i class="menu-icon bx bx-help-circle"></i>', // soal = tanda tanya
                ],
                [
                    'title' => 'Opsi Paket Soal',
                    'route' => 'soal-detail.index',
                    'permissions' => ['etest soal-detail view'],
                    'icon' => '<i class="menu-icon bx bx-list-ol"></i>', // opsi jawaban = list bernomor
                ],
            ],
        ],
    ],
    "Peserta" => [
        [
            "title" => "My Course",
            "icon" => '<i class="menu-icon bx bx-book-reader"></i>', // My Course
            'route' => 'course.my-course',
            'permissions' => ['etest course view-peserta'],
        ]
    ],
    "Log" => [
        [
            "title" => "Log",
            "icon" => '<i class="menu-icon bx bx-history"></i>', // Log/riwayat
            "submenus" => [
                [
                    'title' => 'Progress Peserta',
                    'route' => 'progress-user.index',
                    'permissions' => ['etest progress-user view'],
                    'icon' => '<i class="menu-icon bx bx-task"></i>' // progress/tugas
                ],
                [
                    "title" => "Jawaban Peserta",
                    "icon" => '<i class="menu-icon bx bx-message-square-detail"></i>', // jawaban/detail
                    'route' => 'user-answer.index',
                    'permissions' => ['etest user-answer view'],
                ],
            ],
        ],
    ],
    "Misc" => [
        [
            "title" => "Manajemen Users",
            "icon" => '<i class="menu-icon bx bx-user-pin"></i>', // Manajemen Users
            "submenus" => [
                [
                    'title' => 'Users',
                    'route' => 'users.index',
                    'permissions' => ['etest user view'],
                    'icon' => '<i class="menu-icon bx bx-user"></i>', // Users
                ],
                [
                    'title' => 'Roles',
                    'route' => 'roles.index',
                    'permissions' => ['etest role & permission view'],
                    'icon' => '<i class="menu-icon bx bx-shield"></i>', // Roles
                ],
            ],
        ],
    ]
];

return $nav;
