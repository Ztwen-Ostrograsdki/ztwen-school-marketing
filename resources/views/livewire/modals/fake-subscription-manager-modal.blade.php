<div  wire:ignore.self id="{{str_replace('#', '', $modal_name)}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-black/60 border border-sky-500 rounded-lg shadow-2xl">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-sm font-semibold text-lime-400 letter-spacing-1">
                    <span class="fas fa-user-plus mr-1.5"></span>
                    Attribution d'un abonnement à l'école
                    <span>
                        @if ($school)
                            {{ $school->name }}
                        @endif
                    </span>
                </h3>
                <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form wire:submit.prevent="insert" class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-1">
                        <label for="pack" class="block mb-2 text-sm text-amber-400 font-medium ">Le pack</label>
                        <select wire:model='pack_id' id="pack" class="bg-transparent border border-sky-400 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option class="text-sm text-white py-1.5 bg-black" >Selectionner le pack</option>
                            @foreach ($packs as $p => $pack)
                                <option @if($pack->is_active == false) disabled title='Ce pack est inactif'  @endif class="text-white py-1.5 bg-black @if($pack->is_active == false) disabled  @endif"  value="{{$pack->id}}">{{$pack->name}}</option>
                            @endforeach
                        </select>
                        @error('pack_id')
                            <p  class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                            {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="col-span-1">
                        <label for="days" class="block mb-2 text-sm text-amber-400 font-medium ">Nombre de jours</label>
                        <input name="days" wire:model.live="days" id="days" name="start" type="number" class="bg-transparent border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 bg-neutral-secondary-medium border border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand px-3 shadow-xs placeholder:text-body" placeholder="Le nombre de jours">
                        @error('days')
                            <p  class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                            {{ $message }}
                            </p>
                        @enderror
                    </div>
                   
                    <div class="col-span-2">
                        <div 
                            x-data="dateManager(
                                @entangle('start'),
                                @entangle('end'),
                                @entangle('days')
                            )"
                            class="flex justify-between gap-x-1">

                        <!-- DATE DEBUT -->
                            <div wire:ignore>
                                <label class="block mb-2 text-sm text-amber-400 font-medium ">Date début</label>
                                <input x-ref="startInput" type="text" class="p-2 text-sky-200 text-sm letter-spacing-1 rounded-sm  bg-transparent" placeholder="La date de début" />
                                @error('start')
                                    <p  class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                    {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- DATE FIN -->
                            <div wire:ignore>
                                <label class="block mb-2 text-sm text-amber-400 font-medium ">Date fin</label>
                                <input x-ref="endInput" type="text" class="p-2 text-sky-200 text-sm letter-spacing-1 rounded-sm  bg-transparent"  placeholder="La date de clôture"/>
                                @error('end')
                                    <p  class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                    {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <span wire:click.prevent="insert"  class="text-black cursor-pointer flex w-full mx-auto justify-center items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-sky-500 hover:bg-sky-700 focus:ring-blue-800 letter-spacing-1 border border-sky-600">
                    <span wire:loading.remove wire:target='insert'>
                        <span class="fas fa-user-check mr-1.5"></span>
                        Valider
                    </span>
                    <span class="" wire:loading wire:target='insert'>
                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                        <span>Enregistrement en cours...</span>
                    </span>
                </span>
            </form>
        </div>
    </div>
</div>
<script>
function dateManager(start, end, days) {
    return {
        start,
        end,
        days,
        startPicker: null,
        endPicker: null,

        init() {
            // START
            this.startPicker = flatpickr(this.$refs.startInput, {
                dateFormat: 'd/m/Y',
                minDate: 'today',
                allowInput: false,
                onChange: (selectedDates, dateStr) => {
                    this.start = dateStr;
                }
            });

            // END
            this.endPicker = flatpickr(this.$refs.endInput, {
                dateFormat: 'd/m/Y',
                minDate: this.start || 'today',
                allowInput: false,
                onChange: (selectedDates, dateStr) => {
                    this.end = dateStr;
                }
            });

            // 🔁 WATCH START
            this.$watch('start', (val) => {
                if (!val) return;

                this.startPicker.setDate(val, true);
                this.endPicker.set('minDate', val);

                if (this.end) {
                    this.calculateDays();
                } else if (this.days) {
                    this.calculateEnd();
                }
            });

            // 🔁 WATCH END
            this.$watch('end', (val) => {
                if (!val) return;

                this.endPicker.setDate(val, true);

                if (this.start) {
                    this.calculateDays();
                } else if (this.days) {
                    this.calculateStart();
                }
            });

            // 🔁 WATCH DAYS
            this.$watch('days', (val) => {
                if (!val || val < 1) return;

                if (this.start) {
                    this.calculateEnd();
                } else if (this.end) {
                    this.calculateStart();
                }
            });
        },

        // 🧠 UTIL
        parse(dateStr) {
            const [d,m,y] = dateStr.split('/');
            return new Date(`${y}-${m}-${d}`);
        },

        format(date) {
            let d = String(date.getDate()).padStart(2, '0');
            let m = String(date.getMonth() + 1).padStart(2, '0');
            let y = date.getFullYear();
            return `${d}/${m}/${y}`;
        },

        // 🧮 CALCULS

        calculateDays() {
            let startDate = this.parse(this.start);
            let endDate = this.parse(this.end);

            let diff = (endDate - startDate) / (1000 * 60 * 60 * 24);

            this.days = diff >= 0 ? diff + 1 : 1;
        },

        calculateEnd() {
            let startDate = this.parse(this.start);
            let endDate = new Date(startDate);

            endDate.setDate(endDate.getDate() + parseInt(this.days) - 1);

            this.end = this.format(endDate);
        },

        calculateStart() {
            let endDate = this.parse(this.end);
            let startDate = new Date(endDate);

            startDate.setDate(startDate.getDate() - parseInt(this.days) + 1);

            this.start = this.format(startDate);
        }
    }
}
</script>