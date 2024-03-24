<x-self.menu-item route="tasks">
    <i class="bi bi-card-checklist mr-2"></i>Task Board
</x-self.menu-item>
<x-self.menu-item route="notes">
    <i class="bi bi-journal-text mr-2"></i>Notes
</x-self.menu-item>
<x-self.menu-item route="dashboard">
    <i class="bi bi-person-circle mr-2"></i>My Page
</x-self.menu-item>
@can('access to admin')
    <x-self.menu-item route="admin">
        <i class="bi bi-menu-up mr-2"></i>Admin Menu
    </x-self.menu-item>
@endcan
@can('access to manager')
    <x-self.menu-item route="manager">
        <i class="bi bi-menu-button mr-2"></i>Manager Menu
    </x-self.menu-item>
@endcan
