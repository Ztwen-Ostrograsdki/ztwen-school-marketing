<div>
    {{-- USER MODALS START --}}
    <button data-modal-target="add-new-assistant-modal" data-modal-toggle="add-new-assistant-modal" class="hidden" type="button"></button>
    @livewire('modals.new-assistant-modal')

    <button data-modal-target="stats-manager-modal" data-modal-toggle="stats-manager-modal" class="hidden" type="button"></button>
    @livewire('modals.stats-manager-modal')
    
    <button data-modal-target="infos-manager-modal" data-modal-toggle="infos-manager-modal" class="hidden" type="button"></button>
    @livewire('modals.communique-manager-modal')

    <button data-modal-target="role-permissions-manager-modal" data-modal-toggle="role-permissions-manager-modal" class="hidden" type="button"></button>
    @livewire('modals.manage-role-permissions-modal')
    
    <button data-modal-target="role-users-manager-modal" data-modal-toggle="role-users-manager-modal" class="hidden" type="button"></button>
    @livewire('modals.manage-user-roles-modal')

    <button data-modal-target="school-images-manager-modal" data-modal-toggle="school-images-manager-modal" class="hidden" type="button"></button>
    @livewire('modals.school-images-manager')


    <button data-modal-target="logout-modal" data-modal-toggle="logout-modal" class="hidden" type="button"></button>
    @livewire('auth.logout-page')

    {{-- USER MODALS START --}}
    
    
    
    {{-- ADMIN MODALS START --}}



    {{-- ADMIN MODALS END --}}
</div>
