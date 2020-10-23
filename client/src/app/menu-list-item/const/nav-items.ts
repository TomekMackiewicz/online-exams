export const NAV_ITEMS = [
    {
        displayName: 'dashboard',
        iconName: 'dashboard',
        route: 'dashboard'
    },
    {
        displayName: 'surveys',
        iconName: 'fact_check',
        children: [
            {
                displayName: 'surveys',
                iconName: 'list',
                route: 'surveys',
            },
            {
                displayName: 'add',
                iconName: 'add',
                route: 'survey/add',
            }
        ]
    },
    {
        displayName: 'settings',
        iconName: 'settings',
        route: 'admin/settings'
    }     
];