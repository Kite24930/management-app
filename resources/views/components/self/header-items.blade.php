
<x-self.menu-item route="tasks">
    <i class="bi bi-card-checklist mr-2"></i>Task Board
</x-self.menu-item>
<x-self.menu-item route="dashboard">
    <i class="bi bi-person-circle mr-2"></i>My Page
</x-self.menu-item>
@can('access to admin')

@endcan
@can('access to manager')

@endcan
