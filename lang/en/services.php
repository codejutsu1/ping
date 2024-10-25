<?php

return [
    'v1' => [
        'create' => [
            'success' => 'Your service will be created in the background.',
            'failure' => 'You must verify your email before creating a new service.',
        ],
        'show' => [
            'failure' => 'You are not able to view a service that you do not own.',
        ],
        'update' => [
            'success' => 'Your service will be updated in the background.',
            'failure' => 'You are not authorized to update a service that you do not own.',
        ],
        'delete' => [
            'success' => 'Your service will be deleted in the background.',
            'failure' => 'You are not authorized to delete a service that you do not own.',
        ],
    ],
];
