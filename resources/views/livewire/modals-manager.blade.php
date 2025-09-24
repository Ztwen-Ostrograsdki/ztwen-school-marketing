<div>
    @auth
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


        <button data-modal-target="school-cover-image-editor-modal" data-modal-toggle="school-cover-image-editor-modal" class="hidden" type="button"></button>
        @livewire('modals.manage-school-cover-image-modal')
        
        <button data-modal-target="school-description-manager-modal" data-modal-toggle="school-description-manager-modal" class="hidden" type="button"></button>
        @livewire('modals.manage-school-description-modal')
        
        
        <button data-modal-target="school-videos-manager-modal" data-modal-toggle="school-videos-manager-modal" class="hidden" type="button"></button>
        @livewire('modals.school-videos-manager')

        <button data-modal-target="assistant-manager-modal" data-modal-toggle="assistant-manager-modal" class="hidden" type="button"></button>
        @livewire('modals.assistant-manager-modal')
        
        <button data-modal-target="school-image-editor-modal" data-modal-toggle="school-image-editor-modal" class="hidden" type="button"></button>
        @livewire('modals.school-image-edition-modal')

        <button data-modal-target="user-quotes-manager-modal" data-modal-toggle="user-quotes-manager-modal" class="hidden" type="button"></button>
        @livewire('modals.quote-manager-modal')

        <button data-modal-target="logout-modal" data-modal-toggle="logout-modal" class="hidden" type="button"></button>
        @livewire('auth.logout-page')
        
        {{-- USER MODALS START --}}
        
        
        
        {{-- ADMIN MODALS START --}}



        {{-- ADMIN MODALS END --}}
    @endauth
</div>
