<div>
    {{-- USER MODALS START --}}
    <button data-modal-target="add-new-assistant-modal" data-modal-toggle="add-new-assistant-modal" class="hidden" type="button"></button>
    @livewire('modals.new-assistant-modal')

    <button data-modal-target="stats-manager-modal" data-modal-toggle="stats-manager-modal" class="hidden" type="button"></button>
    @livewire('modals.stats-manager-modal')
    
    <button data-modal-target="infos-manager-modal" data-modal-toggle="infos-manager-modal" class="hidden" type="button"></button>
    @livewire('modals.communique-manager-modal')

    {{-- USER MODALS START --}}
    
    
    
    {{-- ADMIN MODALS START --}}



    {{-- ADMIN MODALS END --}}
</div>
