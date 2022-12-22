<?php
// Aside menu

return [

    'items' => [
        // Dashboard
        [
            'title' => config('app.title'),
            'root' => true,
            'icon' => 'assets/media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => 'admin.dashboard',
            'new-tab' => false,
        ],

        [
            'section' => 'Custom',
        ],
        [
            'title' => 'admin.contacts_management',
            'icon' => 'assets/media/svg/icons/Communication/Incoming-box.svg',
            'bullet' => 'line',
            'page' => 'admin.contacts.index',
            'permission' => 'list contacts',
        ],

        // Admins & Roles & Permissions & Users
        [
            'section' => 'Custom',
        ],
        [
            'title' => 'admin.users_management',
            'icon' => 'assets/media/svg/icons/Communication/Group.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'admin.admins',
                    'permission' => 'list admins',
                    'bullet' => 'dot',
                    'submenu' => [
                        [
                            'title' => 'admin.all_admins',
                            'page' => 'admin.admins.index',
                            'permission' => 'list admins',
                        ],
                        [
                            'title' => 'admin.new_admin',
                            'page' => 'admin.admins.create',
                            'permission' => 'add admins',
                        ]
                    ]
                ],
//                [
//                    'title' => 'admin.users',
//                    'bullet' => 'dot',
//                    'permission' => 'list users',
//                    'submenu' => [
//                        [
//                            'title' => 'admin.all_users',
//                            'page' => 'admin.users.index',
//                            'permission' => 'list users',
//                        ],
//                        [
//                            'title' => 'admin.new_user',
//                            'page' => 'admin.users.create',
//                            'permission' => 'add users',
//                        ]
//                    ]
//                ],


                [
                    'title' => 'admin.roles',
                    'bullet' => 'dot',
                    'permission' => 'list roles',
                    'submenu' => [
                        [
                            'title' => 'admin.all_roles',
                            'page' => 'admin.roles.index',
                            'permission' => 'list roles',
                        ],
                        [
                            'title' => 'admin.new_role',
                            'page' => 'admin.roles.create',
                            'permission' => 'add roles',
                        ]
                    ]
                ]
            ]
        ],
        // Admin Settings
        [

            'title' => 'admin.settings',
            'icon' => 'assets/media/svg/icons/General/Settings-1.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'admin.general_settings',
                    'bullet' => 'dot',
                    'submenu' => [
                        [
                            'title' => 'admin.all_settings',
                            'page' => 'admin.settings.index',
                            'permission' => 'list settings',
                        ],
                        [
                            'title' => 'admin.new_settings',
                            'page' => 'admin.settings.create',
                            'permission' => 'add settings',
                        ]
                    ]
                ],
            ]
        ],
        // Notifications
        [
            'section' => 'Custom',
        ],
        [

            'title' => 'admin.notification',
            'icon' => 'assets/media/svg/icons/General/Notifications1.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'admin.all_notifications',
                    'page' => 'admin.notifications.index',
                    'bullet' => 'dot',
                    'permission' => 'list notifications',
                ],
                [
                    'title' => 'admin.new_notification',
                    'page' => 'admin.notifications.create',
                    'bullet' => 'dot',
                    'permission' => 'add notifications',
                ]
            ]
        ],

    ],
];
