import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                appStyles: 'resources/css/app.css',
                common: 'resources/js/common.js',
                commonStyles: 'resources/css/common.css',
                index: 'resources/js/index.js',
                indexStyles: 'resources/css/index.css',
                tasks: 'resources/js/tasks.js',
                tasksStyles: 'resources/css/tasks.css',
                department: 'resources/js/auth/department.js',
                userList: 'resources/js/auth/user-list.js',
                notes: 'resources/js/notes.js',
                notesStyles: 'resources/css/notes.css',
                noteView: 'resources/js/notes/note-view.js',
                noteEdit: 'resources/js/notes/note-edit.js',
                profileEdit: 'resources/js/profile/edit.js'
            },
        },
    }
});
